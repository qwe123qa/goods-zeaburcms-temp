<?php require_once '../Connections/connect2data.php';?>

<?php
// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF'] . "?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")) {
    $logoutAction .= "&" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) && ($_GET['doLogout'] == "true")) {
    //to fully log out a visitor we need to clear the session varialbles
    $_SESSION['MM_AccountUsername'] = NULL;
    $_SESSION['MM_AccountUserGroup'] = NULL;
    $_SESSION['PrevUrl'] = NULL;

    unset($_SESSION['MM_AccountUsername']);
    unset($_SESSION['MM_AccountUserGroup']);
    unset($_SESSION['PrevUrl']);

    $logoutGoTo = "../cms/login.php";
    if ($logoutGoTo) {
        header("Location: $logoutGoTo");
        exit;
    }
}
?>

<?php
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
    // For security, start by assuming the visitor is NOT authorized.
    $isValid = False;

    // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
    // Therefore, we know that a user is NOT logged in if that Session variable is blank.
    if (!empty($UserName)) {
        // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
        // Parse the strings into arrays.
        $arrUsers = Explode(",", $strUsers);
        $arrGroups = Explode(",", $strGroups);
        if (in_array($UserName, $arrUsers)) {
            $isValid = true;
        }
        // Or, you may restrict access to only certain users based on their username.
        if (in_array($UserGroup, $arrGroups)) {
            $isValid = true;
        }
        if (($strUsers == "") && true) {
            $isValid = true;
        }
    }
    return $isValid;
}

$MM_restrictGoTo = "../cms/login.php";
if (!((isset($_SESSION['MM_AccountUsername'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_AccountUsername'], $_SESSION['MM_AccountUserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?")) {
        $MM_qsChar = "&";
    }

    if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) {
        $MM_referrer .= "?" . $QUERY_STRING;
    }

    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}
?>

<?php
$colname_RecUser = "-1";
if (isset($_SESSION['MM_AccountUsername'])) {
    $colname_RecUser = $_SESSION['MM_AccountUsername'];
}

$query_RecUser = "SELECT user_id, user_name, user_level, user_limit, user_active FROM admin WHERE user_name = :user_name";
$RecUser = $conn->prepare($query_RecUser);
$RecUser->bindParam(':user_name', $colname_RecUser, PDO::PARAM_STR);
$RecUser->execute();
$row_RecUser = $RecUser->fetch();
$totalRows_RecUser = $RecUser->rowCount();

$colname_RecLevelAuthority = "-1";
if (isset($row_RecUser['user_level'])) {
    $colname_RecLevelAuthority = $row_RecUser['user_level'];
}

$query_RecLevelAuthority = "SELECT * FROM a_set WHERE a_id = :a_id";
$RecLevelAuthority = $conn->prepare($query_RecLevelAuthority);
$RecLevelAuthority->bindParam(':a_id', $colname_RecLevelAuthority, PDO::PARAM_STR);
$RecLevelAuthority->execute();
$row_RecLevelAuthority = $RecLevelAuthority->fetch();
$totalRows_RecLevelAuthority = $RecLevelAuthority->rowCount();

?>

<link href="../cms/css/work_css.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="dbblackpork icon" href="../favicon.png" type="image/x-icon" />
<script type="text/javascript" src="js/swapImage.js"></script>