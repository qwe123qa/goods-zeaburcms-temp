<?php require_once('../Connections/connect2data.php'); ?>

<?php
$loginFormAction = $_SERVER['PHP_SELF'];

if (isset($_GET['accesscheck'])) {
    $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (!isset($_SESSION['errorTimes'])) {
    $_SESSION['errorTimes'] = 0;
}

if (isset($_POST['use_rname'])) {

    $loginUsername = $_POST['use_rname'];
    $password = $_POST['user_password'];

    $MM_fldUserAuthorization = "";
    $MM_redirectLoginSuccess = "first.php";
    $MM_redirectLoginFailed = "login.php";
    $MM_redirecttoReferrer = false;

    $LoginRS__query = "SELECT user_name, user_password FROM admin WHERE user_name=:user_name AND user_password=:user_password AND user_active='1'";

    $LoginRS = $conn->prepare($LoginRS__query);
    $LoginRS->bindParam(':user_name', $loginUsername, PDO::PARAM_STR);
    $LoginRS->bindParam(':user_password', $password, PDO::PARAM_STR);
    $LoginRS->execute();
    $loginFoundUser = $LoginRS->rowCount();

    if ($loginFoundUser) {
        $loginStrGroup = "";

        if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
        //declare two session variables and assign them
        $_SESSION['MM_AccountUsername'] = $loginUsername;
        $_SESSION['MM_AccountUserGroup'] = $loginStrGroup;

        if (isset($_SESSION['PrevUrl']) && false) {
            $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
        }

        unset($_SESSION["errorTimes"]);
        header("Location: " . $MM_redirectLoginSuccess);

    } else {
        $_SESSION['errorTimes']++;

        if ($_SESSION['errorTimes'] >= 5) {

            $updateSQL = "UPDATE admin SET user_active='0' WHERE user_name=:user_name";

            $sth = $conn->prepare($updateSQL);
            $sth->bindParam(':user_name', $loginUsername, PDO::PARAM_STR);
            $sth->execute();
        }

        header("Location: " . $MM_redirectLoginFailed);
    }
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php require('cmsTitle.php'); ?></title>

    <link href="css/work_css.css" rel="stylesheet" type="text/css">
    <link rel="dbblackpork icon" href="../css/favcon.ico" type="image/x-icon" />
</head>
<body>
    <div id="login-wrapper">
        <div id="login-wrapper-form">
            <form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1">
                <div class="art-logo-name"><img src="../images/login_logo.png"></div>
                <h3 class="login-cms-text">後端內容管理系統</h3>
                <div id="login-content">
                    <ul id="login-input">
                        <li><span class="login-input-text"><label for="use_rname">ACCOUNT</label></span>
                            <input type="text" name="use_rname" id="use_rname">
                        </li>
                        <li><span class="login-input-text"><label for="user_password">PASSWORD</label></span>
                            <input type="password" name="user_password" id="user_password">
                        </li>

                        <?php if ($_SESSION['errorTimes'] >= 5){ ?>
                        <li class="loginlock">此帳號已被鎖，請通知管理員解鎖並更新密碼。</li>
                        <?php }else if($_SESSION['errorTimes'] > 0){ ?>
                        <li class="loginerror">密碼輸入錯誤 <?= $_SESSION['errorTimes'] ?> 次，請重新輸入。<br>超過5次請通知管理員解鎖。</li>
                        <?php } ?>
                    </ul>
                    <input name="submitBtn" type="submit" class="btnType g-recaptcha" id="submitBtn" value="送出"
                        data-sitekey="6Lf2eTUUAAAAAA2C6bGhcsp6tTt96UunVj-BeUy_"
                        data-callback="onSubmit"
                        error-callback="onError"
                        data-size="invisible">
                </div>
            </form>
        </div>
    </div>
</body>
</html>

<script type="text/javascript" src="jquery/jquery-1.7.2.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script type="text/javascript">
    $(document).ready(function() {
        window.onSubmit = () => {
            form1.submit();
        }

        window.onError = () => {
            alert('發生錯誤，請稍後再試')
        }

        $(".btnType").hover(function() {
            $(this).addClass('btnTypeClass');
            $(this).css('cursor', 'pointer');
        }, function() {
            $(this).removeClass('btnTypeClass');
        });

        var mrg = ($(window).height() - $('#login-wrapper-form').height()) / 2 - 40;
        $('#login-wrapper-form').css('margin-top', mrg + 'px');
    });
</script>