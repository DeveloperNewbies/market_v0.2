<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 28.11.2018
 * Time: 12:02
 */
?>
<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					 <a href="<?=$home_link."/index.php?m=sepetim"?>">Sepetim</a>
				</span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                <?php if(!isset($user_shopping_item)){   ?>
                    Sepetiniz boş
                <?php }else{ ?>
                <?php foreach ($user_shopping_item as $result){   ?>
                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="<?=$result[1]?>" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
                        <a href="<?=$header_magaza."&id=".$result[0]?>" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                            <?=$result[2]?>
                        </a>

                        <span class="header-cart-item-info">
								<?=$result[3]?> x <?=$result[4]?> ₺
							</span>
                    </div>
                    <div class="p-0"></div>
                    <form action="index.php" method="post">
                        <input type="hidden" name="urun_id" value="<?=$result[0]?>">
                        <input type="submit" class="btn btn-info" name="urun_cikar" value="Ürünü Çıkar">
                    </form>
                </li>

                      <?php } } ?>
        </div>
    </div>
</div>
