<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM destination where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'nouvelle_destination.php';
?>