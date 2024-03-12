<?php

$uploadFileSize = "每次上傳之檔案大小總計請勿超過" . ini_get("upload_max_filesize") . "。";
$maxFileSize = "<br />$uploadFileSize";

$imagesSize = [
    "news" => [
        'IW' => 800,
        'IH' => 530,
        'note' => "圖片請上傳寬 800pixel、高 530pixel之圖檔。 $maxFileSize",
    ],
    "newsCover" => [
        'IW' => 0,
        'IH' => 0,
        'note' => "圖片最佳尺寸為寬 1100pixel、高 480pixel之圖檔。 $maxFileSize",
    ],
    "store" => [
        'IW' => 800,
        'IH' => 530,
        'note' => "圖片請上傳寬 800pixel、高 530pixel之圖檔。 $maxFileSize",
    ],
    "storeCover" => [
        'IW' => 300,
        'IH' => 195,
        'note' => "圖片請上傳寬 300pixel、高 195pixel之圖檔。 $maxFileSize",
    ],
    "productsCover" => [
        'IW' => 0,
        'IH' => 0,
        'note' => "圖片最佳尺寸為寬 960pixel、高 640pixel之圖檔。 $maxFileSize",
    ],
    "productsCatCover" => [
        'IW' => 200,
        'IH' => 200,
        'note' => "圖片請上傳寬不超過 200pixel、高不超過 200pixel之圖檔。 $maxFileSize",
    ],
    "giftCatCover" => [
        'IW' => 1900,
        'IH' => 900,
        'note' => "圖片請上傳寬 1900pixel、高 900pixel之圖檔。 $maxFileSize",
    ],
    "giftCover" => [
        'IW' => 410,
        'IH' => 380,
        'note' => "圖片請上傳寬不超過 410pixel、高不超過 380pixel之圖檔。 $maxFileSize",
    ],
    "giftLayer1Cover" => [
        'IW' => 300,
        'IH' => 300,
        'note' => "圖片請上傳寬 300pixel、高 300pixel之圖檔。 $maxFileSize",
    ],
    "giftLayer2Cover" => [
        'IW' => 300,
        'IH' => 300,
        'note' => "圖片請上傳寬 300pixel、高 300pixel之圖檔。 $maxFileSize",
    ],
];
?>