<!DOCTYPE html>
<?php
/**
 * Date: 28.11.2018
 * Time: 11:53
 */
require_once('inc/secIP.php');
require_once('inc/userClass.php');
session_start();
$ipset = new secIP();
$realip = "".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
$islogged = false;

/** @var $user user */
$user = new user();

$language ="tr";
$site_about ="hakkında";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link ="http://".$realip;
$home_url =$home_link;
$header_magaza = $home_link."/index.php?m=magaza";
$header_sepetim = $home_link."/index.php?m=sepetim";
$header_about = $home_link."/index.php?m=hakkinda";
$header_contact = $home_link."/index.php?m=iletisim";
$header_url = array("Anasayfa","Mağaza","Sepetim","Hakkında","İletişim");



//side bar kısmında isteklerim kısmını linki
$side_bar_isteklerim ="";
//side bar hesabım kısmını linki
$side_bar_hesabım =$home_link."/index.php?m=hesabim";
//side bar iade kısmını linki
$side_bar_iade ="";
//side bar yardım kısmının linki
$side_bar_yardim = $header_contact;
//side bar giriş kısmının linki
$side_bar_giris = "/login";
//side bar çıkış kısmının linki
$side_bar_cikis = "?logout=1";

//ürünler bu linkteki adrese gönderilecek edilecek



if(isset($_SESSION['user']))
{
    $user = new user();
    $user = unserialize(base64_decode($_SESSION['user']));
    $info=''.$_SERVER['HTTP_USER_AGENT'].''.$_SERVER['REMOTE_ADDR'].''.$user->getID().''.$_SESSION['user'].'';
    $hash = hash("sha256", $info);
    $remote_hash = '';
    $islogged = true;
    foreach($user->getHash() as $row)
    {
        $remote_hash = $row['session_hash'];
    }
    if($user->getIp() != $_SERVER['REMOTE_ADDR'] || $hash != $remote_hash)
    {
        $islogged = false;
        $user->logOut();
        session_destroy();
        echo 'Oturum bilgisi ihlali!';
        header("Refresh: 3;");
    }
//echo ''. $user->showUserInfo();
}
if(isset($_GET['logout']))
{
    if($_GET['logout'] == 1)
    {
        $user->logOut();
        $ptr_sepet = $_SESSION['sepetim'];
        session_destroy();
        session_start();
        $_SESSION['sepetim'] = $ptr_sepet;
        header("Refresh: 0; url=http://".$realip."/");
        return;
    }
}

if($islogged){
    $side_bar = array("Anasayfa","İsteklerim","Hesabım","İade","Yardım & SSS", "Çıkış Yap");

    //php/account/account.php
//user account page variable
    $account_username ="" ;//username
    $account_surname="" ;//surname
    $account_email="" ; //email
    $account_adres="" ; //adres

}else{
    $side_bar = array("Anasayfa","İsteklerim","İade","Yardım & SSS", "Giriş Yap");
}


$user_shopping_item = "";


if(isset($_SESSION['sepetim']))
{
    $user_shopping_item = $_SESSION['sepetim'];
}else
    {
        //php/shopping/shopping_card.php
//kullanıcı sepetim kısmı verileri
// max item 10
    $user_shopping_item = array(
        //toplam fiyat çarpılıp yazılıyor
        //0 ürün id
        //1 image url
        //2 item title
        //3 ürün fiyat
        //4 kaç adet aldığı (default 1)

        //0=>array("2","images/narozu350gr.png","ürün title","17","2"),
        //1=>array("3","images/narozu350gr.png","ürün title","17.3","5"),
        //2=>array("4","images/narozu350gr.png","ürün title","10.3","1"),

    );

}




function user_sepet($usi){
    ////////////////
//database den sepetimdeki ürünler kısmı
//php/shopping/shopping_card.php
//kullanıcı sepetim kısmı verileri
// max item 10
//bu fonksiyon içerisinde $user_shopping_item yoksa yarat var ise değişiklikleri ekle

//session bilgisinde güncelle ata

    $_SESSION['sepetim'] = $usi;
}


$url_m =(isset($_GET["m"])) ? $_GET["m"] : "home" ;

if(isset($_POST["completeshopping"]))
    $url_m = "sepetim";

