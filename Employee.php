<?php
include "includes/db_connection.php";
    class Employee{
        private $db;

        function __construct($db)
        {
            $this->db = $db;
        }
        function addEmployee($name, $department, $salary, $profile_pic, $boss, $designation, $email, $password){
            //$Manager_query = "SELECT emp_id FROM Employees WHERE name='".$boss."' AND designation='Manager'";
            $query1 = "INSERT INTO Employees(name, department, salary, profile_pic, boss, designation) VALUES ('".$name."','".$department."',".$salary.
                      ",'".$profile_pic."',".$boss.",'".$designation."')";
            if(mysqli_query($this->db, $query1)){
                $query2 = "INSERT INTO users(emp_id, email, password) VALUES(".mysqli_insert_id($this->db).",'".$email."','".$password."')";
                mysqli_query($this->db, $query2);
            }

        }

        function showAllEmployees(){
            $query = "SELECT * FROM Employees";
            $record = mysqli_query($this->db, $query);
            if($record->num_rows > 0){
                while($row = $record->fetch_assoc()){
                    echo "<tr><td>".$row['emp_id']."</td>
                               <td>".$row['name']."</td>
                               <td>".$row['department']."</td>
                               <td>".$row['designation']."</td>
                               <td><div style='display: flex; justify-content: space-evenly'><button style='width: 40%; box-shadow: black' class='emp_edit btn btn-primary'>Edit</button><button style='width: 45%' class='emp_del btn btn-danger'>Delete</button></div></td>";
                }
            }
        }

        function deleteEmp($empId){
            $query = 'DELETE FROM users WHERE emp_id='.$empId;
            mysqli_query($this->db, $query);
            $query1 = 'DELETE FROM attendance where emp_id='.$empId;
            mysqli_query($this->db, $query1);
            $query2 = 'DELETE FROM Employees WHERE emp_id='.$empId;
            mysqli_query($this->db, $query2);
        }

        public function makeSelect(){
            echo "<option value=''>No boss</option>";
            $query = 'SELECT * FROM Employees WHERE designation="Manager"';
            $record = mysqli_query($this->db, $query);
            if($record->num_rows > 0){
                while($row = $record->fetch_assoc()){
                    echo "<option value='".$row['emp_id']."'>".$row['name']."</option>";
                }
            }
        }

        function viewEmp($empId){
            $query = 'SELECT * FROM Employees WHERE emp_id ='.$empId;
            $record = mysqli_query($this->db, $query);
            $query2 = 'SELECT * FROM users WHERE emp_id='.$empId;
            $record2 = mysqli_query($this->db, $query2);
            $row2 = $record2->fetch_assoc();
            if($record->num_rows > 0){
                $row = $record->fetch_assoc();
                $query3 = "select a.emp_id, a.name, a.department, a.salary, a.profile_pic, a.designation, b.name as boss from Employees as a join Employees as b on a.boss=b.emp_id where 
                            a.emp_id=".$row['emp_id'];
                $record3 = mysqli_query($this->db, $query3);
                $row3 = $record3->fetch_assoc();
                echo "<div id='myModal' class='modal' style='display: block'><div class='modal-content' style='width:70%; margin-top:5%'><span class='close' style='text-align:right' onclick='closefunc()'>&times;</span><p><div class='empMain'
                      style='display: inline-block; text-align: center; width: 100%'><div style='margin-left:5%;float: left; height: 100%; display: inline-block'><img id= 'empProfile' alt='hp' height=385 src='images/"
                      .$row['profile_pic']."' alt='hp' width='300'></div><div class='inside' style='clear: top; height: 100%; width: 60%; display: inline-block; text-align: center;
                       align-items: center;'><div style='text-align: right'><p class='id' style='display: none'>".$row['emp_id']."</p>
                       Name&emsp;<input style='height:40px; width:70%' type='text' class='empName' value='".$row['name']."'>
                       <br><br>Department&emsp;<input style='height:40px; width:70%' type= 'text' class='department' value='".$row['department']."'>
                       <br><br>Salary&emsp;<input style='height:40px; width:70%' type='text' class='salary' value=".$row['salary']."><br><br>
                       Designation&emsp;
                       <select name='designation' id='designation' style='width: 71%; height: 40px'>
                        <option value='".$row['designation']."'>".$row['designation']."</option>
                        <option value='Developer'>Developer</option>
                        <option value='Manager'>Manager</option>
                        <option value='HR Manager'>HR Manager</option>
                        <option value='CEO'>CEO</option>
                        </select><br><br>
                       Boss&emsp;<select name='boss' id='boss' style='width: 71%; height: 40px'>
                        <option value='".$row['boss']."'>".$row3['boss']."</option>";
                $this->makeSelect();
                echo "</select><br><br>
                       Email&emsp;<input style='height:40px; width:70%' type='text' class='email' value='".$row2["email"]."'><br><br>
                       Password&emsp;<input style='height:40px; width:70%' type='text' class='passwd' value='".$row2["password"]."'>
                       <br><br>Profile Image&emsp;<input type='file' name='pf_pic' id='file' required><br></div>
                       <div class='btn_container' style='height:30%;padding: 30px; clear: both;'><table class='buttons' style='float:right;table-layout: fixed; width: 70%'><tr><td style='height: 30px;'>
                       <button type='submit' style=' border-radius:50px; height: 40px; width: 80%; font-size: 20px' class='save_btn btn btn-primary' onclick='saveFunc()'>Save</button></td><td style='height: 30px;'>
                       <button style='border-radius:50px; height: 40px; width: 80%;font-size: 20px' class='cancel_btn btn btn-danger' onclick='cancelFunc()'>Cancel</button></td></tr></table></div></div></div>";

            }
        }

        function updateEmp($id, $name, $department, $salary, $designation, $boss, $email, $passwd, $profile){
            $empQuery = 'UPDATE Employees SET name="'.$name.'", department="'.$department.'", salary='.$salary.', boss='.$boss.', profile_pic="'.$profile.'", designation="'.$designation.
                '" WHERE emp_id='.$id;
            mysqli_query($this->db, $empQuery);

            $userQuery = 'UPDATE users SET email="'.$email.'", password="'.$passwd.'" WHERE emp_id='.$id;
            mysqli_query($this->db, $userQuery);
        }
    }

    $employee_obj = new Employee($db_connect);
?>
