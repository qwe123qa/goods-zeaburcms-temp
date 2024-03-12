<?php

if (!isset($_SESSION)) {
	session_start();
}

ob_start();

ini_set('date.timezone', 'Asia/Taipei');


// debug用
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// 平常用這個->只報告致命錯誤
error_reporting(E_ERROR);



/**
 *
en相關修改

copy cms, Connections, filemanager, source

require_once dirname(__DIR__) . '../../language/config.php';

<img src="<?= $imgpath . $row['file_link1'] ?>">

<html lang="<?= $_SESSION['lang'] ?>">

&:lang(en){} 可以直接這樣寫在任何class裡
 *
 */



// require_once dirname(__DIR__) . '/language/config.php';

// if ($_SESSION['lang'] == 'tw') {
// 	$database = 'sciencepark';
// 	$imgpath = '';
// } else if ($_SESSION['lang'] == 'en') {
// 	$database = 'sciencepark_en';
// 	$imgpath = 'en/';
// }



$cmode = ($_SERVER['SERVER_NAME'] === 'localhost') ? 'development' : 'production';

if ($cmode == 'development') {
	define("HOSTNAME", "localhost");
	define("DATABASE", "zeaburtest");
	define("USERNAME", "root");
	define("PASSWORD", "root");
}else{
	// Goods-cms
	define("HOSTNAME", "sfo1.clusters.zeabur.com:31104");
	define("DATABASE", "zeabur");
	define("USERNAME", "root");
	define("PASSWORD", "3Jh6AY4T2xPg9ovLiCFd5a10c8l7uIRM");
}




try {
	$dsn = "mysql:host=" . HOSTNAME . ";dbname=" . DATABASE . ";charset=utf8";
	$conn = new PDO($dsn, USERNAME, PASSWORD);
} catch (PDOException $e) {
	die("Error: " . $e->getMessage() . "\n");
}

// 前台用包好的class比較方便 (可能吧....)
require __DIR__ . "/PDO.class.php";
$DB = new Db(HOSTNAME, DATABASE, USERNAME, PASSWORD);

// 後台有些地方會用到
$selfPage = basename($_SERVER['PHP_SELF']);

function checkV($d) {
	return (isset($_REQUEST[$d])) ? $_REQUEST[$d] : NULL;
}

function moneyFormat($data, $n = 0) {
	$data1 = number_format(substr($data, 0, strrpos($data, ".") == 0 ? strlen($data) : strrpos($data, ".")));
	$data2 = substr(strrchr($data, "."), 1);
	if ($data2 == 0) {
		$data3 = "";
	} else {
		if (strlen($data2) > $n) {
			$data3 = substr($data2, 0, $n);
		} else {
			$data3 = $data2;
		}

		$data3 = "." . $data3;
	}
	return $data1;
}

function generate_slug($str) {
  // 將字符串轉換為小寫
  $slug = strtolower($str);
  // 替換空格為短橫線
  $slug = preg_replace('/\s+/', '-', $slug);
  // 替換點為底線
  $slug = str_replace('.', '_', $slug);
  // 移除非字母數字、短橫線、下划線和非中文字符
  $slug = preg_replace('/[^\p{Han}a-z0-9-_]/iu', '', $slug);
  // 移除多餘的短橫線
  $slug = preg_replace('/-+/', '-', $slug);
  // 移除首尾的短橫線
  $slug = trim($slug, '-');

  return $slug;
}

?>