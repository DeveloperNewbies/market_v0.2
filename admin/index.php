<?php
/**
 * Date: 30.11.2018
 * Time: 20:28
 */

require_once('../inc/secIP.php');
require_once('../inc/userClass.php');
session_start();
$ipset = new secIP();
$realip = "".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
$user_granted = false;
if(isset($_SESSION['user']))
{

    $user = new user();
    $user = unserialize(base64_decode($_SESSION['user']));
    $info=''.$_SERVER['HTTP_USER_AGENT'].''.$_SERVER['REMOTE_ADDR'].''.$user->getID().''.$_SESSION['user'].'';
    $hash = hash("sha256", $info);
    $remote_hash = '';
    foreach($user->getHash() as $row)
    {
        $remote_hash = $row['session_hash'];
    }
    if($user->getIp() != $_SERVER['REMOTE_ADDR'] || $hash != $remote_hash)
    {
        $user->logOut();
        session_destroy();
        echo 'Oturum bilgisi ihlali!';
        header("Refresh: 3;");
        return;
    }
    if($user->getPermission() < 2)
    {
        header("Refresh: 0; url=http://".$realip."/admin/login.php");
        return;
    }
    if(isset($_GET['m']))
    {
        if($_GET['m'] == "logout")
        {
            $user->logOut();
            session_destroy();
            echo 'Logged Out';
            header("Refresh: 1; url=http://".$realip."/");
            return;
        }
    }
    $user_granted = true;
//echo ''. $user->showUserInfo();
}else
    {

        header("Refresh: 0; url=http://".$realip."/admin/login.php");

        return;
    }

if(isset($_GET["m"]))
    $url_m = $_GET["m"];
else
    $url_m ="home";

$language ="tr";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link ="http://".$realip."/admin/index.php";



$logout_link =$home_link."/?m=logout";

if($user_granted)
{
    //admin variable
    $admin_username = $user->name." ".$user->surname;
//aktif satılan ürün sayısı mağazada bulunan
    $active_items ="1024";
//toplam satılan ürün sayısı
    $items_sold ="2048";
//aylık satılan ürünlerin toplam fiyatı
    $monthly_income ="20345";
//toplam kullanıcı sayısı
    $total_uers ="512";
//kullanıcı geri bildiirmleri (iade vs)
    $tickets_closed="10";
//toplam gelir
    $total_income="100000 ₺";
}




//item variable
$item_list_array_list = array("Ürün","Satılan adet sayısı","Fiyat","Eklenme tarihi");

//max 10 item
$list_item_list = array(
        //0 =>array("0ürün id","1ürün title","2satılan adet sayısı","3fiyat","4tarih"),
        0 =>array("1","0aqwefaqwfawfawfasdafdafaevgfasdasdasdasdafdaevgaedvefawf","02","03","04"),
        1 =>array("2","fasejbfpıasepogfpas","13","14","15"),
        2 =>array("3","afkuıefpıaef","23","24","16")
);


?>
<!doctype html>
<html class="no-js" lang="<?=$language?>">
<head>
    <meta charset=""<?=$charset?>>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title> <?=$title?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="css/vendor.css">
    <!-- Theme initialization -->
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="main-wrapper">
    <div class="app" id="app">
        <?php
        require_once ("php/header.php");
        require_once("php/left_menu.php");
        switch ($url_m){
            case  "home":
                require_once("php/website_metric.php");
                break;
            case "orders":
                require_once ("php/item/siparisler.php");
                echo "siparişler";
                break;
            case   "item-list";
                require_once ("php/item/item_list.php");
                echo "itemler";
                break;
            case   "item-editor";
                require_once ("php/item/item_editor.php");
                echo "itemler";
                break;
            default:
                require_once("php/website_metric.php");
                break;

        }


        ?>
<div class="sidebar-overlay" id="sidebar-overlay"></div>
<div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
<div class="mobile-menu-handle"></div>

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






