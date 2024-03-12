<?php
require_once('../Connections/connect2data.php');

if (!isset($_SESSION)) {
	session_start();
}
if (isset($_REQUEST['active']))
{
	$act = ($_REQUEST['active']==1) ? '0' : '1' ;

	$sql= "UPDATE terms SET term_active=:term_active WHERE term_id=:term_id";

	$sth = $conn->prepare($sql);
	$sth->bindParam(':term_active', $act, PDO::PARAM_INT);
	$sth->bindParam(':term_id', $_REQUEST['term_id'], PDO::PARAM_STR);
	$sth->execute();

	echo $act;
}
?>