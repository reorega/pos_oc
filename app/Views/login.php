<?php
    $session = session();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/css/login_css.css">
    <title>Document</title>
</head>

<body style="background-image: url('<?= base_url(); ?>/assets/image/bg.jpg');">
    <div class="container">
        <div class="form_area">
            <?php $pengaturan = $setting[0];  ?>
            <p class="title">Login</p>
            <img src="<?= base_url() ?>/<?= $pengaturan['path_logo'];    ?>" alt="Logo" width="100" height="100">
            <form action="<?= base_url("auth"); ?>" method="post">
                <div class="form_group">
                    <label class="sub_title" for="email">Email</label>
                    <input placeholder="Enter your email" id="email" class="form_style" name="email" type="email">
                </div>
                <div class="form_group">
                    <label class="sub_title" for="password">Password</label>
                    <input placeholder="Enter your password" id="password" class="form_style" name="password"
                        type="password">
                </div>
                <button class="btn" type="submit">Log In</button>
            </form>
        </div>
    </div>
</body>

</html>