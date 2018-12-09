<?php
/**
 * Date: 28.11.2018
 * Time: 11:59
 */
?>
<!-- Sidebar -->
<aside class="wrap-sidebar js-sidebar">
    <div class="s-full js-hide-sidebar"></div>

    <div class="sidebar flex-col-l p-t-22 p-b-25">
        <div class="flex-r w-full p-b-30 p-r-27">
            <!-- Logo desktop -->
            <a href="<?=$home_url?>" class="logo" style="margin-right: 40%;margin-top: 10px;">
                <img src="images/icons/logo-01.png" alt="IMG-LOGO" >
            </a>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">

                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
            <ul class="sidebar-link w-full">
                <li class="p-b-13">
                    <a href="<?=$home_url?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[0]?>
                    </a>
                </li>


                <?php if($islogged){ ?>
                <li class="p-b-13">
                    <a href="<?=$side_bar_hesabım?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[1]?>
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="<?=$side_bar_iade?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[2]?>
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="<?=$side_bar_yardim?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[3]?>
                    </a>
                </li>


                <li class="p-b-13">
                    <a href="<?=$side_bar_cikis?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[4]?>
                    </a>
                </li>
                <?php }else{ ?>
                <li class="p-b-13">
                    <a href="<?=$side_bar_iade?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[1]?>
                    </a>
                </li>

                <li class="p-b-13">
                    <a href="<?=$side_bar_yardim?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[2]?>
                    </a>
                </li>
                <li class="p-b-13">
                    <a href="<?=$side_bar_giris?>" class="stext-102 cl2 hov-cl1 trans-04">
                        <?=$side_bar[3]?>
                    </a>
                </li>
                <?php } ?>
            </ul>


            <div class="sidebar-gallery w-full">
					<span class="mtext-101 cl5">
                        <a href="<?=$home_url."/index.php?m=hakkinda"?>"> Hakkında</a>

					</span>

            </div>
        </div>
    </div>
</aside>
