<?php
session_start();
ob_start();
include 'includes/db_connection.php';
    class Login{
        private $db;
        public $noExist = "";

        function __construct($db)
        {
            $this->db = $db;
        }

        function login(){
            if(isset($_POST["login_btn"])){
                //$boss;
                $email = $_POST["email"];
                $password = $_POST["password"];
                if(!empty($email) && !empty($password)){
                    $user_query = "SELECT emp_id, login_id, email, password from users WHERE email = '".$email."' AND password='".$password."'";
                    $record = mysqli_query($this->db, $user_query);
                    $row = $record->fetch_assoc();
                    if($row["email"] == $email && $row["password"] == $password){
                        $personal_query = "SELECT emp_id, name, department, salary, profile_pic, boss, designation from Employees where emp_id =".$row['emp_id'];
                        $personal_record = mysqli_query($this->db, $personal_query);
                        $p_row = $personal_record->fetch_assoc();
                        if($p_row['boss'] == NULL){
                            $boss = $p_row['boss'];
                        }
                        else{
                            $boss_query = "SELECT name FROM Employees where emp_id=".$p_row['boss'];
                            $b_record = mysqli_query($this->db, $boss_query);
                            $b_row = $b_record->fetch_assoc();
                            $boss = $b_row['name'];
                        }
                        $_SESSION['id'] = $row['login_id'];
                        $_SESSION['emp_id'] = $p_row['emp_id'];
                        $_SESSION['name'] = $p_row['name'];
                        $_SESSION['department'] = $p_row['department'];
                        $_SESSION['salary'] = $p_row['salary'];
                        $_SESSION['profile_pic'] = $p_row['profile_pic'];
                        $_SESSION['boss'] = $boss;
                        $_SESSION['designation'] = $p_row['designation'];
                        $_SESSION['id'] = true;
                        if($_SESSION['designation'] == 'HR Manager'){
                            header("Location: hrindex.php");
                        }
                        else{
                            header("Location: index.php");
                        }

                    }
                    else{
                        $this->noExist = "Email or password doesn't exists";
                    }

                }
                else{
                    echo "Please enter email or password";
                }
            }

        }

        function logout(){
            session_start();
            session_destroy();
            header('Location:login.php');
        }
    }
    $login_obj = new Login($db_connect);
?>
