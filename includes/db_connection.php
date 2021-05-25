<?php
    $hostname = "localhost";
    $username = "root";
    $password = "coeus123";
    $database = "attendance";

    $db_connect = new mysqli($hostname, $username, $password, $database);
    if($db_connect->connect_error) {
        die("Connection Failed: ".$db_connect->connect_error);
    }
 ?>