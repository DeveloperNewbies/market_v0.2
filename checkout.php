<?php
/**
 * Created by PhpStorm.
 * User: Mehme
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
require_once("language.php");
session_start();
$ipset = new secIP();
$card_secure_durum = true;
$card_inputs_ok = false;
/** @var $user user */
$user;
//$realip = "https://".$ipset->getLocal().":".$ipset->getPort().$ipset->getFile();
//Yukardaki Gibi "https://". koyma Simcap Koymaaaa!
$realip = $ipset->getLocal().$ipset->getFile();


//form post
$checkout_name ;
$checkout_surname;
$checkout_email ;
$checkout_adres;
$checkout_city ;
$checkout_state;
$checkout_zip ;
$checkout_number = "";

if(isset($_GET["lang"])){
  $lang = is_string(trim($_GET["lang"])) ? trim($_GET["lang"]) : "tr";
  $_SESSION["lang"] = $lang;
}else if(isset($_SESSION["lang"])){
  $lang =$_SESSION["lang"];
}else{
  $lang = "tr";
}

$m = "";
if(!isset($_SESSION['user']))
{
    header("location: ".$realip."/login/index.php?url=checkout.php");
}else
{
    if(!isset($_POST['checkout']) && !isset($_SESSION['sepetim']))
        header("location: ".$realip);
    else
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
        if(isset($_POST['checkout_adres']))
            $m = $user->security($_POST['checkout_adres'], "ch_adress");

        $infos = $user->getUserInfosOut();

        $checkout_name = $infos['ad'];
        $checkout_surname = $infos['soyad'];
        $checkout_email = $infos['e-posta'];
        $checkout_number = $infos['tel'];
        $checkout_adres = $infos['adres'];
        $adresim =  $infos['adres'];



    }

}

