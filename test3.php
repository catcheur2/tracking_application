<?php
if(!isset($conn)) { include 'db_connect.php'; } 

$number = "IN1223-0001";
//réupérer 0001 dans "IN1223-0001"
$id1 = str_replace("IN1223-", "", $number);
//prendre les 2 1er chiffres de IN1223//12(mois)
$id2 = substr($number, 2, 2);
//prendre les 2 derniers chiffres de IN1123//23(année)
$id3 = substr($number, 4, 2);
//année actuelle
$id4 =  date('Y');
//affiche les 2 derniers chiffres du mois (23 ici)
$id5 = substr($id4, 2, 2);
//mois actuel en chiffres
$id6 =  date('m');

if($id3 == $id5){
    if($id2 == date('m')){
        $id3 = $id5;
        $id2 = date('m');
        $id1 = str_pad($id1 + 1, 4, 0, STR_PAD_LEFT);
    }
    else{
        $id3 = $id5;
        $id2 = date('m');
    }
}
else{
    $id1 = 1;
    $id1 = str_pad($id1, 4, 0, STR_PAD_LEFT);
    $id3 = date('Y');
    $id3 = substr($id3, 2, 2);
    $id2 = date('m');
}
$number = 'IN'.$id2.$id3.'-'.$id1;
//echo $number;