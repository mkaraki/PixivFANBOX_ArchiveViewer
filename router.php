<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/_config.php';

if (preg_match('#^/(vendor|file.php)#', $_SERVER["REQUEST_URI"])) {
    return false;
}

$klein = new \Klein\Klein();

$klein->respond('GET', '/', function ($req) {
    require(__DIR__ . '/view/users.php');
});

$klein->respond('GET', '/@[:user]', function ($req) {
    require(__DIR__ . '/view/user.php');
});

$klein->respond('GET', '/@[:user]/posts', function ($req) {
    require(__DIR__ . '/view/posts.php');
});

$klein->respond('GET', '/@[:user]/posts/[:post]', function ($req) {
    require(__DIR__ . '/view/post.php');
});

$klein->respond('/bootstrap.css', function ($request, $response, $service) {
    $response->file(__DIR__ . '/vendor/twbs/bootstrap/dist/css/bootstrap.css');
});

$klein->dispatch();