if(isset($_POST['urun_ekle']))
{

    if(isset($_POST['urun_id']))
    {

        $id = $user->security($_POST['urun_id']);

        $urun_adet = $user->security($_POST['num-product']);
        $urun_array = array();

        $bool_isalready = false;
        for ($i = 0; $i < count($user_shopping_item); $i++)
        {
            if($user_shopping_item[$i][0] == $id)
                $bool_isalready = true;
        }
        if($bool_isalready)
        {
            for ($i = 0; $i < count($user_shopping_item); $i++)
            {
                if($user_shopping_item[$i][0] == $id)
                {
                    $user_shopping_item[$i][count($user_shopping_item[$i])-1] += $urun_adet;
                }
            }
        }else
            {
                $urun_bul = $user->getUrun($id);
                foreach ($urun_bul as $item)
                {
                    array_push($urun_array, $item['urun_id']);
                    array_push($urun_array, $user->getUrunIMG($item['urun_id'])[0][2]);
                    array_push($urun_array, $item['urun_ad']);
                    array_push($urun_array, $item['urun_fiyat']);
                    array_push($urun_array, $urun_adet);
                }
                array_push($user_shopping_item, $urun_array);
            }
        user_sepet($user_shopping_item);
        header("location:".$header_magaza."&id=".$id);
    }
}

//sepet add item code
if(isset($_POST["shopping_card_update"])){

    $url_m = "sepetim";
    if(isset($_POST["num_item"])){
        if(isset($_POST["urun_id"]))
            for($g_s=0;$g_s<count($user_shopping_item); $g_s++){

                if($user_shopping_item[$g_s][0] == $_POST['urun_id'])
                    if($_POST['num_item'] == 0)
                        array_splice($user_shopping_item, $g_s, 1);
                     else
                        $user_shopping_item[$g_s][4] = $user->security($_POST['num_item']);
                }
    }
    /*bu kısımda $user_shopping_item in son hali var al onu ve database yi güncelle
    *
     *
     */
    user_sepet($user_shopping_item);
}


if(isset($_POST['urun_cikar'])){
    $urun_id = $user->security($_POST['urun_id']);
    for($i = 0; $i < count($user_shopping_item); $i++)
        if($user_shopping_item[$i][0] == $urun_id)
            array_splice($user_shopping_item, $i, 1);


    user_sepet($user_shopping_item);
}
//sepet add item code


?>




<head>
    <title><?=$title?></title>
    <meta charset="<?=$charset?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/account.css">
</head>
<body class="animsition">


<?php
 require_once ("php/header.php");
 ?>

<?php if(!isset($url_m)) {?>
<?php require_once("php/sidebar.php")?>
<?php require_once ("php/cart.php")?>
<?php require_once ("php/slider.php")?>
<?php require_once ("php/banner.php")?>
<?php require_once ("php/product.php")?>
<?php require_once ("php/footer.php")?>
<?php require_once ("php/back_to_top.php")?>
<?php require_once ("php/modall.php")?>
<?php require_once ("php/body_script.php") ?>
<?php
 }else{
    switch ($url_m){
        case  "home":
  require_once("php/sidebar.php");
 require_once ("php/cart.php");
 require_once ("php/slider.php");
 require_once ("php/banner.php");
 require_once ("php/product.php");
 require_once ("php/footer.php");
 require_once ("php/back_to_top.php");
 require_once ("php/modall.php");

            break;
        case "hakkinda":
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            require_once ("php/page_about/about.php");
            require_once ("php/back_to_top.php");
            break;
        case "iletisim":
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            require_once ("php/contact/contact.php");
            require_once ("php/back_to_top.php");
            break;
        case "magaza":
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            require_once ("php/product/product.php");
            require_once ("php/modall.php");
            require_once ("php/back_to_top.php");
            break;
        case "sepetim":
            require_once("php/sidebar.php");
            require_once ("php/shopping/shopping_card.php");
            require_once ("php/back_to_top.php");
            break;
        case "hesabim":
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            require_once ("php/account/account.php");
            require_once ("php/back_to_top.php");
            break;
        default :
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            echo "Hata";
            require_once ("php/back_to_top.php");
            break;
    }

}
require_once ("php/footer.php");
require_once ("php/back_to_top.php");
require_once ("php/body_script.php");
?>


<script src="js_ema/sepet_add_item.js"></script>
</body>
</html>
