<?php
$point_top = 0;
$s_sepet_top = 0;
$s_sepetfull_top = 0;
$s_sepetfull_üsttop = 0;
$s_sepetfull_vergi = 0;
?>

<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="<?=$home_link."/index.php"?>" class="stext-109 cl8 hov-cl1 trans-04">
            Anasayfa
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
				Sepetim
			</span>
    </div>
</div>




<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85" action="<?=$home_url."/index.php"?>" method="post" id="s_form">
    <div class="container" id="s_form_container">
        <div class="row">
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Ürün</th>
                                <th class="column-2"></th>
                                <th class="column-3">Fiyat</th>
                                <th class="column-4">Adet</th>
                                <th class="column-5">Toplam</th>
                            </tr>
                             <?php  if(count($user_shopping_item) > 0){ foreach ($user_shopping_item as $result){  ?>
                            <tr class="table_row" id="table_row<?=$result[0]?>">
                                <td class="column-1">
                                    <div class="how-itemcart1">
                                        <img src="<?=$result[1]?>" alt="<?=$result[2]?>">
                                    </div>
                                </td>
                                <td class="column-2" id="s_name<?=$result[0]?>"><?=$result[2]?></td>
                                <td class="column-3" id="s_price<?=$result[0]?>"><?=$result[3]?> ₺</td>
                                <td class="column-4">
                                    <div class="wrap-num-product flex-w m-l-auto m-r-0">

                                        <div class="btn-num-product-down<?=$result[0]?> btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" id="s_count<?=$result[0]?>" name="num_item" value="<?=$result[5]?>">

                                        <div class="btn-num-product-up<?=$result[0]?> btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                        <input type="hidden" id="urun_id<?=$result[0]?>" name="urun_id" value="<?=$result[0]?>">
                                    </div>
                                </td>
                                <td class="column-5" id="s_top<?=$result[0]?>"> <?php
                                    echo floatval($result[3])*intval($result[5]);
                                    $point_top += floatval($result[3])*intval($result[5]);
                                    $s_sepetfull_top += (floatval($result[3])/(floatval(1+(intval($result[4])/100))))*($result[5]);
                                    $s_sepet_top += floatval($result[3])*($result[5]);
                                    $s_sepetfull_vergi += round(floatval($result[3])/(1+(intval($result[4])/100)), 2)*($result[4]/100) * $result[5];
                                    ?> ₺  <button onclick="refreshPage()" type="button" class="refreshbutton<?=$result[0]?>"> <i class="fa fa-trash"></i> </button></td>
                            </tr>
                            <?php } }else   echo "sepetiniz boş"; ?>

                        </table>
                    </div>

                    <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m m-r-20 m-tb-5">

                        </div>
                     <?php if(count($user_shopping_item) > 0) : ?>
                        <input type="hidden" class="btn btn-info" name="shopping_card_update" value="Sepeti güncelle">
                            <?php  endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Sepet Toplamı
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13">


                      <table class="size-209">
                        <tr>
                        <td>
                          Ara Toplam
                        </td>
                        <td>

                <span class="mtext-110 cl2" id="s_sepet_top">
                  <?php echo round(floatval($s_sepetfull_top),2); ?> ₺
                </span>

                        </td>
                        </tr>

                        <tr>
                          <td>KDV</td>
                          <td  id="s_sepetfull_vergi">    <?=round($s_sepetfull_vergi,2) ?> ₺   </td>
                        </tr>
                        <tr>
                          <td>KDV DAHİL</td>
                          <td id="s_sepetfullüst_top">   	<?=$s_sepet_top?> ₺ </td>
                        </tr>
                      </table>
                    </div>

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">


                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
								<span class="mtext-101 cl2">
									Toplam:
								</span>
                        </div>

                        <div class="size-209 p-t-1">
								<span class="mtext-112 cl2" id="s_sepetfull_top">
								  	<?=$s_sepet_top?> ₺
								</span>

                        </div>
                    </div>

                    <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        <a href="<?=$home_url."/checkout.php"?>"> Alışverişi Tamamla</a>
                    </button>

                </div>
            </div>
        </div>
    </div>
</form>

