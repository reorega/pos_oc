<?php
$error = session('error');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <link rel="icon" href="<?= base_url().$setting['path_logo']; ?>" type="image/png">
  <link href="<?= base_url(); ?>login/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>login/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>login/css/style.css" rel="stylesheet">

  <title><?=$setting['nama_perusahaan'];?></title>
</head>

<body>
  <section class="form-02-main">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="_lk_de">
            <div class="form-03-main">
              <div class="logo">
                <img src="<?= base_url().$setting['path_logo']; ?>" alt="Logo" width="120" height="120">
              </div>
              <!-- Tampilkan pesan kesalahan jika ada -->
              <?php if ($error) : ?>
              <div class="alert alert-danger text-center _alert_kt" role="alert">
                <?= $error ?>
              </div>
              <?php endif; ?>
              <form action="<?= base_url("auth"); ?>" method="post">
                <div class="form-group">
                  <input type="email" name="email" class="form-control _ge_de_ol" placeholder="Enter Email" required
                    aria-required="true">
                </div>
                <div class="form-group" style="position: relative;">
                  <input type="password" name="password" class="form-control _ge_de_ol" placeholder="Enter Password"
                    required aria-required="true" id="password">
                  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"
                    style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer;"></span>
                </div>
                <div class="form-group">
                  <button class="_btn_04"><b>LOGIN</b></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
    });
  </script>
</body>

</html>