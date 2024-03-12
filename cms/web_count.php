<?php require_once '../Connections/connect2data.php';?>

<?php
$compareToday_RecToday = date("Y-m-d");

$query_RecToday = "SELECT * FROM webcount WHERE count_time LIKE :count_time";
$RecToday = $conn->prepare($query_RecToday);
$RecToday->bindParam(':count_time', $compareToday_RecToday, PDO::PARAM_STR);
$RecToday->execute();
$row_RecToday = $RecToday->fetch();
$totalRows_RecToday = $RecToday->rowCount();

$query_RecTotal = "SELECT * FROM webcount";
$RecTotal = $conn->query($query_RecTotal);
$row_RecTotal = $RecTotal->fetch();
$totalRows_RecTotal = $RecTotal->rowCount();
?>