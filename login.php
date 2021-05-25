<?php
include "loginClass.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="mystyle.css">

    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
<?php
    $login_obj->login();

?>
<div class="limiter">
    <div class="container-login100" style="background-image: url('images/bg-01.jpg');">
        <div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
            <form method="post" class="login100-form validate-form p-b-33 p-t-5">

                <div class="wrap-input100 validate-input" data-validate = "Enter username">
                    <input class="input100" id="email" name="email" placeholder="Enter your email" >
                    <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Enter password">
                    <input class="input100" type="password" id="password" name="password" placeholder="Enter password" >
                    <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                </div>
                <br>

                <div style="text-align: center;"><span class="error" style="text-align: center"><?php echo $login_obj->noExist ?></span></div>
                <div class="container-login100-form-btn m-t-32">
                    <button class="login100-form-btn" type="submit" name="login_btn">
                        Login
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<div id="dropDownSelect1"></div>

<!--<form method="post">-->
<!--    <fieldset style="text-align: center; width: 50%; margin-left: auto; margin-right: auto">-->
<!--      <legend>Login</legend>-->
<!--      <label for="email">Email&nbsp;&nbsp;&nbsp;&nbsp;</label>-->
<!--      <input type="text" id="email" name="email" placeholder="Enter your email" required/>-->
<!--      <span class="error">*</span><br><br>-->
<!--      <label for="password">Password</label>-->
<!--      <input type="password" id="password" name="password" placeholder="Enter password" required/>-->
<!--      <span class="error">*</span><br><br>-->
<!--      <span class="error"></span>--><?php //echo $login_obj->noExist ?><!--<br><br>-->
<!--      <button type="submit" name="login_btn">Login</button>-->
<!--    </fieldset>-->
<!--  </form>-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>
</body>
</html>