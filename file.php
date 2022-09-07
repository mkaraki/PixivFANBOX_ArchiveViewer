<?php
# Read fanbox data and return file instead of web server.

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/_config.php';

if (!isset($_GET['type']) || !isset($_GET['user']) || !isset($_GET['ftype']) || !isset($_GET['idext'])) {
    http_response_code(404);
    die();
}

$path = null;

switch ($_GET['type']) {
    case 'profile':
        $path = $FANBOX_DIR . '/profile/' . $_GET['user'] . '/' . $_GET['ftype'] . '/' . $_GET['idext'];
        break;

    case 'post':
        if (!isset($_GET['postid'])) {
            http_response_code(404);
            die();
        }
        $path = $FANBOX_DIR . '/posts/' . $_GET['user'] . '/' . $_GET['postid'] . '/' . $_GET['ftype'] . '/' . $_GET['idext'];
        break;

    default:
        http_response_code(404);
        die();
        return;
}

$mimes = new \Mimey\MimeTypes;

if (is_file($path)) {
    header('Content-Type: ' . $mimes->getMimeType(array_slice(explode('.', $path), -1)[0]));
    readfile($path);
} else {
    http_response_code(404);
    die();
}
