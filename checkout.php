<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 10.12.2018
 * Time: 14:37
 */
$city_array = array('','Adana', 'Adıyaman', 'Afyon', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
    'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale',
    'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
    'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir',
    'Kars', 'Kastamonu', 'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya',
    'Manisa', 'Kahramanmaraş', 'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya',
    'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak',
    'Van', 'Yozgat', 'Zonguldak', 'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak',
    'Bartın', 'Ardahan', 'Iğdır', 'Yalova', 'Karabük', 'Kilis', 'Osmaniye', 'Düzce');


require_once ("inc/secIP.php");
require_once('inc/userClass.php');
session_start();
$ipset = new secIP();
$user = new user();
$card_secure_durum = true;

$realIp = "http://".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();


if(!isset($_SESSION["user"]) && count($_SESSION["sepetim"])<=0 )
    header("location: ".$realIp);


$adresim = "Adana";


//form post
$checkout_name ;
$checkout_email ;
$checkout_adres;
$checkout_adres ;
$checkout_city ;
$checkout_state;
$checkout_zip ;

//form card
$cardname ;
$cardnumber;
$expmonth;
$expyear;
$cvv;


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["firstname"]!="")
        $checkout_name = $user->security ($_POST["firstname"]);
    else $card_secure_durum = false;
    if($_POST["email"] !=""){
        if(filter_var($_POST["email"], FILTER_VALIDATE_EMAIL ))
            $checkout_email = $user->security ($_POST["email"]);
        else $card_secure_durum = false;
    }

    else $card_secure_durum = false;

    if(isset($_GET["m"]) && $_GET["m"]=="adres"){
        if($_POST["address"]!="")
            $checkout_adres=$user->security ($_POST["address"]);
        else $card_secure_durum = false;
        if($_POST["city"]!="")
            $checkout_city = $user->security ($_POST["city"]);
        else $card_secure_durum = false;
        if($_POST["state"]!="")
            $checkout_state = $user->security ($_POST["state"]);
        else $card_secure_durum = false;
        if($_POST["zip"]!=""){
            if(filter_var($_POST["zip"], FILTER_VALIDATE_INT ) )
                $checkout_zip = $user->security ($_POST["zip"]);
            else $card_secure_durum = false;
        } else $card_secure_durum = false;
    }else{
        $checkout_adres = $adresim;
    }


    ////////////ödeme/////////////
    if($_POST["cardname"]!="")
        $cardname = $user->security ($_POST["cardname"]);
    else $card_secure_durum = false;
    if($_POST["cardnumber"]!=""){
        if(filter_var($_POST["cardnumber"], FILTER_VALIDATE_INT ) )
            $checkout_zip = $user->security ($_POST["cardnumber"]);
        else $card_secure_durum = false;
    } else $card_secure_durum = false;
    if($_POST["expmonth"]!=""){
        if(filter_var($_POST["expmonth"], FILTER_VALIDATE_INT ) )
            $expmonth = $user->security ($_POST["expmonth"]);
        else $card_secure_durum = false;
    }else $card_secure_durum = false;
    if($_POST["expyear"]!=""){
        if(filter_var($_POST["expyear"], FILTER_VALIDATE_INT ) )
            $expyear = $user->security ($_POST["expyear"]);
        else $card_secure_durum = false;
    } else $card_secure_durum = false;
    if($_POST["cvv"]!=""){
        if(filter_var($_POST["cvv"], FILTER_VALIDATE_INT ) )
            $cvv = $user->security ($_POST["cvv"]);
        else $card_secure_durum = false;
    }else $card_secure_durum = false;



}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Ödeme Sayfası</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
</head>
<body>


