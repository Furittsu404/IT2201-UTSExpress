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

    $mail->setFrom('utsexp2024@gmail.com', 'UTS Express');
    $mail->addAddress('utsexp2024@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Customer Order';
    $mail->Body = 'A customer has ordered from UTS Express.<br><h2>Order Details</h2>';
    foreach ($_POST['products'] as $key => $value) {
        $mail->Body .= '<p>' . $key . ' x <b>' . $value . '</b></p>';
    }

    $mail->Body .= '<br><p>Total: PHP <b>' . $_POST['total'] . '</b></p><p>Payment Method: <b>' . $_POST['payment'] . '</b></p>';
    $mail->Body .= '<p>Location: <b>' . $_POST['address'] . '</b></p>';
    $mail->Body .= 'The customer can be contacted at ' . $_POST['email'] . ' or ' . $_POST['cp'] . '. They are located at ' . $_POST['address'] . '.';
    $mail->Body .= 'The order details have been sent to the respective shops through SMS.';

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}