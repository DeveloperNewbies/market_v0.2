<?php
/**
 * Date: 30.11.2018
 * Time: 20:28
 */
//What've you Found huh?
//What've you Found huh?
date_default_timezone_set('Europe/Istanbul');
//What've you Found huh?
require_once('../inc/secIP.php');
require_once('../inc/userClass.php');

//What've you Found huh?

session_start();
$ipset = new secIP();
//What've you Found huh?
$realip = "".$ipset->getLocal().$ipset->getFile();
$user_granted = false;
/** @var $user user  */
$user;
//What've you Found huh?
mb_internal_encoding('UTF-8');
if(isset($_SESSION['user']))
{
//What've you Found huh?
    $user = new user();
    $user = unserialize(base64_decode($_SESSION['user']));
    $u_adress = $ipset->findUserIp();
    $info=''.$_SERVER['HTTP_USER_AGENT'].''.$u_adress.''.$user->getID().''.$_SESSION['user'].'';
    $hash = hash("sha256", $info);
    $remote_hash = '';
    foreach($user->getHash() as $row)
    {
        $remote_hash = $row['session_hash'];
    }
    if($user->getIp() != $u_adress || $hash != $remote_hash)
    {
        $user->logOut();
        session_destroy();
        echo 'Oturum bilgisi ihlali!';
        header("Refresh: 3;");
        return;
    }
    if($user->getPermission() < 2)
    {

        header("Refresh: 0; url=".$realip."/admin/login.php");
        return;
    }
    if(isset($_GET['m']))
    {
        if($_GET['m'] == "logout")
        {
            $user->logOut();
            session_destroy();
            echo 'Logged Out';
            header("Refresh: 1; url=".$realip."/");
            return;
        }
    }
    $user_granted = true;
//echo ''. $user->showUserInfo();
}else
{

    header("Refresh: 0; url=".$realip."/admin/login.php");
    return;
}

if(isset($_GET["m"]))
    $url_m = $_GET["m"];
else
    $url_m ="home";

$language ="tr";
$title = "Anasayfa";
$charset = "UTF-8";
$home_link ="".$realip."/admin/index.php";



$logout_link =$home_link."/?m=logout";


