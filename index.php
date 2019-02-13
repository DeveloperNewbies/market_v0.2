<!DOCTYPE html>

<?php
//error_reporting(0);
//ob_start();
header('Cache-Control: max-age=84600');
session_start();

/**
 * Date: 28.11.2018
 * Time: 11:53
 */
require_once('inc/secIP.php');
require_once('inc/userClass.php');
require_once("language.php");

$ipset = new secIP();
//$realip = "https://".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
$realip = $ipset->getLocal().$ipset->getFile();
$islogged = false;


//language
if(isset($_GET["lang"])){
  $lang = is_string(trim($_GET["lang"])) ? trim($_GET["lang"]) : "tr";
  $_SESSION["lang"] = $lang;
}else if(isset($_SESSION["lang"])){
  $lang =$_SESSION["lang"];
}else{
  $lang = "tr";
}



/** @var $user user */
$user = new user();

$site_about ="hakkında";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link = $realip; // aq memmedi şuraya htpps koyma
$home_url =$home_link;
$form_url = "optimumilac.com/checkout.php";
$header_magaza = $home_link."/index.php?m=magaza";
$header_sepetim = $home_link."/index.php?m=sepetim";
$header_about = $home_link."/index.php?m=hakkinda";
$header_contact = $home_link."/index.php?m=iletisim";
$header_url = array($m_lang[$lang][0],$m_lang[$lang][1],$m_lang[$lang][2],$m_lang[$lang][3],$m_lang[$lang][4]);




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


if(isset($_SESSION['user']))
{
    $user = new user();
    $user = unserialize(base64_decode($_SESSION['user']));
    $u_adress = $ipset->findUserIp();
    $info=''.$_SERVER['HTTP_USER_AGENT'].''.$u_adress.''.$user->getID().''.$_SESSION['user'].'';
    $hash = hash("sha256", $info);
    $remote_hash = '';

    $islogged = true;

    foreach($user->getHash() as $row)
    {
        $remote_hash = $row['session_hash'];
    }
    if($user->getIp() != $u_adress || $hash != $remote_hash)
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
        header("Refresh: 0; url=".$realip."/");
        return;
    }
}

if($islogged == true){
     $side_bar = array($m_lang[$lang][0],$m_lang[$lang][18],$m_lang[$lang][19],$m_lang[$lang][20],$m_lang[$lang][21]);

    //php/account/account.php
    //user account page variable
    $account_username ="" ;//username
    $account_surname="" ;//surname
    $account_email="" ; //email
    $account_adres="" ; //adres

}else{
    $side_bar = array($m_lang[$lang][0],$m_lang[$lang][2],$m_lang[$lang][20],$m_lang[$lang][24]);

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
        //4 urun-kdv
        //5 kaç adet aldığı (default 1)

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


if(isset($_GET["search"])){
     $url_m = "magaza";
 }


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
                    array_push($urun_array, $item['kdv']);
                    array_push($urun_array, $urun_adet);
                }
                array_push($user_shopping_item, $urun_array);
            }
        user_sepet($user_shopping_item);
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != '') {
            header("location: https://".$_SERVER['HTTP_HOST']."/index.php?m=magaza&id=".$id);
        }else
            {
                header("Location: ".$header_magaza."&id=".$id);
            }

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
                        $user_shopping_item[$g_s][5] = $user->security($_POST['num_item']);
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

    if(count($user_shopping_item) > 0)
        user_sepet($user_shopping_item);
    else
        unset($_SESSION['sepetim']);

}
//sepet add item code

	class Seo{
		public $site_name = "optimum ilac";
		public $site_about = "ilac";
		function __construct(){
		}

		function __destruct(){
		}
	}

$seo_op = new Seo();
$seo_title = $url_m;
$seo_description ="";
$db = new dbMain();
$db->connect();
//$user = new user();

   if(isset($_GET["id"])){
       $id = $_GET["id"];
       $id = $db->security($id);
       $urun = $db->getUrun($id);
    if($urun)
        {
            foreach ($urun as $result)
            {
                $seo_title =$result['urun_ad'];
                $seo_description =$result['urun_aciklama'];
            }
		}
   }


?>


<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="tr"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="tr"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="tr"> <![endif]-->
<!--[if gt IE 8]><!-->
<html lang="<?=$lang?>">
	<!--<![endif]-->
<head>

    <title><?=$seo_title?></title>
	<meta name="title" content="<?=$seo_op->site_name?>" />
	<meta name=”description” content="<?=$seo_op->site_about?>" />
	<?php if(isset($_GET["id"])){ ?>
	<title data-title="title"><?=$seo_title?></title>
	<meta property="og:url" content="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&lang=tr";?>">
	<link rel="canonical" href="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&lang=tr";?>">
	<meta property="og:title" content="<?=$seo_title?>">
	<meta property="og:description" content="<?=$seo_description?>">
		<?php }?>
	<link rel="alternate" hreflang="en" href="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&lang=en";?>">
	<link rel="alternate" hreflang="tr" href="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."&lang=tr";?>">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="MobileOptimized" content="970">
	<meta name="robots" content="FOLLOW, INDEX">
	<meta property="og:locale" content="<?=$lang?>">
	<meta property="article:tag" content="<?=$seo_title?>">
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
    
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-81351644-4"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-81351644-4');
	</script>

    <link rel="stylesheet" type="text/css" href="css/account.css">

    <!-------------------------------GOOGLE ADSENSe------------------------->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-1401760549580503",
    enable_page_level_ads: true
  });
</script>

    
</head>
<body class="animsition">
	<noscript>Tarayıcınız bu web içeriğini görüntülemek için güncel değil !</noscript>


<?php
    require_once ("php/header.php");

    switch ($url_m){
        case  "home":
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            require_once ("php/slider.php");
            require_once ("php/banner.php");
            require_once ("php/product.php");
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
           case "sozlesme":
			echo "Sözleşme çok yakında eklenecektir ";
           break;
           case "politic":
			echo "Politika çok yakında eklenecektir ";
           break;
        default :
            require_once("php/sidebar.php");
            require_once ("php/cart.php");
            echo "Hata";
            require_once ("php/back_to_top.php");
            break;
}
require_once ("php/footer.php");
require_once ("php/back_to_top.php");
require_once ("php/body_script.php");
?>

</body>
</html>
