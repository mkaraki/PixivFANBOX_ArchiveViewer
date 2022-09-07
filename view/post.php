<?php
require_once __DIR__ . '/../class/post.php';
$post = Post::getPost($req->user, $req->post);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <title><?= $post->title ?> - <?= $post->user->title ?> - FANBOX Archive</title>
    <style>
        img {
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= htmlentities($post->title, ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <?php foreach ($post->body as $element) : ?>
                    <?php if ($element['type'] === 'p') : ?>
                        <p><?= htmlentities($element['text'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php elseif ($element['type'] === 'image') : ?>
                        <img src="/file.php?type=post&user=<?= urlencode($post->user->id) ?>&postid=<?= $post->id ?>&ftype=images&idext=<?= $post->images[$element['imageId']]['idExt'] ?>" alt="Image">
                    <?php elseif ($element['type'] === 'file') : ?>
                        <a href="/file.php?type=post&user=<?= urlencode($post->user->id) ?>&postid=<?= $post->id ?>&ftype=files&idext=<?= $post->files[$element['fileId']]['idExt'] ?>"><?= htmlentities($post->files[$element['fileId']]['name'], ENT_QUOTES, 'UTF-8') ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</body>

</html>