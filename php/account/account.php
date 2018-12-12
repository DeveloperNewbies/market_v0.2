<?php
/**
 * Date: 2.12.2018
 * Time: 21:02
 */


    if($islogged)
    {
        $user_about = array(
            //0 eposta,
            //1 ad,
            //2 soyad,
            //3 tel,
            //4 adres1,
            //5 adres2
        );
        foreach ($user->getUserInfosOut() as $item)
        {
            array_push($user_about, $item);
        }

//Teslimat durumu
//Ürün görseli
//Sipariş No
//Ürün adı
//Ürün açıklaması
//Toplam fiyat
//Tarih

$siparisler = array(
    //0=>array("1","Teslim edilmedi","/images/harnup/harnupozu250ml.png","s_id","Harnup özü","234","23 Ocak 2018","213523","teslim ed adres"),
    //1=>array("1","Teslim edilmedi","/images/harnup/harnupozu250ml.png","12345","Harnup özü","234","23 Ocak 2018","216723"),
    //2=>array("3","Teslim edilmedi","/images/harnup/harnupozu250ml.png","12345","Harnup özü","234","23 Ocak 2018","217923"),
);
        if($user->getSiparisByUserID($user->getID()))
        {

            foreach ($user->getSiparisByUserID($user->getID()) as $siparis)
            {
                $siparis_tmp = array();
                $item_id = array();
                $item_ad = array();
                $item_img = array();
                $item_fiyat = array();
                $item_topfiyat = 0;
                $item_adet = array();

                if($user->getSiparisUrunInfo($siparis['id']))
                {
                    foreach ($user->getSiparisUrunInfo($siparis['id']) as $item)
                    {
                        array_push($item_id, $item['urun_id']);
                        array_push($item_ad, $item['urun_ad']);
                        array_push($item_img, "../".$user->getUrunIMG($item['urun_id'])[0][2]);
                        array_push($item_fiyat, $item['urun_fiyat']);
                        $item_topfiyat += $item['urun_fiyat'];
                        array_push($item_adet, $item['urun_adet']);
                    }
                    array_push($item_fiyat, $item_topfiyat);

                }


                array_push($siparis_tmp, $item_id);
                array_push($siparis_tmp, ($siparis['satis_sonuc'] > 0) ? (($siparis['satis_sonuc'] > 1) ? (($siparis['satis_sonuc'] > 2) ? "Sipariş Tamamlandı!":"Sipariş İadesi Bekleniyor") : "Sipariş Kargoda") : "Kargo Bilgisi Bekleniyor");
                array_push($siparis_tmp, $item_img);
                array_push($siparis_tmp, $siparis['id']);
                array_push($siparis_tmp, $item_ad);
                array_push($siparis_tmp, $item_fiyat);
                array_push($siparis_tmp, $item_adet);
                if($user->getSiparisFaturaInfo($siparis['id']))
                {
                    foreach ($user->getSiparisFaturaInfo($siparis['id']) as $item)
                    {
                        array_push($siparis_tmp, $item['u_adress']);
                    }
                }

                array_push($siparis_tmp, $siparis['tarih']);
                array_push($siparis_tmp, $siparis['last_op_date']);
                array_push($siparis_tmp, ($siparis['kargo_takip_no'] == 0)? "-":$siparis['kargo_takip_no']);
                array_push($siparisler, $siparis_tmp);
            }
        }else
            {

            }

$account_url = isset($_GET["account"]) ? $_GET["account"] : "hesabim";

?>



<div class="wrapper" style="margin-top: 20px; margin-bottom: 20px;">
    <?php
    switch ($account_url) {
        case "sepetim":
            require_once ( "orders.php" );
            break;
        case  "hesabim":
            require_once ( "my_account.php" );
            break;
        case "siparis":
            require_once ( "siparis.php" );
            break;
        default:
            echo  "hata";
            ?>
            <!-- Page Content
            <div id="content">

                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">


                    </div>
                </nav>

                <h2>Collapsible Sidebar Using Bootstrap 4</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                <div class="line"></div>

                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                <div class="line"></div>

                <h2>Lorem Ipsum Dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                <div class="line"></div>

                <h3>Lorem Ipsum Dolor</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>

 -->
            <?php
            break;
    }
    ?>

</div>

<?php }else{
        header("Refresh: 0; url=http://".$realip."/");
    } ?>