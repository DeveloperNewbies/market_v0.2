<?php
/**
 * Date: 30.11.2018
 * Time: 20:28
 */
date_default_timezone_set('Europe/Istanbul');

require_once('../inc/secIP.php');
require_once('../inc/userClass.php');
session_start();
$ipset = new secIP();
$realip = "".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
$user_granted = false;
/** @var $user user  */
$user;
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
    $active_items =count($user->getUrun("all"));
    //toplam satılan ürün sayısı
    $items_sold =count($user->adminGetOrderCount("",""));

    //toplam kullanıcı sayısı
    $total_users = ($user->getUserCount()) ? count($user->getUserCount()) : 0;
    //kullanıcı geri bildiirmleri (iade vs)
    $tickets_closed="0";
    //toplam gelir
    $total_tmp = $user->adminGetOrderCount("","");
    $total_income = 0;

    //Calculate And Set User Monthly and Total İncome
    foreach ($total_tmp as $item)
    {
        $total_income += $item['urun_fiyat'];
    }
    $monthly_tmp = $user->adminGetOrderCount("", "", true);
    foreach ($monthly_tmp as $item)
        $monthly_tmp = new DateTime($item['tarih']);

    $monthly_tmp->format("Y-m-d H-i-s");

    $first_time_tmp = new DateTime($user->adminGetFirstLog());
    $first_time_tmp->format("Y-m-d H-i-s");

    /** @var $difference DateTime */
    $difference = $monthly_tmp->diff($first_time_tmp);
    $monthly_tmp = (($difference->y * 12) + $difference->m);
    $monthly_tmp = ($monthly_tmp > 0) ? $monthly_tmp:1;
    $monthly_tmp = $total_income / $monthly_tmp;

    $total_income = $total_income." ₺";
    //aylık satılan ürünlerin toplam fiyatı
    $monthly_income = $monthly_tmp;
}
$urun = $user->adminGetItem("all");
if($url_m == "home"){
    //home page ürünler kısmı
    //max infinite item
        $list_item_list = array(
             //0 index ürün id
            //1 index ürün title
            //2 index satılan adet sayısı
            //3 index fiyat bilgisi
            //4 tarih bilgisi

        );
        for ($i = 0; $i < count($urun); $i++)
        {
            array_push($list_item_list, array());
        }
        $i = 0;
        foreach ($urun as $item)
        {
            array_push($list_item_list[$i], $item['urun_id']);
            array_push($list_item_list[$i], $item['urun_ad']);
            array_push($list_item_list[$i], ($user->adminGetItemSoldCount($item['urun_id'])) ? $user->adminGetItemSoldCount($item['urun_id']) : "-");
            array_push($list_item_list[$i], $item['urun_fiyat']);
            array_push($list_item_list[$i], $item['urun_tarih']);

            $i++;
        }
        $i = 0;


}else if($url_m == "orders"){
    //database deki toplam sipariş sayısı
    $orders_full_item ="20";

    $shipping_list_array = array(
        //0 index ürün görsel linki
        //1 index ürün title
        //2 index ürün sipariş id si
        //3 index sipariş adeti
        //4 index Fiyat
        //5 index Kategori
        //6 index Alıcı
        //7 index Kargo Numarası
        //8 index Sipariş Durum
        //9 index Sipariş Tarih
    );

    $result = $user->adminGetOrderCount(0 , 15);

    if($result)
    {
        $i = 0;
        foreach ($result as $item)
        {
            array_push($shipping_list_array, array());
            array_push($shipping_list_array[$i], "../".$user->getUrunIMG($item['urun_id'])[0][2]);
            foreach ($user->getUrun($item['urun_id']) as $item1)
            {
                array_push($shipping_list_array[$i], $item1['urun_ad']);
            }
            array_push($shipping_list_array[$i], $item['id']);
            array_push($shipping_list_array[$i], $item['urun_adet']);
            array_push($shipping_list_array[$i], $item['urun_fiyat']);
            foreach ($user->getUrun($item['urun_id']) as $item1)
            {
                array_push($shipping_list_array[$i], $user->getUrunKategori($item1['urun_grup'])[0][0]);
            }
            foreach ($user->adminFindUser($item['urun_id']) as $item1)
            {
                array_push($shipping_list_array[$i], $item1['k_ad']);
            }
            array_push($shipping_list_array[$i], $item['kargo_takip_no']);
            array_push($shipping_list_array[$i], $item['satis_sonuc']);
            array_push($shipping_list_array[$i], $item['tarih']);
            $i++;
        }
        $i = 0;
    }else
        echo 'Cant Find Any Shipping';

}else if($url_m=="item-list"){
   //database deki toplam sipariş sayısı
   $orders_full_item ="20";



   //orders page ürünler kısmı
   //max 15 item
     $item_list_array = array(
         //0 index ürün görsel linki
         //1 index ürün title
         //2 index ürün Satıştaki adeti
         //3 index Fiyat
         //4 index Kategori
         //5 index Ürün ID
         //6 index Satış Tarihi
     );

    $result = $user->getUrun("all");
    if($result)
    {
        $i = 0;
        foreach ($result as $item)
        {
            array_push($item_list_array, array());
            array_push($item_list_array[$i], "../".$user->getUrunIMG($item['urun_id'])[0][2]);
            array_push($item_list_array[$i], $item['urun_ad']);
            array_push($item_list_array[$i], $item['urun_adet']);
            array_push($item_list_array[$i], $item['urun_fiyat']);
            foreach ($user->getUrun($item['urun_id']) as $item1)
            {
                array_push($item_list_array[$i], $user->getUrunKategori($item1['urun_grup'])[0][0]);
            }
            array_push($item_list_array[$i], $item['urun_id']);
            array_push($item_list_array[$i], $item['urun_tarih']);
            $i++;
        }
    }
}else if($url_m=="item-editor")
{
    if(isset($_GET['c']))
    {
        $result = $user->getUrun("all");
    }elseif (isset($_GET['c_siparis']))
    {
        $c_siparis = $user->security($_GET['c_siparis']);
        $result = $user->adminGetItemSoldCount($c_siparis);
    }
}






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
                break;
            case   "item-list";
                require_once ("php/item/item_list.php");
                break;
            case   "item-editor";
                require_once ("php/item/item_editor.php");
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






