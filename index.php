<?php
include "loginClass.php";

if ($_SESSION['id'] == false) {
    header('Location:login.php');
}
if($_GET['insertflag'] == 2){
    include "Attendance.php";
    $attendance_obj->markAttendance($_GET['emp_id'], $_GET['timein'], $_GET['timeout'], $_GET['date'], $_GET['hour']);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
<?php
if ($_GET['modalFlag'] != 1) {
    ?>

    <div class="container" style=" height: 100vh;">
        <div style="margin-top: 20px;"><a  href="logout.php">Log Out</a></div>
        <div style="display: flex; width: 60%; margin-top: 10%; margin-left: auto; margin-right: auto; justify-content: space-between; border: 2px solid black; padding: 20px">
            <div class="profile_container" style="width: 40%; height: 100%; padding: 0px">
                <img src="images/<?php echo $_SESSION['profile_pic'] ?>" width="180" height="200">
            </div>
            <div style="display: inline-block; width: 100%" class="personal_container" style=" flex-wrap: wrap; width: 50%; height: 100px; padding-top: 100px">
                <div class="lab"><label for="empid">Employee ID</label></div>
                <div class="field"><input type="text" id="empid" name="empid" value="<?php echo $_SESSION['emp_id'] ?>" readonly/></div>
                <br><br>
                <div class="lab"><label for="name" style="margin-right: 5%">Name</label></div>
                <div class="field"><input type="text" id="name" name="name" value="<?php echo $_SESSION['name'] ?>" readonly/></div>
                <br><br>
                <div class="lab"><label for="dept">Department</label></div>
                <div class="field"><input type="text" id="dept" name="dept" value="<?php echo $_SESSION['department'] ?>" readonly/></div>
                <br><br>
                <div class="lab"><label for="salary">Salary</label></div>
                <div class="field"><input type="text" id="salary" name="salary" value="<?php echo $_SESSION['salary'] ?>/-" readonly/></div>
                <br><br>
                <div class="lab"><label for="boss">Boss</label></div>
                <div class="field"><input type="text" id="boss" name="boss" value="<?php echo $_SESSION['boss'] ?>" readonly/></div>
                <br><br>
                <div class="lab"><label for="designation">Designation</label></div>
                <div class="field"><input type="text" id="designation" name="designation" value="<?php echo $_SESSION['designation'] ?>" readonly/></div>
            </div>
        </div><br><br><br>
        <div style="display: inline-block; width: 100%">
            <button class="checkin btn btn-primary">Mark Attendance</button><br><br>
            <div class="dispModal"></div>
        </div>

    </div>

<?php } else {
    if (isset($_GET["modalFlag"])) {
        $viewModel = $_GET["modalFlag"];
        if (strlen($viewModel) > 0) {
            include "Attendance.php";
            $attendance_obj->checkRecord($_GET['emp_id'], $_GET['date']);

        }

    }
}
?>

</body>
</html>

<script>
    var hour;

    $(document).ready(function () {
        $(".timein_btn").click(function () {
            var d = new Date();
            document.getElementById("timein").value = d.getHours() + ":" + d.getMinutes();
            hour = d.getHours();
        });


    });
    $(".timeout_btn").click(function () {
        var timein = document.getElementById('timein').value;
        if(timein != ""){
            var d = new Date();
            document.getElementById("timeout").value = d.getHours() + ":" + d.getMinutes();
        }
        else{
            alert("Kindly enter the time in first");
        }

    });

    $(".checkin").click(function () {
        $(".dispModal").html("");
        var date = new Date()
        var emp_id = document.getElementById('empid').value;
        var e_date = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();
        var viewModal = "1";
        if (viewModal != "") {
            $.ajax({
                url: "index.php?modalFlag=" + viewModal +"&emp_id=" + emp_id + "&date=" + e_date+"&hour="+hour,
                method: "get",
                success: function (data) {
                    $(".dispModal").html(data);
                }
            });
        }
    });

    $(".markattendance").click(function (){
        var emp_id = document.getElementById('empid').value;
        var timein = document.getElementById('timein').value;
        var timeout = document.getElementById('timeout').value;
        var date = new Date();

        var e_date = date.getDate()+"/"+(date.getMonth()+1)+"/"+date.getFullYear();

        if(timein != ""){
            $.ajax({
                url: 'index.php?insertflag=2&emp_id='+emp_id+'&timein='+timein+'&timeout='+timeout+'&date='+e_date+'&hour=' +hour,
                method: "get",
                success:function (data){
                    console.log("Record is inserted successfully");
                    document.getElementById("myModal").style.display = "none";

                }
            });
        }
        else{
            alert("Please click on time in to mark your attendance");
        }

    });


    function closefunc() {
        document.getElementById("myModal").style.display = "none";
    }
</script>