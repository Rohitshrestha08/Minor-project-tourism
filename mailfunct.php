<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Import PHPMailer classes into the global namespace
function sendMail($e_mail, $date, $otp) {
    //Load Composer's autoloader
require 'PHPMail/src/Exception.php';
require 'PHPMail/src/PHPMailer.php';
require 'PHPMail/src/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'rohitshrestha067@gmail.com';           //SMTP username
        $mail->Password   = 'bvrdtwpquamgamcg';                          //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 465 for `ENCRYPTION_SMTPS`

        //Recipients
        $mail->setFrom('rohitshrestha067@gmail.com', 'Trails & Travel');
        $mail->addAddress($e_mail);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset of Trails & Travel';
        $mail->Body    = "We received a request from you to reset your password! <b>This is your code for reset password $otp </b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        // Handle any exceptions that occur during the email sending process
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        return false;
    }
}
?>