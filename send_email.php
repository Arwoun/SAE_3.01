<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$emailTo = $_POST['email'];
$resetCode = $code;

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
$mail->Subject = 'Réinitialisation de mot de passe';
$mail->Body = 'Voici votre code de réinitialisation de mot de passe : ' . $resetCode;

try {
    $mail->send();
    echo 'Le code a été envoyé avec succès à votre adresse e-mail.';
} catch (Exception $e) {
    echo 'Erreur lors de l\'envoi du code : ', $mail->ErrorInfo;
}
?>
