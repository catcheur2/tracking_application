<?php
if(!isset($conn)){ include 'db_connect.php'; } 

$qry = $conn->query("SELECT sender_email, recipient_email, status_retr
					FROM invoice
					WHERE num_conteneur = 6");

$_result="";


require 'mail/phpmailer/PHPMailerAutoload.php';
$mail = new phpmailer;
$mail->isSMTP();

$mail->Host='mail.ashkloud.com';
$mail->Port=465;
$mail->SMTPAuth=true;
$mail->SMTPSecure='ssl';

$mail->Username='admin@boca-grpservices.com';
$mail->Password='Owz4l51UB%';
$mail->setFrom('admin@boca-grpservices.com');

while($row = $qry->fetch_assoc()):
    $mail->addAddress($row['recipient_email']);
	$mail->isHTML(true);
	$mail->Subject='Nouveau Statut! ';

	$mail->Body='<h1 align=center>le nouveau status est:'.$row['status_retr'].'';

	if(!$mail->send()){
		$_result="erreur!!";
	}
	else{
		$result="Merci de nous avoir contacté. A Bientot!";
	}
endwhile; 


