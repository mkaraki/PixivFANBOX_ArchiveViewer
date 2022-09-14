<?php
require_once __DIR__ . '/../class/user.php';
$users = User::getUsers();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.css">
    <title>FANBOX Archive</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-6 g-4">
            <?php foreach ($users as $user) : ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><a href="/@<?= $user->id ?>"><?= $user->name ?></a></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>
