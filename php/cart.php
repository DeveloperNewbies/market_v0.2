<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 28.11.2018
 * Time: 12:02
 */
 $sepet_item_toplam = 0;
 $sepet_item_kdv = 0;
?>

<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					 <a href="<?=$home_link."/index.php?m=sepetim"?>"><?=$m_lang[$lang][2]?></a>
				</span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll" id="sepetim">
            <ul class="header-cart-wrapitem w-full">
                <?php if(count($user_shopping_item) < 1){   ?>
                    <h2><?=$m_lang[$lang][26]?></h2>
                    <button style="margin-top:30px;" class="flex-c-m stext-101 cl0 size-115 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                       <a href="<?=$home_url."/index.php?m=magaza"?>"><?=$m_lang[$lang][1]?></a>
                   </button>

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
                          <?=$result[3]?>₺ x <?=$result[5]?>
                                      <?php  $sepet_item_toplam +=($result[3]*$result[5]);?>
							</span>
                    </div>
                    <div class="p-0"></div>
                    <form action="index.php" method="post">
                        <input type="hidden" name="urun_id" value="<?=$result[0]?>">
                        <input type="submit" class="btn btn-info" name="urun_cikar" value="<?=$m_lang[$lang][91]?>">
                    </form>
                </li>

                      <?php
                        $sepet_item_kdv += round((($result[3]*$result[5])/(1+($result[4]/100)))*($result[4]/100), 2);
                } ?>
                      <div class="flex-w flex-t p-t-27 p-b-33">
                          <div class="size-208">
                  <span class="mtext-101 cl2">
                    <?=$m_lang[$lang][27]?>:
                  </span>
                          </div>

                          <div class="size-209 p-t-1">
                  <span class="mtext-112 cl2" id="s_sepetfull_top">
                     <?= $sepet_item_toplam ?> ₺
                  </span>
                               <span class="mtext-100 cl2" id="s_sepetfull_vergi"> <br> (KDV <?= $sepet_item_kdv ?>  ₺ )</span>
                          </div>
                      </div>
                <form action="index.php" method="post">
					
                    <input  type="submit" name="completeshopping" value="<?=$m_lang[$lang][90]?>" class="flex-c-m stext-101 cl0 size-115 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
					
                </form>
                <?php } ?>
        </div>
    </div>
</div>
