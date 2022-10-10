<?php
require_once __DIR__ . '/../class/user.php';
$user = User::getUser($req->user);

$page = $_GET['page'] ?? 1;
$page--;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <title>Posts of <?= htmlentities($user->name, ENT_QUOTES, 'UTF-8') ?> - FANBOX Archive</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1><?= htmlentities($user->name, ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4 g-4">
            <?php
            $list = $user->getPosts();
            $range_list = array_slice($list, $page * 30, ($page + 1) * 30);
            ?>
            <?php foreach ($range_list as $post) : ?>
                <div class="col">
                    <div class="card">
                        <img src="/file.php?type=post&user=<?= urlencode($user->id) ?>&postid=<?= $post->id ?>&ftype=cover&idext=<?= $post->coverIdExt ?>" class="card-img-top" alt="Cover">
                        <div class="card-body">
                            <h5 class="card-title"><a href="/@<?= $user->id ?>/posts/<?= $post->id ?>"><?= $post->title ?></a></h5>
                            <p class="card-text"><?= $post->excerpt ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
    $page++;
    $maxpage = ceil(count($list) / 30);
    ?>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li class="page-item<?php if ($page <= 1) echo " disabled"; ?>"><a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a></li>
            <?php for ($i = 1; $i <= $maxpage; $i++) : ?>
                <li class="page-item<?php if ($page === $i) echo ' active'; ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
            <?php endfor; ?>
            <li class="page-item<?php if ($page >= $maxpage) echo " disabled"; ?>"><a class="page-link" href="?page=<?= $page + 1; ?>">Next</a></li>
        </ul>
    </nav>

</body>

</html>