<?php require_once '../Connections/connect2data.php';?>
<?php require_once 'photo_process.php';?>
<?php require_once 'imagesSize.php';?>

<?php

$editFormAction = $_SERVER['PHP_SELF'];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {

    foreach ($_FILES as $file) {
        $imgs = [
            "name" => [$file['name']],
            "type" => [$file['type']],
            "tmp_name" => [$file['tmp_name']],
            "error" => [$file['error']],
            "size" => [$file['size']],
        ];

        // 一般附圖
        $image_result = image_process($conn, $imgs, "", $_SESSION['nowMenu'], "multiple", $imagesSize[$_SESSION['nowMenu']]['IW'], $imagesSize[$_SESSION['nowMenu']]['IH'], $_POST['d_id']);

        for ($j = 1; $j < count($image_result); $j++) {
            $insertSQL = "INSERT INTO file_set (file_name, file_link1, file_link2, file_link3, file_type, file_d_id, file_title, file_show_type) VALUES (:file_name, :file_link1, :file_link2, :file_link3, :file_type, :file_d_id, :file_title, :file_show_type)";

            $stat = $conn->prepare($insertSQL);
            $stat->bindParam(':file_name', $image_result[$j][0], PDO::PARAM_STR);
            $stat->bindParam(':file_link1', $image_result[$j][1], PDO::PARAM_STR);
            $stat->bindParam(':file_link2', $image_result[$j][2], PDO::PARAM_STR);
            $stat->bindParam(':file_link3', $image_result[$j][3], PDO::PARAM_STR);
            $stat->bindParam(':file_type', $type = 'image', PDO::PARAM_STR);
            $stat->bindParam(':file_d_id', $_POST['d_id'], PDO::PARAM_INT);
            $stat->bindParam(':file_title', $image_result[$j][4], PDO::PARAM_STR);
            $stat->bindParam(':file_show_type', $image_result[$j][5], PDO::PARAM_INT);
            $stat->execute();
        }
    }
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>修改圖片</title>

    <link rel="stylesheet" href="../filemanager/css/dropzone.min.css">

    <style type="text/css">
        .dropzone .dz-default.dz-message,
        .dropzone .dz-preview .dz-error-mark,
        .dropzone-previews .dz-preview .dz-error-mark,
        .dropzone .dz-preview .dz-success-mark,
        .dropzone-previews .dz-preview .dz-success-mark,
        .dropzone .dz-preview .dz-progress .dz-upload,
        .dropzone-previews .dz-preview .dz-progress .dz-upload {
            background-image: url('../filemanager/img/spritemap_en_EN.png');
        }
        .dropzone {
            min-height: 510px;
        }
        .btnType {
            width: 76px;
            height: 28px;
            border: 1px solid #cdcdcd;
            background-color: #FFFFFF;
            margin: 0 10px 0 0;
            padding: 0;
            font-size: 12px;
            color: #444;
            display: inline-block;
            line-height: 28px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        a.btnType {
            color: #000000;
            text-decoration: none;
        }
        .btnTypeClass {
            border: 1px solid #bfbfbf;
            background-color: #bfbfbf;
        }
    </style>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="30%" class="list_title"></td>
            <td width="70%">&nbsp;</td>
        </tr>
    </table>
    <table width="960" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td><img src="image/spacer.gif" width="1" height="1"></td>
        </tr>
    </table>
    <form action="<?= $editFormAction ?>" class="dropzone">
        <input type="hidden" name="MM_update" value="form1" />
        <input type="hidden" name="d_id" value="<?= $_GET['d_id'] ?>" />
    </form>
    <table width="100%" height="1" border="0" align="center" cellpadding="0" cellspacing="0" class="buttom_dot_line">
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td align="center">
                <!-- <input name="cancelBtn" type="button" class="btnType" id="cancelBtn" value="取消" /> -->
                <input name="closeBtn" type="button" class="btnType" id="closeBtn" value="完成" />
            </td>
        </tr>
    </table>
</body>
</html>

<script type="text/javascript" src="jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../filemanager/js/dropzone.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".btnType").hover(function() {
            $(this).addClass('btnTypeClass');
            $(this).css('cursor', 'pointer');
        }, function() {
            $(this).removeClass('btnTypeClass');
        });

        $("#closeBtn").on("click", function() {
            window.parent.$.fancybox.close();
        });
    });
</script>