if($user_granted)
{
    //admin variable
    $admin_username = $user->name." ".$user->surname;
    $whole_items = 0;
    $items_sold = 0;
    $items_sold_fin = 0;
    $active_items = 0;
    $total_income = 0;
    $tickets_closed = 0;
    $monthly_income = 0;

    //aktif satılan ürün sayısı mağazada bulunan
    if($user->getUrun("all", "admin"))
    {
        $active_items = count($user->getUrun("all"));
        $whole_items = count($user->getUrun("all", "admin"));
    }
    else
    {
        $active_items = 0;
        $whole_items = 0;
    }

    //toplam satılan ürün sayısı
    if($user->adminGetOrderCount("",""))
        $items_sold = count($user->adminGetOrderCount("",""));
    else
        $items_sold = 0;
    if($user->adminGetOrderCount("","", false ,"completed"))
    {
        $items_sold_fin = count($user->adminGetOrderCount("","", false ,"completed"));
    }
    else
    {
        $items_sold_fin = 0;
    }

    //toplam kullanıcı sayısı
    $total_users = ($user->getUserCount()) ? count($user->getUserCount()) : 0;
    //kullanıcı geri bildiirmleri (iade vs)
    $tickets_closed="0";
    //toplam gelir
    $total_tmp = $user->adminGetOrderCount("","");
    $total_income = 0;
    if($total_tmp)
    {
        foreach ($total_tmp as $item)
        {
            foreach ($user->adminGetSoldInfo($item['id']) as $item2)
                $total_income += $item2['urun_fiyat'];
        }
    }else
    {
        $total_income = 0;
    }


    //Calculate And Set User Monthly and Total İncome

    $monthly_tmp = $user->adminGetOrderCount("", "", true);
    if($monthly_tmp)
    {
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
    }else
    {
        $monthly_income = $total_income;
    }


    /////ad category /////
    if(isset($_POST["admin_category"])){
        $url_m = "ad-category";
        $cat_name = $user->security($_POST["ad_category"], "cat_name");
        $result = $user->adminAddNewCat($cat_name);
        if($result)
        {?>
        
        <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Başarılı!</strong> Kategori eklendi.
        </div>
        
    

                
         <?php

        }else
        {
            ?>
         
 
 <div class="alert alert-danger alert-dismissible">
   <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
   <strong>Başarısız!</strong> Kategori eklenemedi.
 </div>


<?php
        }
    }

    if(isset($_POST['admin_delete_cat']))
    {
        if(isset($_POST['cat_id']))
        {
            $url_m = "ad-category";
            $cat_id = $user->security($_POST['cat_id']);
            $c_result = $user->adminDeleteCat($cat_id);
            if($c_result == true)
            {?>

                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Başarılı!</strong> Kategori Silindi.
                </div>

            <?php }else
                {?>

                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Başarısız!</strong> Kategori Silinemedi.
                    </div>

                <?php }
        }
    }
    if(isset($_POST['add_new_item']))
    {
        //TODO check Security of Image And Add Category for The İtem. chmod Cant be 0777 img folder and name cant be Exactly Uploaded Name. Hash Them
        $url_m = "item-list";
        if(isset($_POST['category']) && isset($_POST['item_price']) && isset($_POST['item_desc']) && isset($_POST['item_name']) && isset($_POST['item_count']) && isset($_POST['item_kdv']))
        {
            if($_POST['item_name'] == "" || $_POST['item_price'] == "" || $_POST['category'] == "" || $_POST['item_count'] == "" || $_POST['item_kdv'] == "")
            {
                echo "Ürün İsmi, Fiyatı, KDV Oranı, Adeti veya Kategorisi boş bırakılamaz";
            }else
            {

                $item_name = $user->security($_POST['item_name']);
                $item_desc = $user->security($_POST['item_desc'], "desc");
                $item_price = $user->security($_POST['item_price']);
                $item_kdv = $user->security($_POST['item_kdv']);
                if($item_kdv == 0)
                    $item_kdv = 18;
                $item_count = $user->security($_POST['item_count']);
                $item_category = $user->security($_POST['category']);

                $item_img = array();
                $img_dest = preg_replace('/\s+/', '_', $item_name);
                $img_dest = mb_convert_case($img_dest, MB_CASE_LOWER, "UTF-8");
                $img_dest = md5($img_dest);

                $expensions= array("jpeg","jpg","png");
                $img_counter = 0;
                for($i = 0; $i<3; $i++) {
                    if (file_exists($_FILES['item-image-'.$i]['tmp_name']) && is_uploaded_file($_FILES['item-image-'.$i]['tmp_name'])) {
                        $errors = array();
                        $file_name = $_FILES['item-image-'.$i]['name'];
                        $file_size = $_FILES['item-image-'.$i]['size'];
                        $file_tmp = $_FILES['item-image-'.$i]['tmp_name'];
                        $tmp = explode('.', $_FILES[('item-image-'.$i)]['name']);
                        $file_ext = strtolower(end($tmp));
                        $expensions = array("jpeg", "jpg", "png");

                        if (in_array($file_ext, $expensions) === false) {
                            array_push($errors, $file_name . " Farklı Uzantılar Kabul Edilemez, Lütfen JPEG yada PNG Dosyası Yükleyin.");
                        }

                        if ($file_size > 4194304) {
                            array_push($errors, $file_name . " Dosya Boyutu 4 MB Aşamaz");
                        }

                        if (empty($errors) == true) {
                            array_push($item_img, array($file_tmp, $file_name));
                            //move_uploaded_file($file_tmp, "images/".$file_name);
                        }
                    }else
                    {
                        $img_counter++;
                    }
                }
                if($img_counter < 3)
                {
                    $last_id = $user->adminAddNewItem($item_name, $item_desc, $item_price, $item_kdv, $item_count, $item_category);
                    if($last_id)
                    {
                        if (!file_exists("../images/".$img_dest.$last_id)) {
                            mkdir("../images/".$img_dest.$last_id, 0777, true);
                        }
                        $i = 0;
                        foreach ($item_img as $item)
                        {

                            move_uploaded_file($item[0], "../images/".$img_dest.$last_id."/".$item[1]);
                            $add_img = $user->adminAddNewItemImg($last_id, $i, $img_dest, $item[1]);
                            $i++;
                        }
                        $i = 0;
                        echo "Yeni Ürün Ekleme Başarılı";

                    }else
                    {
                        echo "Yeni Ürün Ekleme Başarısız.";
                    }
                }else
                {
                    echo "En Az 1 Adet Ürün Görseli Eklemelisiniz.";
                }

            }
        }else
        {
            echo "Forma Boş Veri Gönderilemez";
        }

    }
//TODO Add to Market Boolean is_active And Set this Here!. and Check Variables is Secure?..
    if(isset($_POST['ch_item']))
    {
        $url_m = "item-list";

        if(isset($_POST['item_id']) && isset($_POST['category']) && isset($_POST['item_price']) && isset($_POST['item_desc']) && isset($_POST['item_name']) && isset($_POST['item_count']) && isset($_POST['item_kdv']))
        {
            if($_POST['item_id'] == "" || $_POST['item_name'] == "" || $_POST['item_price'] == "" || $_POST['category'] == "" || $_POST['item_count'] == "" || $_POST['item_kdv'] == "")
            {
                echo "Ürün İsmi, Fiyatı, KDV Oranı, Adeti veya Kategorisi boş bırakılamaz";
            }else
            {

                $item_id = $user->security($_POST['item_id']);
                $item_name = $user->security($_POST['item_name']);
                $item_desc = $user->security($_POST['item_desc'], "desc");
                $item_price = $user->security($_POST['item_price']);
                $item_kdv = $user->security($_POST['item_kdv']);
                $item_count = $user->security($_POST['item_count']);
                $item_category = $user->security($_POST['category']);
                $item_img = array();
                $img_dest = preg_replace('/\s+/', '_', $item_name);
                $img_dest = mb_convert_case($img_dest, MB_CASE_LOWER, "UTF-8");
                $img_dest = md5($img_dest);


                $expensions= array("jpeg","jpg","png");
                $img_counter = 0;
                for($i = 0; $i<3; $i++) {
                    if (file_exists($_FILES['item-image-'.$i]['tmp_name']) && is_uploaded_file($_FILES['item-image-'.$i]['tmp_name'])) {
                        $errors = array();
                        $file_name = $_FILES['item-image-'.$i]['name'];
                        $file_size = $_FILES['item-image-'.$i]['size'];
                        $file_tmp = $_FILES['item-image-'.$i]['tmp_name'];
                        $tmp = explode('.', $_FILES[('item-image-'.$i)]['name']);
                        $file_ext = strtolower(end($tmp));
                        $expensions = array("jpeg", "jpg", "png");

                        if (in_array($file_ext, $expensions) === false) {
                            array_push($errors, $file_name . " Farklı Uzantılar Kabul Edilemez, Lütfen JPEG yada PNG Dosyası Yükleyin.");
                        }

                        if ($file_size > 4194304) {
                            array_push($errors, $file_name . " Dosya Boyutu 4 MB Aşamaz");
                        }
                        if (empty($errors) == true) {
                            array_push($item_img, array($file_tmp, $file_name, $i));
                        }
                    }else
                    {
                        $img_counter++;
                    }
                }
                if($img_counter < 3)
                {
                    $is_ok = $user->adminEditItem($item_id, $item_name, $item_desc, $item_price, $item_kdv, $item_count, $item_category);
                    if($is_ok)
                    {
                        foreach ($item_img as $item)
                        {
                            if (!file_exists("../images/".$img_dest.$item_id."/".$item[1])) {
                                move_uploaded_file($item[0], "../images/".$img_dest.$item_id."/".$item[1]);
                                $add_img = $user->adminAddNewItemImg($item_id, $item[2], $img_dest, $item[1]);
                            }else
                            {
                                $add_img = $user->adminEditItemImg($item_id, $item[2], $img_dest, $item[1]);

                                echo "Herşey Yolunda";
                            }
                            //Delete Old Files in Server
                            $leave_files = array();
                            $new_files = $user->getUrunIMG($item_id);
                            foreach ($new_files as $file)
                            {
                                $img_name = explode("/", $file['urun_img']);
                                array_push($leave_files, $img_name[(count($img_name)-1)]);
                            }
                            foreach( glob("../images/".$img_dest.$item_id."/"."*") as $file ) {
                                if( !in_array(basename($file), $leave_files) )
                                    unlink($file);
                            }
                        }
                       echo $item_id;
                        if(isset($_POST['is_item_active']))
                            $result = $user->adminSetItemActive($item_id, true);
                        else
                           $result = $user->adminSetItemActive($item_id, false);

                        echo " ".($result)?"Ok":"false";
                        echo "Ürün Düzenleme Başarılı";

                    }else
                    {
                        echo "Ürün Düzenleme Başarısız.";
                    }
                }else
                {
                    $is_ok = $user->adminEditItem($item_id, $item_name, $item_desc, $item_price, $item_kdv, $item_count, $item_category);
                    if($is_ok)
                    {
						if(isset($_POST['is_item_active']))
                            $user->adminSetItemActive($item_id, true);
                        else
                            $user->adminSetItemActive($item_id, false);

                        echo "Ürün Düzenleme Başarılı";
                    }else
                    {
                        echo "Ürün Düzenlerken Bir Sorun Oluştu.";
                    }
                }

            }
        }else
        {
            echo "Forma Boş Veri Gönderilemez";
        }


    }

    if(isset($_POST['ch_ship']))
    {
        $url_m = "orders";

        if(isset($_POST['ship_id']) && isset($_POST['ship_shipnumber']) && isset($_POST['shippername']))
        {
            $ship_id = $user->security($_POST['ship_id']);
            $ship_number = $user->security($_POST['ship_shipnumber']);
            $shipper_name = $user->security($_POST['shippername'], "shipper");
            $shipment_result = ($ship_number == "0") ? 0:(isset($_POST['is_ship_reject']) ? 2:(isset($_POST['is_ship_ok']) ? 3: 1));
            $is_ok = $user->adminEditShipInfo($ship_id,$ship_number,$shipment_result, $shipper_name);
            if($is_ok)
            {
                echo "Sipariş Bilgisi Güncellendi!";
            }else
            {
                echo "Sipariş Bilgilerini Güncellerken Hata!";
            }
        }

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

        //orders_full_item bir sayfada toplam kaç sipariş görüneceğini belirler.
        $orders_full_item ="10";
        $orders_today_date = new DateTime('now');
        $orders_min_date = new DateTime($user->adminGetFirstLog());
        $orders_min_date->format("Y-m-d");
        $orders_sel_min_date;
        $orders_sel_max_date;
        $orders_min_default = $orders_today_date->format("Y-m-d");;
        $orders_max_default = $orders_today_date->format("Y-m-d");;
        $result;

        //sayfa adet bir seferde toplam kaç sayfanın aşağıda görüneceğini belirler
        $sayfa_adet = 5;

        $page_count = 0;
        $page_num = 1;


        //p Sayfa Numarası Tutar
        if(isset($_GET['p']))
        {
            if(is_numeric($_GET['p']))
            {
                $page_num = $user->security($_GET['p'], "page");
            }
        }else
        {
            //Sayfa Tıklanması Alınmadığında Sayfa Sayacını Sıfırla
            unset($_SESSION['page_counter']);
        }


        //Siparişleri Tarihe Göre Sıralama
        if(isset($_POST['especially']))
        {
            unset($_SESSION['page_counter']);
            if(isset($_POST['from']) && isset($_POST['to']))
            {
                $orders_sel_min_date = new DateTime($user->security($_POST['from'], "Date"));
                $orders_min_default = $orders_sel_min_date->format("Y-m-d");
                $orders_sel_max_date = new DateTime($user->security($_POST['to'], "Date"));
                $orders_max_default = $orders_sel_max_date->format("Y-m-d");
                //2. Tarih verisi ile Sitenin kurulduğu ilk gün arasındaki fark
                $difference = $orders_sel_min_date->diff($orders_min_date);
                $difference = ($difference->y * 12 * 30) + ($difference->m * 30) + $difference->d;
                //1. Tarih Verisi ile Sitenin Kurulduğu ilk gün arasındaki fark
                $difference2 = $orders_sel_max_date->diff($orders_min_date);
                $difference2 = ($difference2->y * 12 * 30) + ($difference2->m * 30) + $difference2->d;
                //Bugün İle Sitenin Kurulduğu ilk Gün Arasındaki fark
                $difference3 = $orders_today_date->diff($orders_min_date);
                $difference3 = ($difference3->y * 12 * 30) + ($difference3->m * 30) + $difference3->d;

                //1. Tarih Daha uzak Geçmiş Seçilmiş

                if($difference < $difference2)
                {
                    //Kullanıcı Site Kuruluş Tarihi ve Bugünün Tarihi Arasındaki farktan Daha Büyük Seçimler Yapamaz
                    if($difference2 > $difference3 || $difference > $difference3)
                    {
                        echo "Hatalı Tarih Seçimi Yaptınız";
                    }else
                    {
                        $orders_sel_max_date->modify("+1 day");
                        $orders_sel_max_date->modify("-1 second");
                        $page_count = $user->adminGetOrderCount("", "", false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                        $result = $user->adminGetOrderCount($orders_full_item, ($page_num-1)*$orders_full_item, false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                        $result1 = $user->adminGetOrderCount("" , "", false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                        $_SESSION['list'] = base64_encode(serialize(array(
                            "min" => $orders_sel_min_date,
                            "max" => $orders_sel_max_date
                        )));
                    }
                }elseif ($difference == $difference2)
                {
                    //Aynı Gün İçerisinde Verilen Siparişler İçindir.
                    $orders_sel_max_date->modify("+1 day");
                    $orders_sel_max_date->modify("-1 second");
                    $page_count = $user->adminGetOrderCount("", "", false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                    $result = $user->adminGetOrderCount($orders_full_item, ($page_num-1)*$orders_full_item, false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                    $result1 = $user->adminGetOrderCount("" , "", false, "uncompleted", $orders_sel_min_date->format("Y-m-d H:i:s"), $orders_sel_max_date->format("Y-m-d H:i:s"));
                    $_SESSION['list'] = base64_encode(serialize(array(
                        "min" => $orders_sel_min_date,
                        "max" => $orders_sel_max_date
                    )));
                }
                else
                {
                    //2. Tarih Daha Uzak Geçmiş seçilmiş
                    if($difference2 > $difference3 || $difference > $difference3)
                    {
                        echo "Hatalı Tarih Seçimi Yaptınız";
                    }else
                    {
                        $orders_sel_min_date->modify("+1 day");
                        $orders_sel_min_date->modify("-1 second");
                        $page_count = $user->adminGetOrderCount("", "", false, "uncompleted", $orders_sel_max_date->format("Y-m-d H:i:s"), $orders_sel_min_date->format("Y-m-d H:i:s"));
                        $result = $user->adminGetOrderCount($orders_full_item , ($page_num-1)*$orders_full_item, false, "uncompleted",  $orders_sel_max_date->format("Y-m-d H:i:s"), $orders_sel_min_date->format("Y-m-d H:i:s"));
                        $result1 = $user->adminGetOrderCount("" , "", false, "uncompleted", $orders_sel_max_date->format("Y-m-d H:i:s"), $orders_sel_min_date->format("Y-m-d H:i:s"));
                        $_SESSION['list'] = base64_encode(serialize(array(
                            "min" => $orders_sel_max_date,
                            "max" => $orders_sel_min_date
                        )));
                    }
                }

                if($page_count)
                {
                    $page_count = count($page_count);

                    $mod = $page_count % $orders_full_item;
                    if($mod != 0)
                        $page_count = (int)($page_count/$orders_full_item)+1;
                    elseif($page_count == 0)
                        $page_count++;
                    else
                        $page_count = (int)($page_count/$orders_full_item);


                }
                $is_listing = true;
            }
        }else
        {
            //Tarih Seçimi Yapılmadı
            if(isset($_GET['l']))
            {

                $is_listing = true;
                if(isset($_SESSION['list']))
                {

                    $result_old = unserialize(base64_decode($_SESSION['list']));
                    $orders_min_default = $result1["min"]->format("Y-m-d");
                    $orders_max_default = $result1["max"]->format("Y-m-d");

                    $page_count = $user->adminGetOrderCount("", "", false, "uncompleted", $result_old["min"]->format("Y-m-d H:i:s"), $result_old["max"]->format("Y-m-d H:i:s"));
                    $result = $user->adminGetOrderCount($orders_full_item, ($page_num-1)*$orders_full_item, false, "uncompleted", $result_old["min"]->format("Y-m-d H:i:s"), $result_old["max"]->format("Y-m-d H:i:s"));
                    $result1 = $user->adminGetOrderCount("" , "", false, "uncompleted", $result_old["min"]->format("Y-m-d H:i:s"), $result_old["max"]->format("Y-m-d H:i:s"));
                    if($page_count)
                    {
                        $page_count = count($page_count);
                        $mod = $page_count % $orders_full_item;
                        if($mod != 0)
                            $page_count = (int)($page_count/$orders_full_item)+1;
                        elseif($page_count == 0)
                            $page_count++;
                        else
                            $page_count = (int)($page_count/$orders_full_item);
                    }

                }

            }else
            {
                $page_count = $user->adminGetOrderCount("" , "", false);
                $result = $user->adminGetOrderCount($orders_full_item , ($page_num-1)*$orders_full_item, false);
                $result1 = $user->adminGetOrderCount("" , "", false);
                //SESSION['list'] Bir Tarih Limiti Girildiğinde Bunu Hafızada Tutar ve Hangi işi Yaptığımızı anlamamızı sağlar
                unset($_SESSION['list']);
                if($page_count)
                {
                    $page_count = count($page_count);
                    $mod = $page_count % $orders_full_item;
                    if($mod != 0)
                        $page_count = (int)($page_count/$orders_full_item)+1;
                    elseif($page_count == 0)
                        $page_count++;
                    else
                        $page_count = (int)($page_count/$orders_full_item);
                }
            }

        }


        if(isset($_SESSION['page_counter']))
        {
            if(isset($_GET['prev']))
                if($_SESSION['page_counter'] > 0)
                    $_SESSION['page_counter'] = $_SESSION['page_counter'] - 1;


            if(isset($_GET['next']))
                if(($_SESSION['page_counter'] + 1) * $sayfa_adet < $page_count)
                    $_SESSION['page_counter'] = $_SESSION['page_counter'] + 1;

            $page_counter = $_SESSION['page_counter'];
        }
        else
        {
            $_SESSION['page_counter'] = 0;
            $page_counter = 0;
        }



        $shipping_list_array = array(
            //0 index ürün görsel linki
            //1 index ürün title
            //2 index ürün id si
            //3 index ürün sipariş id
            //4 index sipariş adeti
            //5 index Fiyat
            //6 index Kategori
            //7 index Alıcı
            //8 index Kargo Numarası
            //9 index Sipariş Durum
            //10 index Sipariş Tarih
        );



        if(isset($result1))
        {
            if($result1)
            {
                $i = 0;
                foreach ($result1 as $item)
                {
                    array_push($shipping_list_array, array());
                    if($user->adminGetSoldInfo($item['id']))
                    {
                        $item_img = array();
                        $item_name = array();
                        $item_id = array();
                        foreach ($user->adminGetSoldInfo($item['id']) as $item1)
                        {

                            array_push($item_img, "../".$user->getUrunIMG($item1['urun_id'])[0][2]);
                            array_push($item_name, $item1['urun_ad']);
                            array_push($item_id, $item1['urun_id']);
                        }
                        array_push($shipping_list_array[$i], $item_img);
                        array_push($shipping_list_array[$i], $item_name);
                        array_push($shipping_list_array[$i], $item_id);
                    }
                    array_push($shipping_list_array[$i], $item['id']);
                    if($user->adminGetSoldInfo($item['id']))
                    {
                        $item_adet = array();
                        $item_price = array();
                        $item_kateg = array();
                        $item_top = 0;
                        foreach ($user->adminGetSoldInfo($item['id']) as $item1)
                        {

                            array_push($item_adet, $item1['urun_adet']);
                            array_push($item_price, $item1['urun_fiyat']);
                            $item_top += $item1['urun_fiyat'];
                            foreach ($user->getUrun($item1['urun_id'], "admin") as $item2)
                            {
                                array_push($item_kateg, $user->getUrunKategori($item2['urun_grup'])[0][0]);
                            }
                        }
                        array_push($item_price, $item_top);
                        array_push($shipping_list_array[$i], $item_adet);
                        array_push($shipping_list_array[$i], $item_price);
                        array_push($shipping_list_array[$i], $item_kateg);
                    }


                    foreach ($user->adminFindUser($item['id']) as $item1)
                    {
                        array_push($shipping_list_array[$i], $item1['k_ad']);
                    }

                    array_push($shipping_list_array[$i], $item['kargo_takip_no']);
                    array_push($shipping_list_array[$i], $item['satis_sonuc']);
                    array_push($shipping_list_array[$i], $item['tarih']);
                    $i++;
                }
                $i = 0;
                $j = -1;

                //mb_wex Client Info Array
                $mb_wex = array(
                    /*
                     * array(
                     * //0 Siparis ID
                     * //1 Client Name Surname
                     * //2 Client Mail
                     * //3 Client Phone
                     * //4 Client Adress
                     * ),
                     * */
                );
                foreach ($shipping_list_array as $item)
                {
                    array_push($mb_wex, array());
                    array_push($mb_wex[$i], $item[3]);
                    array_push($mb_wex[$i], (($user->adminGetBillInfo($item[3]))[0][3]).''.(($user->adminGetBillInfo($item[3]))[0][4]));
                    array_push($mb_wex[$i], $user->findUser((($user->adminGetBillInfo($item[3]))[0][2]))[0][1]);
                    array_push($mb_wex[$i], (($user->adminGetBillInfo($item[3]))[0][6]));
                    array_push($mb_wex[$i], (($user->adminGetBillInfo($item[3]))[0][5]));
                    $i++;
                }

                $j = 0;

                $i = 0;
                $j = -1;

                //ksl_wex Exact Order List Array
                $ksl_wex = array(
                    /*
                     * array(
                     * //0 Order ID
                     * //1 Client Name Surname
                     * //2 Client identification number/Client tax number
                     * //3 Client tax name
                     * //4 array of Ordered Item
                     *  array(
                     *          //0 $shipping_list_array[2] = item_id() array
                     *          array(),
                     *          //1 $shipping_list_array[1] = item_name() array
                     *          array(),
                     *          //2 $shipping_list_array[4] = $item_adet() array
                     *          array(),
                     *          //3 $shipping_list_array[5] = $item_price() array
                     *          array()
                     *      )
                     * //5 Exact Price $shipping_list_array[4][count($shipping_list_array[4])-1] = $item_top
                     * //6 Client Mail
                     * //7 Client Phone
                     * //8 Client Adress
                     * ),
                     *
                     *
                     * */
                );

                foreach ($shipping_list_array as $item)
                {

                    array_push($ksl_wex, array());
                    array_push($ksl_wex[$i], $item[3]);
                    array_push($ksl_wex[$i], (($user->adminGetBillInfo($item[3]))[0][3]).''.(($user->adminGetBillInfo($item[3]))[0][4]));
                    array_push($ksl_wex[$i], "0/0");
                    array_push($ksl_wex[$i], "-");



                    //push ordered item infos
                    array_push($ksl_wex[$i], array());

                    array_push($ksl_wex[$i][4], $item[2]);
                    array_push($ksl_wex[$i][4], $item[1]);
                    array_push($ksl_wex[$i][4], $item[4]);
                    array_push($ksl_wex[$i][4], $item[5]);
                    //Push Total Fund
                    array_push($ksl_wex[$i], $item[5][count($item[5])-1]);


                    //Order Email
                    array_push($ksl_wex[$i], $user->findUser((($user->adminGetBillInfo($item[3]))[0][2]))[0][1]);
                    //Ordered Phone
                    array_push($ksl_wex[$i], (($user->adminGetBillInfo($item[3]))[0][6]));
                    //Orderer Adress
                    array_push($ksl_wex[$i], (($user->adminGetBillInfo($item[3]))[0][5]));
                    $i++;
                }
            }
        }


        $shipping_list_array = array(
            //0 index ürün görsel linki
            //1 index ürün title
            //2 index ürün id si
            //3 index ürün sipariş id
            //4 index sipariş adeti
            //5 index Fiyat
            //6 index Kategori
            //7 index Alıcı
            //8 index Kargo Numarası
            //9 index Sipariş Durum
            //10 index Sipariş Tarih
        );



        if($result)
        {
            $i = 0;
            foreach ($result as $item)
            {
                array_push($shipping_list_array, array());
                if($user->adminGetSoldInfo($item['id']))
                {
                    $item_img = array();
                    $item_name = array();
                    $item_id = array();
                    foreach ($user->adminGetSoldInfo($item['id']) as $item1)
                    {

                        array_push($item_img, "../".$user->getUrunIMG($item1['urun_id'])[0][2]);
                        array_push($item_name, $item1['urun_ad']);
                        array_push($item_id, $item1['urun_id']);
                    }
                    array_push($shipping_list_array[$i], $item_img);
                    array_push($shipping_list_array[$i], $item_name);
                    array_push($shipping_list_array[$i], $item_id);
                }
                array_push($shipping_list_array[$i], $item['id']);
                if($user->adminGetSoldInfo($item['id']))
                {
                    $item_adet = array();
                    $item_price = array();
                    $item_kateg = array();
                    $item_top = 0;
                    foreach ($user->adminGetSoldInfo($item['id']) as $item1)
                    {

                        array_push($item_adet, $item1['urun_adet']);
                        array_push($item_price, $item1['urun_fiyat']);
                        $item_top += $item1['urun_fiyat'];
                        foreach ($user->getUrun($item1['urun_id'], "admin") as $item2)
                        {
                            array_push($item_kateg, $user->getUrunKategori($item2['urun_grup'])[0][0]);
                        }
                    }
                    array_push($item_price, $item_top);
                    array_push($shipping_list_array[$i], $item_adet);
                    array_push($shipping_list_array[$i], $item_price);
                    array_push($shipping_list_array[$i], $item_kateg);
                }


                foreach ($user->adminFindUser($item['id']) as $item1)
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

        $result = $user->getUrun("all", "admin");
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
                foreach ($user->getUrun($item['urun_id'], "admin") as $item1)
                {
                    array_push($item_list_array[$i], $user->getUrunKategori($item1['urun_grup'])[0][1]);
                }
                array_push($item_list_array[$i], $item['urun_id']);
                array_push($item_list_array[$i], $item['urun_tarih']);
                $i++;
            }
        }
    }else if($url_m=="item-editor")
    {
        $editor_name = "Ürün Ekle";
        $editor_itemid = "";
        $editor_itemname = "";
        $editor_itemdesc = "";
        $editor_itemprice = "";
        $editor_itemkdv = "";
        $editor_itemcount = "";
        $editor_itemcat = array();
        $editor_defaultopt = "";

        foreach ($user->getUrunKategori("all") as $item)
        {
            $array_tmp = array();
            array_push($array_tmp, $item['item_cat_id']);
            array_push($array_tmp, $item['item_cat_name']);
            array_push($editor_itemcat, $array_tmp);
        }
        $editor_itemimg = array("","","");
        $editor_process = "Ekle";

        if(isset($_GET['c']))
        {

            if(isset($_GET['e']))
            {
                if($_GET['e'] == "delete")
                {
                    $user->adminDeleteItem($user->security($_GET['c']));
                }
            }else
            {
                $editor_name = "Ürün Düzenle";

                $item_id = $user->security($_GET['c']);
                $result = $user->getUrun($item_id, "admin");

                foreach ($result as $item)
                {
                    $editor_itemid = $item['urun_id'];
                    $editor_itemname = $item['urun_ad'];
                    $editor_itemdesc = $item['urun_aciklama'];
                    $editor_itemprice = $item['urun_fiyat'];
                    $editor_itemkdv = $item['kdv'];
                    $editor_itemcount = $item['urun_adet'];
                    foreach ($user->getUrun($editor_itemid, "admin") as $item1)
                    {
                        $editor_defaultopt = $item1['urun_grup'];
                    }
                    $editor_itemimg = array();
                    $i = 0;
                    foreach ($user->getUrunIMG($editor_itemid) as $item1)
                    {
                        array_push($editor_itemimg, $item1['urun_img']);
                        $i++;
                    }
                    for ($j = $i; $j < 3; $j++)
                        array_push($editor_itemimg, "");
                    $editor_process = "Kaydet";
                    $user->adminSetItemActive($item_id, false);
                }
            }

        }else if (isset($_GET['c_siparis']))
        {

            if(isset($_GET['e']))
            {
                if($_GET['e'] == "delete")
                {
                    $delete = $user->adminDeleteOrder($user->security($_GET['c_siparis']));
                    if($delete)
                    {
                        echo "Sipariş Silindi";
                    }else
                    {
                        echo "Sipariş Bulunamadı Yada silinemedi";
                    }
                }
            }else
            {
                $editor_name = "Sipariş Düzenle";

                $c_siparis = $user->security($_GET['c_siparis']);
                $result = $user->adminGetOrderCount("","", '' ,$c_siparis);
                $editor_ship_id = $c_siparis;
                $editor_itemid = array();
                $editor_itemname = array();
                $editor_itemprice = array();
                $editor_shipcount = array();
                $editor_itempricefull = 0;
                $editor_cargo = "";
                foreach ($result as $item) {

                    foreach ($user->adminGetSoldInfo($item['id']) as $item1)
                    {
                        array_push($editor_itemid, $item1['urun_id']);
                        array_push($editor_itemname, $item1['urun_ad']);
                        array_push($editor_itemprice, $item1['urun_fiyat']);
                        $editor_itempricefull += $item1['urun_fiyat'];
                        array_push($editor_shipcount, $item1['urun_adet']);

                    }
                    array_push($editor_itemprice, $editor_itempricefull);
                    $editor_cargo = $item['kargo_firma'];
                    $editor_ship_nasur = "";
                    foreach ($user->adminGetBillInfo($item['id']) as $item1)
                    {
                        $editor_ship_nasur = $item1['u_name']." ".$item1['u_surname'];
                        $editor_s_adres = $item1['u_adress'];
                    }
                    $editor_itemcat = array();
                    $editor_itemimg = array();

                    $editor_shipnumber = $item['kargo_takip_no'];
                    $editor_process = "Siparişi Güncelle";
                }
            }


        }else
        {
            //Add New İtem
        }
    }else if($url_m == "ad-category")
    {
        $editor_name = "Kategori Ekleme";
    }






    ?>
    <!doctype html>
    <html lang="<?=$language?>">
    <head>
        <meta charset="<?=$charset?>">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> <?=$title?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->
        <link rel="stylesheet" href="css/vendor.css">
        <!-- Theme initialization -->
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
       
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
                case "ad-category":
                    require_once("php/add_category.php");
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
<?php } ?>

