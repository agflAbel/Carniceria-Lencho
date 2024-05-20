<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require '../vendor/autoload.php';
$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = SMTP::DEBUG_OFF;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->SMTPAuth = true;
$mail->Username = '21031027@itcelaya.edu.mx';
$mail->Password = 'pevmebcokvsuphyf';
$mail->setFrom('21031027@itcelaya.edu.mx', 'Abel Aguilar Flores');
$mail->addAddress('aguilar.flores.abelfmatutino@gmail.com', 'Abel');
$mail->Subject = 'PHPMailer GMail SMTP test';
$mail->msgHTML("Hola mundo");
$mail->AltBody = 'This is a plain-text message body';
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}