<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function send_email($emailTo, $resetCode) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'phpmailercode@gmail.com';
    $mail->Password = 'fpwtxncftvjfxuat';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('arwinupec@gmail.com');
    $mail->addAddress($emailTo);
    $mail->isHTML(true);
    $mail->Subject = 'Code OTP';
    $mail->Body = 'Voici votre code de connexion : ' . $resetCode;

    try {
        $mail->send();
        return 'Le code a été envoyé avec succès à votre adresse e-mail.';
    } catch (Exception $e) {
        return 'Erreur lors de l\'envoi du code : ' . $mail->ErrorInfo;
    }
}
?>