if(!$islogged)
{
    header("location: ".$realip."/login");
}else
{
    $card_secure_durum = true;



//checkout_s_id is set from db but for test u could take it a number
    $checkout_s_id = 1;
    $checkout_ip = "";
    if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
        $checkout_ip = $_SERVER["HTTP_CLIENT_IP"];
    } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
        $checkout_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else {
        $checkout_ip = $_SERVER["REMOTE_ADDR"];
    }
    $checkout_amount = 0;
    $checkout_list=array();




    if(isset($_POST['ok_checkout'])) {
        if (isset($_POST['firstname']) && $_POST['firstname'] != "")
            $checkout_name = $user->security($_POST['firstname'], "adres");
        else $card_secure_durum = false;
        if (isset($_POST['email']) && $_POST["email"] != "") {
            if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
                $checkout_email = $user->security($_POST["email"], "adres");
            else $card_secure_durum = false;
        } else $card_secure_durum = false;
        if (isset($_POST['phone-number']) && $_POST["phone-number"] != "") {
            if (is_numeric($_POST['phone-number']))
                $checkout_number = $user->security($_POST["phone-number"]);
            else $card_secure_durum = false;
        } else $card_secure_durum = false;

        if ($card_secure_durum) {
            $name = explode(" ", $checkout_name);
            $checkout_name = "";
            for ($i = 0; $i < count($name); $i++) {
                if (($i + 1) == count($name))
                    $checkout_surname = $name[$i];
                else
                    $checkout_name .= $name[$i] . " ";
            }
        }

        if (!isset($_POST['checkout_adres_static'])) {
            if (isset($_POST['address']) && $_POST['address'] != "") {
                $checkout_adres = $user->security($_POST['address'], "adres");
                $adresim = $checkout_adres;
            } else $card_secure_durum = false;
            if (isset($_POST['city']) && $_POST['city'] != "")
                $checkout_city = $user->security($_POST['city'], "adres");
            else $card_secure_durum = false;
            if (isset($_POST['state']) && $_POST['state'] != "")
                $checkout_state = $user->security($_POST['state'], "adres");
            else $card_secure_durum = false;
            if (isset($_POST['zip']) && $_POST['zip'] != "") {
                if (is_numeric($_POST['zip']))
                    $checkout_zip = $user->security($_POST['zip']);
                else $card_secure_durum = false;
            } else $card_secure_durum = false;
            if (isset($_POST['phone-number']) && $_POST['phone-number'] != "") {
                if (is_numeric($_POST['phone-number']))
                    $checkout_number = $user->security($_POST['phone-number']);
                else $card_secure_durum = false;
            } else $card_secure_durum = false;
            if ($card_secure_durum) {
                $checkout_adres = $checkout_city . "/" . $checkout_state . " - " . $checkout_adres . " " . $checkout_zip;


            } else {
                $checkout_adres = $adresim;
            }
        } else {
            if (isset($_POST['address']) && $_POST['address'] != "") {
                $checkout_adres = $user->security($_POST['address'], "adres");
                $adresim = $checkout_adres;
            } else $card_secure_durum = false;
        }


        if($card_secure_durum == true)
            $card_inputs_ok = true;
        else
            $card_inputs_ok = false;

        foreach ($_SESSION['sepetim'] as $item) {
            $checkout_tmp_list = array();
            $checkout_amount += $item['3'] * $item['5'] * 100;
            array_push($checkout_tmp_list, $item['2']);
            array_push($checkout_tmp_list, $item['3']);
            array_push($checkout_tmp_list, $item['5']);
            array_push($checkout_list, $checkout_tmp_list);
        }
    }
    if($card_secure_durum != false && $card_inputs_ok != false)
    {
        //Buradan Apiye Data Yollanacak
        ####################### DÜZENLEMESİ ZORUNLU ALANLAR #######################
        #
        ## API Entegrasyon Bilgileri - Mağaza paneline giriş yaparak BİLGİ sayfasından alabilirsiniz.
        $merchant_id 	= '125781';
        $merchant_key 	= 'UTFL8d85tM4C2huL';
        $merchant_salt	= 'ceqZRNm5jaFykuax';
        #
        ## Müşterinizin sitenizde kayıtlı veya form vasıtasıyla aldığınız eposta adresi
        $email = $checkout_email;
        #
        ## Tahsil edilecek tutar.
        $payment_amount	= $checkout_amount; //9.99 için 9.99 * 100 = 999 gönderilmelidir.
        #
        ## Sipariş numarası: Her işlemde benzersiz olmalıdır!! Bu bilgi bildirim sayfanıza yapılacak bildirimde geri gönderilir.
        $merchant_oid = $checkout_s_id;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız ad ve soyad bilgisi
        $user_name = $checkout_name.$checkout_surname;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız adres bilgisi
        $user_address = $checkout_adres;
        #
        ## Müşterinizin sitenizde kayıtlı veya form aracılığıyla aldığınız telefon bilgisi
        $user_phone = $checkout_number;
        #
        ## Başarılı ödeme sonrası müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi onaylayacağınız sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi onaylayacağız sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_ok_url = "https://www.optimumilac.com/bildirim.php";
        #
        ## Ödeme sürecinde beklenmedik bir hata oluşması durumunda müşterinizin yönlendirileceği sayfa
        ## !!! Bu sayfa siparişi iptal edeceğiniz sayfa değildir! Yalnızca müşterinizi bilgilendireceğiniz sayfadır!
        ## !!! Siparişi iptal edeceğiniz sayfa "Bildirim URL" sayfasıdır (Bakınız: 2.ADIM Klasörü).
        $merchant_fail_url = "https://www.optimumilac.com/bildirim.php";
        #
        ## Müşterinin sepet/sipariş içeriği
        $user_basket = $checkout_list;
        #
        /* ÖRNEK $user_basket oluşturma - Ürün adedine göre array'leri çoğaltabilirsiniz
        $user_basket = base64_encode(json_encode(array(
            array("Örnek ürün 1", "18.00", 1), // 1. ürün (Ürün Ad - Birim Fiyat - Adet )
            array("Örnek ürün 2", "33.25", 2), // 2. ürün (Ürün Ad - Birim Fiyat - Adet )
            array("Örnek ürün 3", "45.42", 1)  // 3. ürün (Ürün Ad - Birim Fiyat - Adet )
        )));
        */
        ############################################################################################

        ## Kullanıcının IP adresi
        if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        ## !!! Eğer bu örnek kodu sunucuda değil local makinanızda çalıştırıyorsanız
        ## buraya dış ip adresinizi (https://www.whatismyip.com/) yazmalısınız. Aksi halde geçersiz paytr_token hatası alırsınız.
        $user_ip=$checkout_ip;
        ##

        ## İşlem zaman aşımı süresi - dakika cinsinden
        $timeout_limit = "30";

        ## Hata mesajlarının ekrana basılması için entegrasyon ve test sürecinde 1 olarak bırakın. Daha sonra 0 yapabilirsiniz.
        $debug_on = 1;

        ## Mağaza canlı modda iken test işlem yapmak için 1 olarak gönderilebilir.
        $test_mode = 0;

        $no_installment	= 0; // Taksit yapılmasını istemiyorsanız, sadece tek çekim sunacaksanız 1 yapın

        ## Sayfada görüntülenecek taksit adedini sınırlamak istiyorsanız uygun şekilde değiştirin.
        ## Sıfır (0) gönderilmesi durumunda yürürlükteki en fazla izin verilen taksit geçerli olur.
        $max_installment = 0;

        $currency = "TL";

        $checkout_s_id = $user->addSiparis($user->getID(), $checkout_name, $checkout_surname, $checkout_adres, $checkout_ip, $_SESSION['sepetim'], $checkout_number, false);
        $merchant_oid = $checkout_s_id+30;

        ####### Bu kısımda herhangi bir değişiklik yapmanıza gerek yoktur. #######
        $hash_str = $merchant_id .$user_ip .$merchant_oid .$email .$payment_amount .$user_basket.$no_installment.$max_installment.$currency.$test_mode;
        $paytr_token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));
        $post_vals=array(
            'merchant_id'=>$merchant_id,
            'user_ip'=>$user_ip,
            'merchant_oid'=>$merchant_oid,
            'email'=>$email,
            'payment_amount'=>$payment_amount,
            'paytr_token'=>$paytr_token,
            'user_basket'=>$user_basket,
            'debug_on'=>$debug_on,
            'no_installment'=>$no_installment,
            'max_installment'=>$max_installment,
            'user_name'=>$user_name,
            'user_address'=>$user_address,
            'user_phone'=>$user_phone,
            'merchant_ok_url'=>$merchant_ok_url,
            'merchant_fail_url'=>$merchant_fail_url,
            'timeout_limit'=>$timeout_limit,
            'currency'=>$currency,
            'test_mode'=>$test_mode
        );

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/api/get-token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = @curl_exec($ch);

        if(curl_errno($ch))
            die("PAYTR IFRAME connection error. err:".curl_error($ch));

        curl_close($ch);

        $result=json_decode($result,1);

        if($result['status']=='success')
            $token=$result['token'];
        else
            die("PAYTR IFRAME failed. reason:".$result['reason']);
        #########################################################################


        ?>

        <script src="https://www.paytr.com/js/iframeResizer.min.js">
            iFrameResize({},'#paytriframe');
            $('iframe paytriframe').attr('target', '_blank');

        </script>
        <iframe target="_blank" src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe" frameborder="0" scrolling="no" style="width: 100%;"></iframe>
    <?php }else{ ?>




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
                        <input type="hidden" value="" name="checkout"/>
                        <div class="row">
                            <div class="col-50">
                                <h3><?php if($card_secure_durum == false){?> <div class="content" style="color: red;"><?=$m_lang[$lang][59]?></div><?php }?> <br><?=$m_lang[$lang][92]?></h3>
                                <label for="fname"><i class="fa fa-user"></i> <?=$m_lang[$lang][60]?></label>
                                <input type="text" id="fname" name="firstname" placeholder="İsminiz" value="<?php echo $checkout_name." ".$checkout_surname; ?>" required/>
                                <label for="email"><i class="fa fa-envelope"></i> Email</label>

                                <input type="text" id="email" name="email" placeholder="Email Adresiniz" value="<?php echo $checkout_email; ?>" required/>
                                <label for="fname"><i class="fa fa-phone"></i> <?=$m_lang[$lang][40]?></label>
                                <input type="text" id="zp" name="phone-number" class="fa fa-address-card-o" minlength="10" maxlength="11" placeholder="Telefon numarası" value="<?php echo ($checkout_number != "0") ? $checkout_number : ""; ?>" required/>
                                <?php if($m == "Yeni Adres Ekle"){ ?>
                                    <div class="container">
                                        <label for="adr"><i class="fa fa-address-card-o"></i> <?=$m_lang[$lang][39]?></label>


                                        <div class="container">
                                            <label for="city"><i class="fa fa-institution"></i> <?=$m_lang[$lang][93]?></label>
                                            <select class="form-control" name="city" required/>
                                            <?php for ($result = 1; $result<=81;$result++){ ?>
                                                <option value="<?=$city_array[$result]?>"><?=$city_array[$result]?></option>
                                            <?php } ?>
                                            </select>


                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-50">
                                                    <label for="state"><?=$m_lang[$lang][94]?></label>
                                                    <input type="text" id="state" name="state" placeholder="<?=$m_lang[$lang][94]?>" required/>
                                                </div>
                                                <div class="col-50">
                                                    <label for="zip"><?=$m_lang[$lang][95]?></label>
                                                    <input type="number" id="zip" name="zip" placeholder="01030" required/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="container">
                                            <label for="adresss"><i class="fa fa-institution"><?=$m_lang[$lang][96]?></i></label>
                                            <input type="text" id="adr" name="address" minlength="1" placeholder="<?=$m_lang[$lang][96]?>" required/>
                                        </div>
                                    </div>

                                <?php }else{?>
                                    <ul class="list-group">
                                        <label for="adresss"><i class="fa fa-institution"><?=$m_lang[$lang][39]?></i></label>
                                        <input type="text" class="fa fa-address-card-o" placeholder="<?=$m_lang[$lang][39]?>:" value="<?php echo ($adresim!="") ? $adresim:""; ?>" disabled>
                                        <input type="hidden" name="address" value="<?php echo ($adresim!="") ? $adresim:""; ?>">

                                        <input type="hidden" value="" name="checkout_adres_static"/>
                                        <input type="submit" name="checkout_adres" value="Yeni Adres Ekle" class="btn"/>
                                    </ul>
                                <?php }?>
                            </div>




                        </div>
                        <input type="hidden" value="user_pay_finished" name="user_pay"/>
                        <input type="submit" name="ok_checkout" class="btn" value="Ödemeyi Tamamla"/>
                    </form>
                </div>
            </div>
            <div class="col-25">
                <div class="container">
                    <h4><?=$m_lang[$lang][27]?> <span class="price" style="color:black"><i class="fa fa-shopping-cart"></i> <b><?=count($_SESSION["sepetim"])?></b></span></h4>
                    <?php $item_top =0; foreach ($_SESSION['sepetim'] as $result){ $item_top +=$result[3]*$result[5] ?>
                        <p><?=$result[2]?> <span class="price"><?php echo $result[3]*$result[5] ;?> ₺</span></p>
                    <?php }  ?>
                    <hr>
                    <p><?=$m_lang[$lang][80]?> <span class="price" style="color:black"><b><?=$item_top?> ₺</b></span></p>
                </div>
            </div>

        </div>
        </body>
        </html>
    <?php } ?>

<?php } ?>


