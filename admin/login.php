<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 22:01
 */
$language ="tr";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link ="http://localhost/admin/index.php";
$magaza_page ="http://localhost/index.php";
?>
<!doctype html>
<html class="no-js" lang="<?=$language?>">
<head>
    <meta charset="<?=$charset?>">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=$title?>  </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/vendor.css">
    <!-- Theme initialization -->
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="auth">
    <div class="auth-container">
        <div class="card">
            <header class="auth-header">
                <h1 class="auth-title">
                    <div class="logo">
                        <span class="l l1"></span>
                        <span class="l l2"></span>
                        <span class="l l3"></span>
                        <span class="l l4"></span>
                        <span class="l l5"></span>
                    </div> Yönetim Paneli </h1>
            </header>
            <div class="auth-content">
                <p class="text-center">Giriş Yap</p>
                <form id="login-form" action="login.php" method="GET" novalidate="">
                    <div class="form-group">
                        <label for="username">E-posta</label>
                        <input type="email" class="form-control underlined" name="username" id="username" placeholder="E-posta adresiniz" required> </div>
                    <div class="form-group">
                        <label for="password">Parola</label>
                        <input type="password" class="form-control underlined" name="password" id="password" placeholder="Parola" required> </div>
                    <!--
                    <div class="form-group">
                        <label for="remember">
                            <input class="checkbox" id="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>

                    </div>-->
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Giriş Yap</button>
                    </div>

                </form>
            </div>
        </div>
        <div class="text-center">
            <a href="<?=$magaza_page?>" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Mağazaya Git</a>
        </div>
    </div>
</div>
<!-- Reference block for JS -->
<div class="ref" id="ref">
    <div class="color-primary"></div>
    <div class="chart">
        <div class="color-primary"></div>
        <div class="color-secondary"></div>
    </div>
</div>
<script>
    (function(i, s, o, g, r, a, m)
    {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function()
        {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-80463319-4', 'auto');
    ga('send', 'pageview');
</script>
<script src="js/vendor.js"></script>
<script src="js/app.js"></script>
</body>
</html>
