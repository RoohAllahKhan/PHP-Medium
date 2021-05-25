<?php
include 'includes/db_connection.php';

$hour = date('H');
$query = "select e.emp_id, e.name, u.email, e.boss from Employees as e INNER JOIN users as u on e.emp_id=u.emp_id where e.emp_id NOT IN (select emp_id from attendance where date='".date('j/n/Y')."')";
$record = mysqli_query($db_connect, $query);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer;

$mail->isSMTP();                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;               // Enable SMTP authentication
$mail->Username = 'roohallahkhan20@gmail.com';   // SMTP username
$mail->Password = 'goldenhawk';   // SMTP password
$mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                    // TCP port to connect to

// Sender info
$mail->setFrom('roohallahkhan20@gmail.com', 'RA Khan');
$mail->addReplyTo('roohallahkhan20@gmail.com', 'RA Khan');

//// Add a recipient
//$mail->addAddress('roohallahk@yahoo.com');
//$mail->addAddress('rooh.allah@coeus-solutions.de');
//
////$mail->addCC('cc@example.com');
////$mail->addBCC('bcc@example.com');
//


// Mail body content
//$bodyContent = '<h1>Attendance Reminder</h1>';
//$bodyContent .= '<p>Kindly Mark your attendance before <b>12:00</b></p>';

// Send email



if($record->num_rows > 0){
    while($row = $record->fetch_assoc()){
        //echo nl2br($row['emp_id']."     ".$row['email']."\r\n");
        if($hour >= 11 && $hour < 12){
            $mail->ClearAddresses();
            $mail->addAddress($row['email']);
            // Mail body content
            $bodyContent = '<h1>Attendance Reminder</h1>';
            $bodyContent .= '<p>Kindly Mark your attendance before <b>12:00</b></p>';
            // Set email format to HTML
            $mail->isHTML(true);

            // Mail subject
            $mail->Subject = 'Email from Localhost by RA Khan';

            $mail->Body = $bodyContent;
            if(!$mail->send()) {
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
            } else {
                echo 'Message has been sent.';
            }
        }
        else if($hour >= 12){
            $leave_mark = "INSERT INTO attendance(emp_id, date, a_status) VALUES(".$row[emp_id].", '".date('j/n/Y')."', '^')";
            mysqli_query($db_connect, $leave_mark);
            if($row["boss"] != NULL){
                $mail->ClearAddresses();
                $boss_query = "SELECT * FROM users where emp_id=".$row['boss'];
                $record2 = mysqli_query($db_connect, $boss_query);
                $boss_email = $record2->fetch_assoc();
                $mail->addAddress($boss_email['email']);
                $bodyContent = '<h1>Absent Notifier</h1>';
                $bodyContent .= '<p>Your resource <b>'.$row['emp_id']." ".$row['name'].'</b> is on Leave today</p>';
                // Set email format to HTML
                $mail->isHTML(true);

                // Mail subject
                $mail->Subject = 'Email from Localhost by RA Khan';
                $mail->Body= $bodyContent;
                if(!$mail->send()) {
                    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
                } else {
                    echo 'Message has been sent.';
                }
            }
            else{
                $mail->ClearAddresses();
                $mail->addAddress($row['email']);
//                echo nl2br($row['email']."\r\n");
                $bodyContent = '<h1>Absent Notifier</h1>';
                $bodyContent .= '<p>Your absent has been marked for <b>today</b>.</p>';
                // Set email format to HTML
                $mail->isHTML(true);

                // Mail subject
                $mail->Subject = 'Email from Localhost by RA Khan';

                $mail->Body= $bodyContent;
                if(!$mail->send()) {
                    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
                } else {
                    echo 'Message has been sent.';
                }
            }
        }

    }
}

//// Set email format to HTML
//$mail->isHTML(true);
//
//// Mail subject
//$mail->Subject = 'Email from Localhost by RA Khan';
//
//$mail->Body= $bodyContent;
//if(!$mail->send()) {
//    echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
//} else {
//    echo 'Message has been sent.';
//}

?>

