<?php
if(!isset($conn)){ include 'db_connect.php'; } 

/*$qry = $conn->query("SELECT sender_email, recipient_email, status_retr
					FROM invoice
					WHERE num_conteneur = 6");

$_result="";*/

$qry = $conn->query("SELECT recipient_email, status_retr FROM invoice WHERE num_conteneur = 6");

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
    $data[] = $row["recipient_email"];
endwhile; 

var_dump($data);
echo "<br>";
$arrlength = count($data);

$b = "";
for($x = 0; $x < $arrlength; $x++) {
    /**/

    echo "idiot";
    //$b = $data[$x];
    $mail->addAddress('monkamjohvani2@gmail.com');
    $mail->isHTML(true);
    $mail->Subject='Nouveau Statut! ';

    $mail->Body='<h1 align=center>le nouveau status est:';

    if(!$mail->send()){
        $_result="erreur!!";
    }
    else{
        $result="Merci de nous avoir contacté. A Bientot!";
    }
    //echo $b;
    //break;
    //echo "<br>";
}

//echo $data[$x];

/*foreach ($data as $value) {
    /*$mail->addAddress($value['recipient_email']);
    $mail->isHTML(true);
    $mail->Subject='Nouveau Statut! ';

    $mail->Body='<h1 align=center>le nouveau status est:'.$row['status_retr'].'';

    if(!$mail->send()){
        $_result="erreur!!";
    }
    else{
        $result="Merci de nous avoir contacté. A Bientot!";
    }

    //echo $value['recipient_email']; // to access the names from the associated array.
}

$List = implode(', ', $value);
echo $List;*/
//$List = implode(', ', var_dump($data));
//echo $List;
/*$List = "";
foreach($products as $product){
    //echo $product[sender_email]; 
    $List = implode(',   ', $product[sender_email]); 
    echo $List;
}

$List = implode(',   ', $qry);
echo $List;*/