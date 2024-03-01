<?php
function last(){
    if(!isset($conn)){ include 'db_connect.php'; } 
    $getID = $_GET['id'];
    $qry = $conn->query("SELECT sender_email, recipient_email, 
            status_retr, sender_address, recipient_address 
            FROM invoice 
            WHERE retire = 0 
            AND num_conteneur = '" . $conn->real_escape_string($getID) . "'");

    $_result="";  
    $mail1 = new phpmailer;
    $mail1->isSMTP();

    $mail1->Host='mail.ashkloud.com';
    $mail1->Port=465;
    $mail1->SMTPAuth=true;
    $mail1->SMTPSecure='ssl';

    $mail1->Username='admin@boca-grpservices.com';
    $mail1->Password='Owz4l51UB%';
    $mail1->setFrom('admin@boca-grpservices.com');

    while($row = $qry->fetch_assoc()):
        $data[] = $row["recipient_email"];
    endwhile; 

    foreach($data as $x => $x_value) {
        $mail1->addAddress($x_value);
    }
    
    $num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
    $design_arr[0]= "Unset";
    while($row=$num_conteneur->fetch_assoc()){
        $design_arr[$row['id']] =$row['nom'];
    }

    $status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);

    $mail1->isHTML(true);
    $mail1->Subject='Nouveau Statut! ';

    //$mail1->Body='<h1 align=center>Nous vous informons que votre colis est: '.$design_arr[$status_c].'</h1>';
    $mail1->Body='<h1 align=center>Cher client nous sommes heureux de vous informer que le conteneur: '.$con.' '.$design_arr[$status_c].'<br>NB : Si vous avez déjà payé merci de nous envoyer la preuve de paiement.</h1>';

    if(!$mail1->send()){
        $_result="erreur!!";
    }
    else{
        $result="Merci de nous avoir contacté. A Bientot!";
    }
}
last();