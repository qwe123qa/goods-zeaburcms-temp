<?php
require 'vendor/autoload.php';

$config = [
  'templates.path' => 'views'
];

$app = new \Slim\Slim($config);


$app->hook('slim.before', function () use ($app) {
  $req = $app->request;
  $host = $req->getHost();
  $port = $_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443 ? ':' . $_SERVER['SERVER_PORT'] : '';
  $root = $req->getRootUri();


  $mode = ($_SERVER['SERVER_NAME'] === 'localhost') ? 'development' : 'production';


  if ($mode == 'development') {
    $baseurl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $host . $port . $root;
  }else{
    $baseurl = "https://" . $host . $root;
  }

  $app->view()->appendData(array('baseurl' => $baseurl));
});


$app->get('(/:path+)/images/:file', function ($path, $file) use ($app) {
  $imagePath = '/views/images/' . $file;
  $fullPath = __DIR__ . $imagePath;

  if (file_exists($fullPath) && is_file($fullPath)) {
    $app->response->headers->set('Content-Type', mime_content_type($fullPath));
    readfile($fullPath);
  } else {
    $app->response->setStatus(404);
  }
});


$app->notFound(function () use ($app) {
  $app->render('404.php');
});

$app->get('/', function () use ($app) {
  $app->render('index.php');
});

$app->get('/project', function () use ($app) {
  $app->render('project.php');
});

$app->get('/project(/:p)', function ($p = null) use ($app) {
  $app->render('project.php', [
    'p' => $p,
  ]);
})->conditions([
  'p' => '\d{1,2}',
]);

// category要寫在前面 不然會進到內頁
$app->get('/project/category/:slug(/:p)', function ($slug = null, $p = null) use ($app) {
  $app->render('project.php', [
    'slug' => $slug,
    'p' => $p,
  ]);
});

$app->get('/project/:slug', function ($slug) use ($app) {
  $app->render('project_detail.php', [
    'slug' => $slug,
  ]);
})->conditions([
  'slug' => '.{2,}',
]);

$app->get('/about', function () use ($app) {
  $app->render('about.php');
});

$app->get('/service', function () use ($app) {
  $app->render('service.php');
});

$app->get('/news(/:p)', function ($p = null) use ($app) {
  $app->render('news.php', [
    'p' => $p,
  ]);
})->conditions([
  'p' => '\d{1,2}',
]);

$app->get('/news/category/:slug(/:p)', function ($slug = null, $p = null) use ($app) {
  $app->render('news.php', [
    'slug' => $slug,
    'p' => $p,
  ]);
});

$app->get('/feature', function () use ($app) {
  $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

  if($isMob){
    $app->render('featureMobile.php');
  }else{
    $app->render('feature.php');
  }
});

$app->get('/contact', function () use ($app) {
  $app->render('contact.php');
});


$app->run();