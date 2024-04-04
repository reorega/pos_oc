<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $session = session();

    ?>
    <h1>halaman admin</h1>
    <p><?= $session->level;?></p>
    <p><?= $session->username;?></p>
</body>
</html>