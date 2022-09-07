<?php
require_once __DIR__ . '/../class/user.php';
$user = User::getUser($req->user);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= htmlentities($user->name, ENT_QUOTES, 'UTF-8') ?></h1>
                <a href="/@<?= $user->id ?>/posts">Posts</a>
                <p><?= nl2br(htmlentities($user->description, ENT_QUOTES, 'UTF-8')) ?></p>
            </div>
        </div>
    </div>
</body>

</html>