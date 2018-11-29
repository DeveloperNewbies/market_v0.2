<?php
/**
 * Date: 28.11.2018
 * Time: 11:53
 */
require_once('inc/secIP.php');
include('inc/userClass.php');
session_start();
	$ipset = new secIP();
	$realip = "".$ipset->getLocal().":".$ipset->getPort();

$language ="tr";
$site_about ="hakkında";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link ="http://".$realip."/";
$home_url =$home_link;
$header_magaza = $home_link."index.php?m=magaza";
$header_sepetim = $home_link."index.php?m=sepetim";
$header_about = $home_link."index.php?m=hakkinda";
$header_contact = $home_link."index.php?m=iletisim";
$header_url = array("Anasayfa","Mağaza","Sepetim","Hakkında","İletişim");


$side_bar = array("Anasayfa","İsteklerim","Hesabım","İade","Yardım & SSS");
//side bar kısmında isteklerim kısmını linki
$side_bar_isteklerim ="";
//side bar hesabım kısmını linki
$side_bar_hesabım ="login/";
//side bar iade kısmını linki
$side_bar_iade ="";
//side bar yardım kısmının linki
$side_bar_yardim ="";


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
		header("Refresh: 5;");
	}
	//echo ''. $user->showUserInfo();
}
if(isset($_GET['logout']))
{
	if($_GET['logout'] == 1)
	{
		$user->logOut();
		session_destroy();
		echo 'Logged Out';
		header("Refresh: 2; url=http://".$realip."/");
		return;
	}
}

?>


<!DOCTYPE html>
<html lang="<?=$language?>">
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
</head>
<body class="animsition">


<?php
 require_once ("php/header.php");
 ?>
<?php if(!isset($_GET["m"])) {?>
<?php require_once("php/sidebar.php")?>
<?php require_once ("php/cart.php")?>
<?php require_once ("php/slider.php")?>
<?php require_once ("php/banner.php")?>
<?php require_once ("php/product.php")?>
<?php require_once ("php/footer.php")?>
<?php require_once ("php/back_to_top.php")?>
<?php require_once ("php/modall.php")?>
<?php require_once ("php/modal_2.php")?>
<?php require_once ("php/modal_3.php")?>
<?php require_once ("php/modal_4.php")?>
<?php require_once ("php/body_script.php") ?>
<?php
 }else{
    switch ($_GET["m"]){
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
            require_once ("php/back_to_top.php");
            break;
        case "sepetim":
            require_once("php/sidebar.php");
            require_once ("php/shopping/shopping_card.php");
            require_once ("php/back_to_top.php");
            break;

    }

}


require_once ("php/footer.php");
require_once ("php/back_to_top.php");
require_once ("php/body_script.php");
?>
</body>
</html>
