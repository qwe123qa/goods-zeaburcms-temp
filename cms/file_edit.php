<?php require_once('../Connections/connect2data.php'); ?>
<?php require_once('file_process.php'); ?>
<?php require_once('imagesSize.php'); ?>

<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    header("Location: error.php");
}





if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

    $updateSQL = "UPDATE file_set SET file_title=:file_title WHERE file_id=:file_id";

    $sth = $conn->prepare($updateSQL);
    $sth->bindParam(':file_title', $_POST['upfile_title'], PDO::PARAM_STR);
    $sth->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
    $sth->execute();

    //----------插入檔案資料到資料庫begin(須放入插入主資料後)----------

    $file_result = file_process($conn, $_FILES['upfile'], $_REQUEST['upfile_title'], $_SESSION['nowMenu'], "edit");

    // 表示有傳圖
    if ( count($file_result) > 0 ) {
        //刪除真實檔案begin----
        $sql = "SELECT file_link1 FROM file_set WHERE file_id=:file_id";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
        $sth->execute();

        while ($row = $sth->fetch()) {
            if (file_exists("../" . $row[0])) {
                unlink("../" . $row[0]); //刪除檔案
            }
        }
        //刪除真實檔案end----



        for ($j = 0; $j < count($file_result); $j++) {
            $insertSQL = "UPDATE file_set SET file_name=:file_name, file_link1=:file_link1 WHERE file_id=:file_id";
            $sth2 = $conn->prepare($insertSQL);
            $sth2->bindParam(':file_name', $file_result[$j][0], PDO::PARAM_STR);
            $sth2->bindParam(':file_link1', $file_result[$j][1], PDO::PARAM_STR);
            $sth2->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
            $sth2->execute();
        }
    }
    //----------插入檔案資料到資料庫end----------



    $updateGoTo = $_SESSION['nowPage'] . "?d_id=" . $_POST['file_d_id'] . "";

    header(sprintf("Location: %s", $updateGoTo));
}

$editFormAction = $_SERVER['PHP_SELF'];

if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_RecFile = "-1";
if (isset($_GET['file_id'])) {
    $colname_RecFile = $_GET['file_id'];
}

$query_RecFile = "SELECT * FROM file_set WHERE file_id = :file_id";
$RecFile = $conn->prepare($query_RecFile);
$RecFile->bindParam(':file_id', $colname_RecFile, PDO::PARAM_INT);
$RecFile->execute();
$row_RecFile = $RecFile->fetch();
$totalRows_RecFile = $RecFile->rowCount();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>修改圖片</title>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="30%" class="list_title">修改檔案</td>
            <td width="70%">&nbsp;</td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
    </table>
    <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="3" cellpadding="5">
                        <tr>
                            <td width="200" align="center" bgcolor="#e5ecf6" class="table_col_title">檔案說明</td>
                            <td width="532">
                                <input name="upfile_title" type="text" class="table_data" id="upfile_title1" value="<?php echo $row_RecFile['file_title']; ?>" size="50">
                                <input name="file_id" type="hidden" id="file_id" value="<?php echo $row_RecFile['file_id']; ?>" />
                                <input name="file_d_id" type="hidden" id="file_d_id" value="<?php echo $row_RecFile['file_d_id']; ?>" />
                            </td>
                            <td width="250" bgcolor="#e5ecf6" class="table_col_title">
                                <p class="red_letter"></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#e5ecf6" class="table_col_title">檔案名稱</td>
                            <td class="table_col_title">&nbsp;
                                <?php echo $row_RecFile['file_name']; ?>
                            </td>
                            <td bgcolor="#e5ecf6" class="table_col_title">
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" bgcolor="#e5ecf6" class="table_col_title">
                                <p>更改檔案</p>
                            </td>
                            <td>
                                <input name="upfile[]" type="file" class="table_data" id="upfile[]" size="50">
                            </td>
                            <td bgcolor="#e5ecf6" class="table_col_title">
                                <p class="red_letter">*<?= $uploadFileSize ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center">
                    <input name="submitBtn" type="submit" class="btnType" id="submitBtn" value="送出" />
                </td>
            </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
    </form>
    <table width="100%" height="1" border="0" align="center" cellpadding="0" cellspacing="0" class="buttom_dot_line">
        <tr>
            <td>&nbsp;</td>
        </tr>
    </table>
</body>
</html>

<script type="text/javascript" src="jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".btnType").hover(function(){
            $(this).addClass('btnTypeClass');
            $(this).css('cursor', 'pointer');
        }, function(){
            $(this).removeClass('btnTypeClass');
        });
    });
</script>