<?php
require_once '../Connections/connect2data.php';

if (isset($_REQUEST['active'])) {

	$act = !$_REQUEST['active'];

	$sql = "UPDATE admin SET user_active=:user_active WHERE user_id=:user_id";

	$sth = $conn->prepare($sql);
	$sth->bindParam(':user_active', $act, PDO::PARAM_INT);
	$sth->bindParam(':user_id', $_REQUEST['d_id'], PDO::PARAM_STR);
	$sth->execute();

	echo $act;
}
?>