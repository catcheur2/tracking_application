<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM status_conteneur where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'nouveau_statut.php';
?>