<div class="row">
    <div class="col-75">
        <div class="container">
            <form action="checkout.php" method="post">

                <div class="row">
                    <div class="col-50">
                        <h3><?php if($card_secure_durum == false){?> <div class="content" style="color: red;">Girdiğiniz bilgiler hatalı</div><?php }?> <br>Fatura Adresi</h3>
                        <label for="fname"><i class="fa fa-user"></i> Tam İsim</label>
                        <input type="text" id="fname" name="firstname" placeholder="İsminiz">
                        <label for="email"><i class="fa fa-envelope"></i> Email</label>
                        <input type="text" id="email" name="email" placeholder="Email Adresiniz">
                        <?php if(isset($_GET["m"]) && $_GET["m"]=="adres"){ ?>
                            <div class="container">
                                <label for="adr"><i class="fa fa-address-card-o"></i> Adres</label>
                                <input type="text" id="adr" name="address" placeholder="Adres">
                                <div class="container">
                                    <label for="city"><i class="fa fa-institution"></i> Şehir</label>
                                    <select class="form-control" name="city">
                                        <?php for ($result = 1; $result<=81;$result++){ ?>
                                            <option value="<?=$result?>"><?=$city_array[$result]?></option>
                                        <?php } ?>
                                    </select>


                                    <div class="row" style="margin-top: 2%;">
                                        <div class="col-50">
                                            <label for="state">İlçe</label>
                                            <input type="text" id="state" name="state" placeholder="İlçe">
                                        </div>
                                        <div class="col-50">
                                            <label for="zip">Posta Kodu</label>
                                            <input type="number" id="zip" name="zip" placeholder="01030">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }else{?>
                            <ul class="list-group">
                                <li class="list-group-item disabled"><?=$adresim?></li>
                                <a href="<?=$realIp."/checkout.php?m=adres"?>">  <button type="button" class="btn btn-success">Farklı bir adres ekle</button></a>
                            </ul>
                        <?php }?>
                    </div>



                    <div class="col-50">

                        <h3>Ödeme</h3>

                        <label for="fname">Desteklenen kartlar</label>
                        <div class="icon-container">
                            <i class="fa fa-cc-visa" style="color:navy;"></i>
                            <i class="fa fa-cc-mastercard" style="color:red;"></i>
                        </div>

                        <div class="row">
                            <div class="col-50">

                                <label for="cname">Kart Üzerindeki İsim</label>
                                <input type="text" id="cname" name="cardname" placeholder="Enes Budak">
                                <div class="container">

                                    <div class="row" style="margin: 2%;">
                                        <label for="ccnum" style="margin-right: 2%;">Kredi Kartı Numarası</label>
                                        <input type="number" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">

                                    </div>
                                    <div class="row" style="margin: 2%;">
                                        <label for="expmonth" style="margin-right: 3%;">Son Kullanma Tarihi</label>
                                        <select  name="expmonth" class=" form-control-sm">
                                            <?php  for($result=1; $result<=12;$result++){  ?>
                                                <option value="<?=$result?>"><?=($result<10) ? "0".$result : $result ?> </option>
                                            <?php }  ?>
                                        </select>
                                        <select name="expyear" class=" form-control-sm">
                                            <?php  for($result=2018; $result<=2048;$result++){  ?>
                                                <option value="<?=$result?>"><?=$result?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="container" style="margin-top: 5%;" >
                                    <label for="cvv" style="margin-top:40px;">CVV</label>
                                    <input type="number" id="cvv" name="cvv"  placeholder="352">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <input type="hidden" value="user_pay_finished" name="user_pay">
                <button class="btn" type="submit">
                    Ödemeyi Tamamla
                </button>
            </form>
        </div>
    </div>
    <div class="col-25">
        <div class="container">
            <h4>Ürünler <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?=count($_SESSION["sepetim"])?></b></span></h4>
            <?php $item_top =0; foreach ($_SESSION["sepetim"] as $result){ $item_top +=$result[3]*$result[4] ?>
                <p><?=$result[2]?> <span class="price"><?php echo $result[3]*$result[4] ;?>  ₺</span></p>
            <?php }  ?>
            <hr>
            <p>Toplam <span class="price" style="color:black"><b><?=$item_top?> ₺</b></span></p>
        </div>
    </div>
</div>
</body>
</html>