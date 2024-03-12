<?php require_once('../Connections/connect2data.php'); ?>
<?php require_once('photo_process.php'); ?>
<?php require_once('imagesSize.php'); ?>

<?php

if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    header("Location: error.php");
}




// switch ($_SESSION['nowMenu']) {
//     case "news":
//         require_once 'photo_process.php';
//         $fileType = "file_type='image' AND";
//         $format = 'newsCover1';
//         $not = $imagesSize[$_SESSION['nowMenu']]['note'];
//         $IWidth = $imagesSize[$_SESSION['nowMenu']]['IW'];
//         $IHeight = $imagesSize[$_SESSION['nowMenu']]['IH'];
//         break;

//     default:
//         require_once 'photo_process.php';
//         $fileType = "file_type='image' AND";
//         $not = $imagesSize[$_SESSION['nowMenu']]['note'];
//         $IWidth = $imagesSize[$_SESSION['nowMenu']]['IW'];
//         $IHeight = $imagesSize[$_SESSION['nowMenu']]['IH'];
// }

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'storeCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='storeCover' AND";
    $not = $imagesSize['storeCover']['note'];
    $IWidth = $imagesSize['storeCover']['IW'];
    $IHeight = $imagesSize['storeCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'newsCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='newsCover' AND";
    $not = $imagesSize['newsCover']['note'];
    $IWidth = $imagesSize['newsCover']['IW'];
    $IHeight = $imagesSize['newsCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'productsCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='productsCover' AND";
    $not = $imagesSize['productsCover']['note'];
    $IWidth = $imagesSize['productsCover']['IW'];
    $IHeight = $imagesSize['productsCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'productsCatCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='productsCatCover' AND";
    $not = $imagesSize['productsCatCover']['note'];
    $IWidth = $imagesSize['productsCatCover']['IW'];
    $IHeight = $imagesSize['productsCatCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'giftCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='giftCover' AND";
    $not = $imagesSize['giftCover']['note'];
    $IWidth = $imagesSize['giftCover']['IW'];
    $IHeight = $imagesSize['giftCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'giftCatCover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='giftCatCover' AND";
    $not = $imagesSize['giftCatCover']['note'];
    $IWidth = $imagesSize['giftCatCover']['IW'];
    $IHeight = $imagesSize['giftCatCover']['IH'];
} elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'giftLayer1Cover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='giftLayer1Cover' AND";
    $not = $imagesSize['giftLayer1Cover']['note'];
    $IWidth = $imagesSize['giftLayer1Cover']['IW'];
    $IHeight = $imagesSize['giftLayer1Cover']['IH'];
}  elseif (isset($_REQUEST['type']) && $_REQUEST['type'] == 'giftLayer2Cover') {
    $type = $_REQUEST['type'];
    $fileType = "file_type='giftLayer2Cover' AND";
    $not = $imagesSize['giftLayer2Cover']['note'];
    $IWidth = $imagesSize['giftLayer2Cover']['IW'];
    $IHeight = $imagesSize['giftLayer2Cover']['IH'];
} else {
    $type = '-1';
    $fileType = "file_type='image' AND";
    $not = $imagesSize[$_SESSION['nowMenu']]['note'];
    $IWidth = $imagesSize[$_SESSION['nowMenu']]['IW'];
    $IHeight = $imagesSize[$_SESSION['nowMenu']]['IH'];
}

?>

<?php
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {


    $updateSQL = "UPDATE file_set SET file_title=:file_title, file_content=:file_content WHERE $fileType file_id=:file_id";

    $sth = $conn->prepare($updateSQL);
    $sth->bindParam(':file_title', $_POST['file_title'], PDO::PARAM_STR);
    $sth->bindParam(':file_content', $_POST['file_content'], PDO::PARAM_STR);
    $sth->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
    $sth->execute();

    //----------插入圖片資料到資料庫begin(須放入插入主資料後)----------
    $image_result = image_process($conn, $_FILES['image'], $_REQUEST['file_title'], $_SESSION['nowMenu'], "edit", $IWidth, $IHeight);

    // 表示有傳圖
    if ( count($image_result) == 2 ) {

        //刪除圖片真實檔案begin----
        $sql = "SELECT * FROM file_set WHERE $fileType file_id=:file_id";
        $sth = $conn->prepare($sql);
        $sth->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
        $sth->execute();


        while ($row = $sth->fetch()) {

            if ((isset($row['file_link1'])) && file_exists("../" . $row['file_link1'])) {
                unlink("../" . $row['file_link1']); //刪除檔案
            }
            if ((isset($row['file_link2'])) && file_exists("../" . $row['file_link2'])) {
                unlink("../" . $row['file_link2']); //刪除檔案
            }
            if ((isset($row['file_link3'])) && file_exists("../" . $row['file_link3'])) {
                unlink("../" . $row['file_link3']); //刪除檔案
            }
            if ((isset($row['file_link4'])) && file_exists("../" . $row['file_link4'])) {
                unlink("../" . $row['file_link4']); //刪除檔案
            }
            if ((isset($row['file_link5'])) && file_exists("../" . $row['file_link5'])) {
                unlink("../" . $row['file_link5']); //刪除檔案
            }
        }
        //刪除圖片真實檔案end----


        for ($j = 1; $j < count($image_result); $j++) {
            $updateSQL = "UPDATE file_set SET file_title=:file_title, file_content=:file_content, file_name=:file_name, file_link1=:file_link1, file_link2=:file_link2, file_link3=:file_link3, file_link4=:file_link4, file_link5=:file_link5 WHERE $fileType file_id=:file_id";

            $sth = $conn->prepare($updateSQL);
            $sth->bindParam(':file_title', $_POST['file_title'], PDO::PARAM_STR);
            $sth->bindParam(':file_content', $_POST['file_content'], PDO::PARAM_STR);
            $sth->bindParam(':file_name', $image_result[$j][0], PDO::PARAM_STR);
            $sth->bindParam(':file_link1', $image_result[$j][1], PDO::PARAM_STR);
            $sth->bindParam(':file_link2', $image_result[$j][2], PDO::PARAM_STR);
            $sth->bindParam(':file_link3', $image_result[$j][3], PDO::PARAM_STR);
            $sth->bindParam(':file_link4', $image_result[$j][6], PDO::PARAM_STR);
            $sth->bindParam(':file_link5', $image_result[$j][8], PDO::PARAM_STR);
            $sth->bindParam(':file_id', $_POST['file_id'], PDO::PARAM_INT);
            $sth->execute();

            $_SESSION["change_image"] = 1;
        }
    }
    //----------插入圖片資料到資料庫end----------


    if ($_REQUEST['type'] == 'productCatCover' || $_REQUEST['type'] == 'productCatIndexCover' || $_REQUEST['type'] == 'giftCatCover' || $_REQUEST['type'] == 'menuC_mobile') {
        $updateGoTo = $_SESSION['nowPage'] . "?c_id=" . $_POST['file_d_id'] . "#imageEdit";
    } else {
        $updateGoTo = $_SESSION['nowPage'] . "?d_id=" . $_POST['file_d_id'] . "#imageEdit";
    }

    if ($_SESSION['nowMenu'] == "farmerterm") {
        $updateGoTo = $_SESSION['nowPage'] . "?term_id=" . $_POST['file_d_id'] . "#imageEdit";}

    if ($image_result[0][0] == 1) {
        echo "<script type=\"text/javascript\">call_alert('" . $updateGoTo . "');</script>";
    } else {
        header(sprintf("Location: %s", $updateGoTo));
    }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
    $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_RecImage = "-1";
if (isset($_GET['file_id'])) {
    $colname_RecImage = $_GET['file_id'];
}

$query_RecImage = "SELECT * FROM file_set WHERE $fileType file_id = :file_id";
$RecImage = $conn->prepare($query_RecImage);
$RecImage->bindParam(':file_id', $colname_RecImage, PDO::PARAM_INT);
$RecImage->execute();
$row_RecImage = $RecImage->fetch();
$totalRows_RecImage = $RecImage->rowCount();

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
            <td width="30%" class="list_title">修改圖片</td>
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
                            <td width="200" align="center" bgcolor="#e5ecf6" class="table_col_title"><span class="table_data">圖片說明</span></td>
                            <td width="532"><input name="file_title" type="text" class="table_data" id="file_title" value="<?php echo $row_RecImage['file_title']; ?>" size="50">
                                <input name="file_id" type="hidden" id="file_id" value="<?php echo $row_RecImage['file_id']; ?>" />
                                <input name="file_d_id" type="hidden" id="file_d_id" value="<?php echo $row_RecImage['file_d_id']; ?>" /></td>
                                <td width="250" bgcolor="#e5ecf6"></td>
                            </tr>
                            <?php if($_SESSION['nowMenu']=='collection'){ ?>
                            <tr>
                                <td align="center" bgcolor="#e5ecf6" class="table_col_title"><span class="table_data">圖片說明</span></td>
                                <td><textarea name="file_content" cols="80" rows="5" class="table_data" id="file_content"><?php echo $row_RecImage['file_content']; ?></textarea></td>
                                <td bgcolor="#e5ecf6"></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center" bgcolor="#e5ecf6" class="table_col_title">目前圖片</td>
                                <td><img src="../<?php echo $row_RecImage['file_link2'].'?'.(mt_rand(1,100000)/100000); ?>" alt="" class="image_frame" /></td>
                                <td bgcolor="#e5ecf6" class="table_col_title"><p>&nbsp;</p></td>
                            </tr>

                            <!--     newsCover  satart -->
                            <?php if($type=='internationalCover' || $type=='workCover' || $type=='reportingCover'){ ?>
                            <tr>
                                <td align="center" bgcolor="#e5ecf6" class="table_col_title">寬度格式</td>
                                <td>
                                    <label>
                                        <select name="file_width" class="table_data" id="file_width">
                                            <option value="1" <?php if (!(strcmp(1, $row_RecImage['file_width']))) {echo "selected=\"selected\"";} ?>>1個單位</option>
                                            <option value="2" <?php if (!(strcmp(2, $row_RecImage['file_width']))) {echo "selected=\"selected\"";} ?>>2個單位</option>
                                            <option value="3" <?php if (!(strcmp(3, $row_RecImage['file_width']))) {echo "selected=\"selected\"";} ?>>3個單位</option>
                                        </select>
                                    </label>
                                </td>
                                <td bgcolor="#e5ecf6" class="table_col_title">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="#e5ecf6" class="table_col_title">長度格式</td>
                                <td>
                                    <label>
                                        <select name="file_height" class="table_data" id="file_height">
                                            <option value="1" <?php if (!(strcmp(1, $row_RecImage['file_height']))) {echo "selected=\"selected\"";} ?>>1個單位</option>
                                            <option value="2" <?php if (!(strcmp(2, $row_RecImage['file_height']))) {echo "selected=\"selected\"";} ?>>2個單位</option>
                                            <option value="3" <?php if (!(strcmp(3, $row_RecImage['file_height']))) {echo "selected=\"selected\"";} ?>>3個單位</option>
                                        </select>
                                    </label>
                                </td>
                                <td bgcolor="#e5ecf6" class="table_col_title">&nbsp;</td>
                            </tr>
                            <?php } ?>
                            <!--  newsCover  end -->


                            <tr>
                                <td align="center" bgcolor="#e5ecf6" class="table_col_title"><p>更改圖片</p>
                                </td>
                                <td><input name="image[]" type="file" class="table_data" id="image[]" size="50" ></td>
                                <td bgcolor="#e5ecf6" class="table_col_title"><p><span class="red_letter">*<?php echo $not; ?>
                                </span></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="center"><input name="submitBtn" type="submit" class="btnType" id="submitBtn" value="送出" /></td>
            </tr>
        </table>
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="type" value="<?php echo $type; ?>" />
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