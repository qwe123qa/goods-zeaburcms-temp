<?php
require_once '../Connections/connect2data.php';

function file_process(PDO $pdo, $FILES_A, $file_title, $file_name, $deal_type) {
    //echo count($FILES_A['name']);//上傳物件數量
    //echo count($_REQUEST[upfile_title]);//上傳物件的說明之數量
    //echo $FILES_A['tmp_name'][0];

    $all_file_name = array(); //建立回傳的資料陣列

    //******如果是插入記錄的上傳檔案begin*******/
    if ($deal_type == "add") {

        // pdo 已經是不同的了所以 lastInsertId 不能用只好用這樣
        $sql_max_pic = "SELECT MAX(file_id) FROM file_set";
        $sth = $pdo->query($sql_max_pic)->fetch();
        $new_file_num = $sth[0] + 1;

    }
    //******如果是插入記錄的上傳檔案end*******/

    //******如果是更新記錄的上傳檔案begin*******/
    if ($deal_type == "edit") {

        $new_file_num = $_POST['file_id'];

        //echo $new_file_num;

    }
    //******如果是更新記錄的上傳檔案end*******/

    for ($j = 0; $j < count($FILES_A['name']); $j++) {
        $tmp_name = $FILES_A['name'][$j];

        if ($tmp_name != '') //如果有上傳檔案
        {

            //******產生相對應的資料夾begin*******//
            $file_path = "upload_file";
            check_path2($file_path); //如果沒有資料夾，產生資料夾

            $file_path .= "/" . $file_name;
            check_path2($file_path); //如果沒有資料夾，產生資料夾

            //******產生相對應的資料夾end*******//

            $file_type = end(explode(".", $FILES_A['name'][$j])); //將檔案已"."分開，放到陣,列呼叫array最後一個資料,為檔案副檔名

            // $upfile_name = $new_file_num + $j; //將新id轉成檔案名，已上傳的數量來增加
            $upfile_name = $new_file_num + $j . "_" . rand(0, 10000) . "_" . rand(0, 10000); //將新id轉成檔案名，已上傳的數量來增加
            //echo "upfile_name = ".$upfile_name."<br>";

            //echo  $FILES_A['name'][$j]."<br>";
            $file_type = end(explode(".", $FILES_A['name'][$j])); //將檔案已"."分開，放到陣,列呼叫array最後一個資料,為檔案副檔名
            //echo $file_type."<br>";//

            $FILES_A['name'][$j] = str_replace(" ", "", $FILES_A['name'][$j]); //將檔案名內有空白的除掉

            $size = getimagesize($FILES_A['tmp_name'][$j]);
            //echo "filename = ".$FILES_A['tmp_name'][$j]."<br>";
            //echo "width = ".$size[0]."<br>";//寬
            //echo "height = ".$size[1]."<br>";//長
            //echo "width + height = ".$size[3]."<br>";//長
            $orginal_width = $size[0]; //寬
            $orginal_height = $size[1]; //長

            //$file_name= md5($file_name);

            $this_path = $file_path . "/" . $file_name . "_" . $upfile_name . "." . $file_type;

            $this_path = mb_convert_encoding($this_path, "BIG5", "UTF-8"); //如果檔案是中文名，要轉成big5才能存成真實的檔
            //echo $this_path."<br>";
            //echo $FILES_A['tmp_name'][$j];

            copy($FILES_A['tmp_name'][$j], "../" . $this_path);
            $this_path = mb_convert_encoding($this_path, "UTF-8", "BIG5"); //如果檔案是中文名，要轉成utf-8才能放在資料庫
            //echo $this_path;

            $db_file_name = $file_name . "_" . $upfile_name . "." . $file_type; //儲存到資料庫的檔案名稱
            $all_file_name[$j][0] = $db_file_name; //儲存檔案名
            $all_file_name[$j][1] = $this_path; //檔案位置
            $all_file_name[$j][2] = $file_title[$j]; //檔案title(說明)
            $all_file_name[$j][3] = $orginal_width;
            $all_file_name[$j][4] = $orginal_height;
        } else //沒上傳檔案
        {
            //echo "沒上傳檔案";

        }

    }

    //print_r($all_file_name);//列出陣列
    return $all_file_name;
}

function check_path2($file_path) {

    if (!is_dir("../" . $file_path)) //如果沒有資料夾
    {
        mkdir("../" . $file_path); //產生資料夾
    } else {
        //dont do thing
    }
}

?>

