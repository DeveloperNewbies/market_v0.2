<?php
/**
 * Date: 28.11.2018
 * Time: 12:05
 */

$db = new dbMain();
$db->connect();

$href_address = "?m=magaza&id=";
$category = array("best-seller");

$items = array();
$items_image = array();

$urunler = $db->getUrun("all");

foreach ($urunler as $item)
{
    array_push($items_image, $db->getUrunImg($item['urun_id'])[0][2]);
    array_push($items, $item);
}




?>


<!-- Product -->
<section class="sec-product bg0 p-t-100 p-b-50">
    <div class="container">
        <div class="p-b-32">
            <h3 class="ltext-105 cl5 txt-center respon1">
                Ürünlerimiz
            </h3>
        </div>

        <!-- Tab01 -->
        <div class="tab01">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item p-b-10">
                    En çok satılan ürünlerimiz
                </li>

            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-t-50">
                <!-- - -->
                <div class="tab-pane fade show active" id="<?=$category[0]?>" role="tabpanel">
                    <!-- Slide2 -->
                    <div class="wrap-slick2">
                        <div class="slick2">
                            <?php $i = 0; ?>
                            <?php foreach ($items as $item){ ?>
                            <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                <!-- Block2 -->

                                <div class="block2">
                                    <div class="block2-pic hov-img0">
                                        <img src="<?=$items_image[$i]?>" alt="IMG-PRODUCT">

                                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal<?=$item['urun_id']?>">
                                            Ürüne bak
                                        </a>
                                    </div>

                                    <div class="block2-txt flex-w flex-t p-t-14">
                                        <div class="block2-txt-child1 flex-col-l ">
                                            <a href="<?=$href_address.$item['urun_id']?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                <?=$item['urun_ad']?>
                                            </a>

                                            <span class="stext-105 cl3">
													<?= $item['urun_fiyat'] ?> ₺
												</span>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <?php $i++; } $i = 0;?>

                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>


</section>


