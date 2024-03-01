<?php
    require 'phpmailer/PHPMailerAutoload.php';
    $mail = new phpmailer;

    $mail->Host='mail.ashkloud.com';
    $mail->Port=465;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure='tls';

    $mail->Username='turgot_bandja@facilitybt.com';
    $mail->Password='Facility@0';

    $mail->setFrom('monkamjohvani2@gmail.com');

    $mail->isHTML(true);
    $mail->Subject='PHP Mailer Subject';
    $mail->Body='<h1 align=center>Subscribe My channel</h1>';

    if(!$mail->send()){
        echo "erreur!";
    }
    else{
        echo "Message parti!";
    }

