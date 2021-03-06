<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 28.11.2018
 * Time: 12:07
 */

$db = new dbMain();
$db->connect();

//ürünler
$modal_item = array();
//default 3 value
$popup_img_link = array();

//ürün title
$product_title = array();
// ürün fiyatı
$product_price = array();
//ürün açıklama
$product_description = array();

$modal_item = $db->getUrun("all");
$i = 0;
foreach ($modal_item as $item) {

    array_push($popup_img_link, array());
    if($db->getUrunImg($item['urun_id']))
    {
        foreach ($db->getUrunImg($item['urun_id']) as $item2) {
            array_push($popup_img_link[$i], $item2['urun_img']);
        }
    }else
        {

        }

    $product_title[$i] = $item['urun_ad'];
    $product_price[$i] = $item['urun_fiyat'] . " ₺";
    $product_description[$i] = $item['urun_aciklama'];
    $i++;
}
$i = 0;

?>
<!-- Modall -->
    <?php $i = 0; foreach ($modal_item as $item){ ?>
<section>
<div class="wrap-modal1 js-modal p-t-60 p-b-20" id="<?=$item['urun_id']?>">
    <div onclick="takeID(<?=$item['urun_id']?>);" class="overlay-modal1 js-hide-modal"></div>

    <div class="container">
        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
            <button class="how-pos3 hov3 trans-04 js-hide-modal" onclick="takeID(<?=$item['urun_id']?>)">
				<p style="color:white;font-size:20px"><?=$m_lang[$lang][31]?> </p>
            </button>

            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                <?php for($j = 0; $j < count($popup_img_link[$i]); $j++){ ?>
                                <div class="item-slick3" data-thumb="<?=$popup_img_link[$i][$j]?>">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="<?=$popup_img_link[$i][$j]?>" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?=$popup_img_link[$i][$j]?>">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                           <?=$product_title[$i]?>
                        </h4>

                        <span class="mtext-106 cl2">
								<?=$product_price[$i]?>
							</span>

                        <p class="stext-102 cl3 p-t-23">
                            <?=$product_description[$i]?>

                        </p>

                        <!--  -->
                        <div class="p-t-33">
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m" onclick="minusProduct(<?=$item['urun_id']?>);">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" id="num-product<?=$item['urun_id']?>" type="number" name="num-product" value="1">

                                        <div class="btn-num-product-up btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m" onclick="addProduct(<?=$item['urun_id']?>)">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" id="urun_id<?=$item['urun_id']?>" name="urun_id" value="<?=$item['urun_id']?>">
                                    
                                      <button  style="margin-bottom: 20px;" onclick="addToBasket(<?=$item['urun_id']?>);" class="btn-num-product-submit flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                         <?=$m_lang[$lang][32]?>
                                      </button>
                                      <button onclick="addToBasket(<?=$item['urun_id']?>)" class="btn-num-product-submit flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 " >
                                         <a href="<?= $home_url."/index.php?m=sepetim" ?>" style="color:white;"> <?=$m_lang[$lang][33]?></a>
                                      </button>

                                </div>
                            </div>
                        </div>

                        <!--
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                            <div class="flex-m bor9 p-r-10 m-r-11">
                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>
                            </div>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>

                            <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>


<?php $i++; } $i=0; ?>



<script>
    function takeID(id)
    {
        var x = document.getElementById(id);
        if ($('.show-modal1').length > 0) {
            //do something
            x.classList.remove('show-modal1');
        }else
            {
                x.classList.add('show-modal1');
            }
    }

</script>

<script>
    /*==================================================================
[ +/- num product ]*/


    function minusProduct(id)
    {
        var numProduct = parseInt(document.getElementById("num-product"+id).value);

        numProduct = numProduct - 1;

        if(numProduct > 0) document.getElementById("num-product"+id).value = parseInt(numProduct);
    }

    function addProduct(id)
    {
        var numProduct = parseInt(document.getElementById("num-product"+id).value);

        numProduct += 1;

        document.getElementById("num-product"+id).value = parseInt(numProduct);
    }

    function addToBasket(id)
    {
        var numProduct = Number($("#num-product"+id).val());

        $.post("index.php", {"urun_ekle": "submit", "num-product": numProduct, "urun_id": id}, function (returnData, status) {
            //alert('Status ' + status + ' The server said ' + returnData);
            //$('#form')[0].reset();
            $('#sepetim').load("index.php #sepetim", function() {

            });
            var data_notifier = $('<div>');
            data_notifier.load("index.php #sepet_count", function () {
                $('#sepet_count').attr('data-notify', $(this).children(0).attr('data-notify'));
                $('#sepet_count_mobile').attr('data-notify', $(this).children(0).attr('data-notify'));
            });

        });

    }
</script>
