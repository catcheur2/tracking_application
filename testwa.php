<?php
if(!isset($conn)) { include 'db_connect.php'; } 

$qry = $conn->query("SELECT sender_address, recipient_address FROM invoice 
    WHERE retire = 0  AND num_conteneur = 6");

$number = "";

while($row = $qry->fetch_assoc()):
    $data[] = $row["recipient_address"];
    $datas[] = $row["sender_address"];
endwhile; 
var_dump($data);

$arrlength = count($data);
$arrlengths = count($datas);
include('WhatsappAPI.php'); // include given API file

for($x = 0; $x < $arrlength; $x++) {
    $wp = new WhatsappAPI("4984", "fc71b5dee13554af47ff755a89ed893790b6e411"); // create an object of the WhatsappAPI class with your user id and api key
    $number = $data[$x];
    $num_conteneur = $conn->query("SELECT * FROM status_conteneur ");
    $design_arr[0]= "Unset";
    while($row=$num_conteneur->fetch_assoc()){
        $design_arr[$row['id']] =$row['nom'];
    }

    //$status_c=mysqli_real_escape_string($conn,$_POST["status_c"]);

    $message = 'Nous vous informons que votre colis est: '.$design_arr[2];
    //echo $data[$x];
    $status = $wp->sendText($number, $message);
    $status = json_decode($status);

    if($status->status == 'error'){
        echo $status->response;
    }elseif($status->status == 'success'){
        echo 'Success <br />';
        echo $status->response;
    }else{
    print_r($status);
    }
    echo "<br>";
}

for($x = 0; $x < $arrlengths; $x++) {
    $wp = new WhatsappAPI("4984", "fc71b5dee13554af47ff755a89ed893790b6e411"); // create an object of the WhatsappAPI class with your user id and api key
    $number = $datas[$x];
    $message = 'Bonjour gar';
    //echo $data[$x];
    $status = $wp->sendText($number, $message);
    $status = json_decode($status);

    if($status->status == 'error'){
        echo $status->response;
    }elseif($status->status == 'success'){
        echo 'Success <br />';
        echo $status->response;
    }else{
    print_r($status);
    }
    echo "<br>";
}

?>
