<?php
/*******************************************************
 * Only these origins will be allowed to upload images *
 ******************************************************/
$accepted_origins = [
    "http://127.0.0.1",
    "http://localhost:8888",
    "http://localhost:3000",
    "http://localhost:3001",
    "http://localhost:3002",
    "http://localhost:3003",
    "http://localhost:3004",
    "http://localhost:3005",
    "https://longwave.zeabur.app",
    "http://longwave.zeabur.app",
];

/*********************************************
 * Change this line to set the upload folder *
 *********************************************/
// 上線應該改成 /
$rootFolder = ($_SERVER['SERVER_NAME'] === 'localhost') ? '/longwave/' : '/';
$imageFolder = "../source/";

reset($_FILES);
$temp = current($_FILES);
if (is_uploaded_file($temp['tmp_name'])) {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // same-origin requests won't set an origin. If the origin is set, it must be valid.
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
            header('Content-Type: application/json');
        } else {
            header("HTTP/1.1 403 Origin Denied");
            return;
        }
    }

    /*
    If your script needs to receive cookies, set images_upload_credentials : true in
    the configuration and enable the following two headers.
     */
    // header('Access-Control-Allow-Credentials: true');
    // header('P3P: CP="There is no P3P policy."');

    // Sanitize input
    if (preg_match("/([^\w\s\d\-_~,;:@\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    // Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    // Accept upload if there was no origin, or if it is an accepted origin
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    // 這邊記得回傳給ckeditor
    $absUri = (($_SERVER['SERVER_NAME'] === 'localhost') ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $rootFolder . 'source/' . $temp['name'];
    echo json_encode([
        "uploaded" => 1,
        "fileName" => $temp['name'],
        "url" => $absUri
    ]);
} else {
    // Notify editor that the upload failed
    header("HTTP/1.1 500 Server Error");
}
