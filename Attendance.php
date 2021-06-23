<?php
    include "includes/db_connection.php";
    class Attendance{
        private $db;
        public $timein;
        public $timeout;


        function __construct($db){
            $this->db = $db;
        }


        function checkRecord($emp_id, $date){
            $query = "SELECT * FROM attendance WHERE emp_id=".$emp_id." AND date='".$date."'";
            $record = mysqli_query($this->db, $query);
            $hour = date("H");
            if($record->num_rows > 0){
                $row = $record->fetch_assoc();
                $this->timein = $row["time_in"];
                $this->timeout = $row["time_out"];
                echo "<div id='myModal' class='modal' style='display:block'><div class='modal-content'><span class='close' style='text-align:right' onclick='closefunc()'>&times;</span>
                      <p><div class='abc'><p><h2>Attendance</h2></p></div></p>";
                if($this->timein == "" && $row['a_status'] != '^'){
                      echo  "<input type='text' id='timein' name='timein' value='".$this->timein."' readonly/><br>
                        <button style='width: 20%' class='timein_btn btn btn-primary' >Time In</button>";
                }
                else{
                    echo "<input type='text' id='timein' name='timein' value='".$this->timein."' readonly/>";
                }
                if($this->timeout == "" && $row['a_status'] != '^'){
                    echo "<br><br><input type='text' id='timeout' name='timeout' value='".$this->timeout."' readonly><br>
                        <button style='width: 20%' class='timeout_btn btn btn-primary'>Time Out</button><br><button style='width: 100%; height:50px;' class='markattendance btn btn-danger' id='markatt' formmethod='get'>Save</button></div>";
                }
                else{
                    echo "<br><br><input type='text' id='timeout' name='timeout' value='".$this->timeout."' readonly><br></div>";
                }
            }
            else{
                echo "<div id='myModal' class='modal' style='display:block'><div class='modal-content'><span class='close' style='text-align:right' onclick='closefunc()'>&times;</span>
                    <p><div class='abc'><p><h2>Attendance</h2></p></div></p><input type='text' id='timein' name='timein' placeholder='HH:MM' readonly/><br>
                    ";
                if($hour <= 12){
                    echo "<button style='width: 20%' class='timein_btn btn btn-primary' >Time In</button>";
                }

                echo "<br><br><input type='text' id='timeout' name='timeout' placeholder='HH:MM' readonly><br>";

                if($hour <= 12){
                    echo "<button style='width: 20%' class='timeout_btn btn btn-primary'>Time Out</button><br><button style='width: 100%; height:50px;' class='markattendance btn btn-danger' id='markatt' formmethod='get'>Save</button>
                          </div>";
                }

            }

        }

        function markAttendance($emp_id, $time_in, $time_out, $date, $hour){
             $query = "SELECT * FROM attendance WHERE emp_id=".$emp_id." AND date='".$date."'";
            $record = mysqli_query($this->db, $query);
            $status = "P";
            if($hour >= 11 && $hour < 12){
                $status = "L";
            }
            if($record->num_rows > 0) {
                $row = $record->fetch_assoc();
                if($row['time_in'] == ""){
                    $query = "UPDATE attendance SET time_in='".$time_in."' WHERE emp_id=".$emp_id;
                    mysqli_query($this->db, $query);
                }
                elseif($row['time_out'] == ""){
                    $query = "UPDATE attendance SET time_out='".$time_out."' WHERE emp_id=".$emp_id;
                    mysqli_query($this->db, $query);
                }
            }
            else{
                //$curr_date = date('d/m/Y');
                $query = "INSERT INTO attendance VALUES('".$emp_id."','".$date."','".$time_in."','".$time_out."','".$status."')";
                $record = mysqli_query($this->db, $query);
                if($record === TRUE){
                    echo "Record inserted";
                }
                else{
                    echo "Failed";
                }
            }
        }

        function showAttendance($date){

            $query = 'SELECT A.emp_id, E.name, A.date, A.time_in, A.time_out, A.a_status 
                      FROM attendance AS A INNER JOIN Employees AS E ON A.emp_id = E.emp_id WHERE A.date="'.$date.'"';
            $record = mysqli_query($this->db, $query);
            if($record->num_rows > 0){
                echo "<table><tr><th>Employee ID</th><th>Employee Name</th><th>Date</th><th>Time In</th><th>Time Out</th><th>Status</th></tr>";
                while($row = $record->fetch_assoc()){
                    echo "<tr><td>".$row['emp_id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['date']."</td>";
                    echo "<td>".$row['time_in']."</td>";
                    echo "<td>".$row['time_out']."</td>";
                    echo "<td>".$row['a_status']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }


        }

        function getMonthReport($month, $year){
            $query = "select a.date, a.leaves, b.late from (select date, COUNT(a_status) as leaves FROM attendance where a_status='^'
                      group BY date) AS a LEFT JOIN (select date, COUNT(a_status) as late FROM attendance where a_status='L'  group BY date)
                      AS b ON a.date = b.date WHERE a.date LIKE ('%/".$month."/".$year."') UNION select b.date, a.leaves, b.late from (select date, COUNT(a_status) as leaves FROM attendance
                      where a_status='^' group BY date) AS a RIGHT JOIN (select date, COUNT(a_status) as late FROM attendance where a_status='L' group BY date) 
                      AS b ON a.date = b.date WHERE b.date LIKE ('%/".$month."/".$year."') ORDER BY date";
            $record = mysqli_query($this->db, $query);

            if($record->num_rows > 0){
                echo "<table class='rp_table'><tr><th>Date</th><th>No_of_leaves</th><th>No_of_Late</th></tr>";
                while($row = $record->fetch_assoc()){
                    echo "<tr><td>".$row['date']."</td>";
                    echo "<td>".$row['leaves']."</td>";
                    echo "<td>".$row['late']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
        }
    }

    $attendance_obj = new Attendance($db_connect);
?>