<script>
    /*==================================================================
[ +/- num product ]*/
    <?php $i = 0; foreach ($user_shopping_item as $item){  ?>
    $('.btn-num-product-down<?=$item[0]?>').on('click', function(){
        var numProduct = Number($(this).next().val());
        var id = Number($("#urun_id<?=$item[0]?>").val());
        numProduct = numProduct -1;
        if(numProduct >= 0) $(this).next().val(numProduct);
        if(numProduct == 0)
        {
            //$('#s_form').find('#table_row<?=$item[0]?>').empty();
            function refreshPage(){
                location.reload();
            }
            refreshPage()
        }
        $.post("index.php", {"shopping_card_update": "submit", "num_item": numProduct, "urun_id": id}, function (returnData, status) {
            //alert('Status ' + status + ' The server said ' + returnData);
            //$('#form')[0].reset();
            var data_notifier = $('<div>');
            data_notifier.load("index.php?m=sepetim #s_form_container", function () {
                console.log(data_notifier);
                if($(this).children(0).find('#s_count<?=$item[0]?>').val() == 0)
                {
                    $('#s_form').find('#table_row<?=$item[0]?>').empty();
                }else
                {
                    $('#s_form').find('#s_price<?=$item[0]?>').html($(this).children(0).find('#s_price<?=$item[0]?>').html());
                    $('#s_form').find('#s_count<?=$item[0]?>').val($(this).children(0).find('#s_count<?=$item[0]?>').val());
                    $('#s_form').find('#s_top<?=$item[0]?>').html($(this).children(0).find('#s_top<?=$item[0]?>').html());
                    $('#s_form').find('#s_sepet_top').html($(this).children(0).find('#s_sepet_top').html());
                    $('#s_form').find('#s_sepetfull_top').html($(this).children(0).find('#s_sepetfull_top').html());
                    $('#s_form').find('#s_sepetfullüst_top').html($(this).children(0).find('#s_sepetfull_top').html());
                    $('#s_form').find('#s_sepetfull_vergi').html($(this).children(0).find('#s_sepetfull_vergi').html());
                    var data_notifier = $('<div>');
                    data_notifier.load("index.php #sepet_count", function () {
                        $('#sepet_count').attr('data-notify', $(this).children(0).attr('data-notify'));
                        $('#sepet_count_mobile').attr('data-notify', $(this).children(0).attr('data-notify'));
                    });
                }
            });
        });
    });
    $('.btn-num-product-up<?=$item[0]?>').on('click', function(){
        var numProduct = Number($(this).prev().val());
        var id = Number($("#urun_id<?=$item[0]?>").val());
        numProduct +=1;
        $(this).prev().val(numProduct);
        $.post("index.php", {"shopping_card_update": "submit", "num_item": numProduct, "urun_id": id}, function (returnData, status) {
            //alert('Status ' + status + ' The server said ' + returnData);
            //$('#form')[0].reset();
            var data_notifier = $('<div>');
            data_notifier.load("index.php?m=sepetim #s_form_container", function () {
                console.log(data_notifier);
                if($(this).children(0).find('#s_count<?=$item[0]?>').val() == 0)
                {
                    $('#s_form').find('#s_count<?=$item[0]?>').detach();
                }else
                    {
                        $('#s_form').find('#s_price<?=$item[0]?>').html($(this).children(0).find('#s_price<?=$item[0]?>').html());
                        $('#s_form').find('#s_count<?=$item[0]?>').val($(this).children(0).find('#s_count<?=$item[0]?>').val());
                        $('#s_form').find('#s_top<?=$item[0]?>').html($(this).children(0).find('#s_top<?=$item[0]?>').html());
                        $('#s_form').find('#s_sepet_top').html($(this).children(0).find('#s_sepet_top').html());
                        $('#s_form').find('#s_sepetfull_top').html($(this).children(0).find('#s_sepetfull_top').html());
                        $('#s_form').find('#s_sepetfullüst_top').html($(this).children(0).find('#s_sepetfull_top').html());
                        $('#s_form').find('#s_sepetfull_vergi').html($(this).children(0).find('#s_sepetfull_vergi').html());
                    }
            });
        });
    });

    $('.refreshbutton<?=$item[0]?>').on('click', function(){
        var id = Number($("#urun_id<?=$item[0]?>").val());
        $.post("index.php", {"shopping_card_update": "submit", "num_item": 0, "urun_id": id}, function (returnData, status) {

            function refreshPage(){
                location.reload();
            }
            refreshPage()
        });
    })
    <?php $i++; } $i=0; ?>
</script>
