<?php
require_once('../Connections/connect2data.php');

if (isset($_REQUEST['active'])) {

	$act = !$_REQUEST['active'];

	$sql= "UPDATE data_set SET d_active=:d_active WHERE d_id=:d_id";

	$sth = $conn->prepare($sql);
	$sth->bindParam(':d_active', $act, PDO::PARAM_INT);
	$sth->bindParam(':d_id', $_REQUEST['d_id'], PDO::PARAM_STR);
	$sth->execute();

	echo $act;
}
?>