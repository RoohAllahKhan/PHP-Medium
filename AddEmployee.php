<?php
include "Employee.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Employee Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="mystyle.css">
</head>
<body>
<?php
//require_once ('connection.php');

$empName = $department = $boss = $designation = $email = $empPassword  = "";
$salary = 0;
$nameErr = $departmentErr = $salaryErr = $designationErr = $bossErr = $emailErr = $passwordErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["employee"])){
        $nameErr = "Employee Name is required";
    }
    else{
        $empName = testInput($_POST["employee"]);
    }
    if(empty($_POST["department"])){
        $departmentErr = "Department is required";
    }
    else{
        $department = testInput($_POST["department"]);
    }
    $boss = testInput($_POST["boss"]);
    if(empty($_POST["designation"])){
        $designationErr = "Designation is required";
    }
    else{
        $designation = testInput($_POST["designation"]);
    }
    if(empty($_POST["salary"])){
        $salaryErr = "salary is required";
    }
    else{
        $salary = $_POST["salary"];
    }
    if(empty($_POST["empEmail"])){
        $emailErr = "Email is required";
    }
    else{
        $email = $_POST["empEmail"];
    }
    if(empty($_POST["empPassword"])){
        $passwordErr = "Password is required";
    }
    else{
        $empPassword = $_POST["empPassword"];
    }
    if(isset($_FILES['pf_pic'])){
        $profileImg = $_FILES['pf_pic']['name'];
        $profile_temp = $_FILES['pf_pic']['tmp_name'];
        if(move_uploaded_file($profile_temp, "images/".$profileImg)){
            $msg = "Image uploaded successfully";
        }
        else{
            $msg = "Error in uploading of file";
        }
    }
    if($empName != "" && $department != "" && $profileImg != "" && $designation != "" && $salary != 0 && $email != "" && $empPassword != ""){
       $employee_obj->addEmployee($empName, $department, $salary, $profileImg, $boss, $designation, $email, $empPassword);
    }

}

function testInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

    <div class="container" style="min-height: 100vh">
        <div class="inner" style="margin-top: 10%">
            <h1>Employee Admin</h1>
            <span class="error">* required fields</span><br><br><br><br>
            <form class="employee_form" method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' enctype="multipart/form-data">
                <input type="text" name="employee" placeholder="Employee Name" />
                <span class="error">*<?php echo "$nameErr"?></span><br><br>
                <input type="text" name="department" placeholder="Department" />
                <span class="error">*<?php echo "$departmentErr"?></span><br><br>
                <input type="text" name="salary" placeholder="Salary" />
                <span class="error">*<?php echo "$salaryErr"?></span><br><br>
                <input type="file" name="pf_pic" required><br><br>
                <select name="designation" id="designation">
                    <option value="">--Select Designation--</option>
                    <option value="Developer">Developer</option>
                    <option value="Manager">Manager</option>
                    <option value="HR Manager">HR Manager</option>
                    <option value="CEO">CEO</option>
                </select>
                <span class="error">*<?php echo "$designationErr"?></span><br><br>
                <select name="boss" id="boss">
                    <option value="">--Select Boss--</option>
                    <?php
                    $employee_obj->makeSelect();
                    ?>
                </select><br><br>
                <input type="text" name="empEmail" placeholder="Email" />
                <span class="error">*<?php echo "$emailErr"?></span><br><br>
                <input type="password" name="empPassword" placeholder="Password" />
                <span class="error">*<?php echo "$passwordErr"?></span><br><br>
                <button class="btn btn-primary" type="submit">Add Employee</button>
                <button class="btn btn-warning" onclick="history.back()">Back to Home</button>
            </form>
        </div>
    </div>
</body>
</html>