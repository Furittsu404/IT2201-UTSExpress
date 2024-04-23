<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'utsexp2024@gmail.com';
    $mail->Password = 'zjmg zidn dayj djqu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress('utsexp2024@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Customer Contact';
    $mail->Body = 'A customer has contacted you through the UTS Express website.<br><h2>Contact Details</h2>';
    $mail->Body .= '<p>Name: <b>' . $_POST['name'] . '</b></p>';
    $mail->Body .= '<p>Email: <b>' . $_POST['email'] . '</b></p>';
    $mail->Body .= '<p>Location: <b>' . $_POST['location'] . '</b></p>';
    $mail->Body .= '<p>Phone Number: <b>' . $_POST['phone'] . '</b></p>';
    $mail->Body .= '<b>Message: </b><br><p>' . $_POST['message'] . '</p>';

    $mail->send();
    echo 'Message sent successfully! We will get back to you soon.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
