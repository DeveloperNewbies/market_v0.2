<?php
/**
 * Date: 2.12.2018
 * Time: 21:02
 */


    $user_about = array(
    "Enes Budak",
    "mehmet_tuna_anadolu@hotmail.com ",
    "Adres ",
    "adres 2"
);

//Teslimat durumu
//Ürün görseli
//Sipariş No
//Ürün adı
//Ürün açıklaması
//Toplam fiyat
//Tarih
$sipraisler = array(
    0=>array("1","Teslim edilmedi","/images/harnup/harnupozu250ml.png","12345","Harnup özü","234","23 Ocak 2018","213523","teslim ed adres"),
    1=>array("1","Teslim edilmedi","/images/harnup/harnupozu250ml.png","12345","Harnup özü","234","23 Ocak 2018","216723"),
    2=>array("3","Teslim edilmedi","/images/harnup/harnupozu250ml.png","12345","Harnup özü","234","23 Ocak 2018","217923"),
);

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

