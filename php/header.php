<?php
/**
 * Date: 28.11.2018
 * Time: 11:58
 */


function header_focus($m){
    if(isset($_GET["m"])){
        $url_m = $_GET["m"];
        if($url_m == $m) return true;
        else return "home";
    }else{
        return false;
    }
}

if(isset($_GET["search"])){
    $url_m = "magaza";
}

?>
<!-- Header -->
<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">

                <!-- Logo desktop -->
                <a href="<?=$home_url?>" class="logo">
                    <img src="images/icons/logo-01.png" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">

                        <li <?php if(header_focus ("home")==false || !header_focus ("home") == "home" ){
                            ?> class="active-menu" <?php } ?>>
                            <a href="<?=$home_url?>"><?=$header_url[0]?></a>

                        </li>


                        <li <?php if(header_focus ("magaza") === true){
                            ?> class="active-menu" <?php } ?>>
                            <a href="<?=$header_magaza?>"><?=$header_url[1]?></a>
                        </li>

                        <li <?php if(header_focus ("sepetim")=== true){
                            ?> class="active-menu " <?php }?> >
                            <a href="<?=$header_sepetim?>"><?=$header_url[2]?></a>
                        </li>



                        <li <?php if(header_focus ("hakkinda")=== true){
                            ?> class="active-menu" <?php } ?>>
                            <a href="<?=$header_about?>"><?=$header_url[3]?></a>
                        </li>

                        <li <?php if(header_focus ("iletisim")=== true){
                            ?> class="active-menu" <?php } ?>>
                            <a href="<?=$header_contact?>"><?=$header_url[4]?></a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m h-full">
                    <div class="flex-c-m h-full p-r-24">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                            <i class="zmdi zmdi-search" ></i>
                        </div>
                    </div>

                    <div class="flex-c-m h-full p-l-18 p-r-25 bor5" id="sepet_count_div">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" id="sepet_count" data-notify="<?php echo (count($user_shopping_item) > 0) ? count($user_shopping_item) : "0"?>">
                            <i class="zmdi zmdi-shopping-cart"></i>
                        </div>
                    </div>

                    <div class="flex-c-m h-full p-lr-19">
                        <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                            <i class="zmdi zmdi-menu"></i>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="<?=$home_url?>"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
            <div class="flex-c-m h-full p-r-10">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>
            </div>

            <div class="flex-c-m h-full p-lr-10 bor5">
                <div id="sepet_count_mobile" class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="<?php echo (count($user_shopping_item) > 0) ? count($user_shopping_item) : "0"?>">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>
            </div>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            <li>
                <a href="<?=$home_url?>"><?=$header_url[0]?></a>

                <span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
            </li>

            <li>
                <a href="<?=$header_magaza?>"><?=$header_url[1]?></a>
            </li>

            <li>
                <a href="<?=$header_sepetim?>" class="label1 rs1" data-label1="hot"><?=$header_url[2]?></a>
            </li>

            <?php if($islogged){ ?>
            <li>
                <a href="<?=$side_bar_hesabım?>">Hesabım</a>
            </li>
            <li>
                <a href="<?=$side_bar_cikis?>">Çıkış Yap</a>
            </li>
            <?php }else{ ?>
            <li>
                <a href="<?=$side_bar_giris?>">Giriş Yap</a>
            </li>
            <?php } ?>

            <li>
                <a href="<?=$header_about?>"><?=$header_url[3]?></a>
            </li>

            <li>
                <a href="<?=$header_contact?>"><?=$header_url[4]?></a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="Kapat">
            </button>

            <form class="wrap-search-header flex-w p-l-15" method="get" action="<?=$header_magaza?>">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Ara...">
            </form>
        </div>
    </div>
</header>
