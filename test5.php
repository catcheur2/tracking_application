<?php
$lastid = "IN1123-0001";

$id1 = str_replace("IN1123-", "", $lastid);
//prendre les 2 1er chiffres de IN1123//11(mois)
$id2 = substr($lastid, 2, 2);
//prendre les 2 derniers chiffres de IN1123//23(année)
$id3 = substr($lastid, 4, 2);
//récupérer l'année de l'instant
$id4 =  date('Y');
$id5 = substr($id4, 2, 2);//affiche les 2 derniers chiffres du mois (23 ici)
//echo $id5;

if($id2 ==  date('m')){
    $id1 = (int) str_pad($id1 + 1, 4, 0, STR_PAD_LEFT);
    echo $id1;
}
else{
    $idd1 = "0001";
    $id2 = date('m');
    $id3 = $id5;
}
$number = 'IN'.$id2.$id3.'-'.$id1;
//echo $number;