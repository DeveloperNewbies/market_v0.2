<?php
/**
 * Created by PhpStorm.
 * User: Mehmet
 * Date: 28.11.2018
 * Time: 15:47
 */

$detail_page_link =$home_link."/index.php?m=magaza&";
$db = new dbMain();
$db->connect();
$user = new user();

   if(isset($_GET["id"])){




       $id = $_GET["id"];
       //Urun Detayları alınıyor
       $id = $db->security($id);

       $urun = $db->getUrun($id);

       $des_detail = "";
        if($urun)
        {
            foreach ($urun as $result)
            {
                $product_title =$result['urun_ad'];

                $product_price =$result['urun_fiyat'];

                $product_description =$result['urun_aciklama'];

                $des_detail = $result['urun_details'];
            }

            //Urun resimleri çekiliyor
            $urun = $db->getUrunImg($id);

            $product_image_link = array();
            foreach ($urun as $result)
            {
                array_push($product_image_link, $result['urun_img']);
            }
            //yorum sayısı
            $related = 0;


            //first option title
            //second option argument array
            $option = array();
            $urun = $db->getCategory($id);
            $cat = "";
            if($urun != false)
            {
                for($i = 0; $i < count($urun); $i++)
                {
                    if($cat != $urun[$i][2])
                    {
                        array_push($option, $urun[$i][2]);
                        $cat = $urun[$i][2];
                    }
                }
                for ($i = 0; $i < count($option); $i++)
                {
                    $option_{$option[$i]} = array();
                }
                for($i = 0; $i < count($option); $i++)
                {
                    for($j = 0; $j < count($urun); $j++)
                    {
                        if($option[$i] == $urun[$j][2])
                        {
                            array_push($option_{$option[$i]}, $urun[$j][3]);
                        }
                    }

                }
            }




            $urun = $db->getUrunInfo($id);
            //urun infos
            $urun_info = array();
            $urun_infocontent = array();

            if($urun != false)
                foreach ($urun as $item)
                {
                    array_push($urun_info, $item['urun_info']);
                    array_push($urun_infocontent, $item['urun_infocont']);

                }
            else
            {
                array_push($urun_info, "");
                array_push($urun_infocontent, "Ürün özelliği belirtilmedi");
            }


        }else
            {
                echo "Ürün Bulunamadı";
                return;
            }

       ?>
       <!-- Product Detail -->
       <section class="sec-product-detail bg0 p-t-65 p-b-60">
           <div class="container">
               <div class="row">
                   <div class="col-md-6 col-lg-7 p-b-30">
                       <div class="p-l-25 p-r-30 p-lr-0-lg">
                           <div class="wrap-slick3 flex-sb flex-w">
                               <div class="wrap-slick3-dots"></div>
                               <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                               <div class="slick3 gallery-lb">

                                   <?php foreach ($product_image_link as $result){ ?>

                                       <div class="item-slick3" data-thumb="<?=$result?>">
                                           <div class="wrap-pic-w pos-relative">
                                               <img src="<?=$result?>" alt="IMG-PRODUCT">

                                               <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="<?=$result?>">
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
                               <?=$product_title?>
                           </h4>

                           <span class="mtext-106 cl2">
							 <?=$product_price?> ₺
						    </span>

                           <p class="stext-102 cl3 p-t-23">
                               <?=$product_description?>
                           </p>

                           <!--  -->
                           <div class="p-t-33">
                               <?php
                               for($i = 0; $i < count($option); $i++){


                                   ?>
                               <div class="flex-w flex-r-m p-b-10">

                                   <div class="size-203 flex-c-m respon6">
                                       <?=$option[$i]?>
                                   </div>

                                   <div class="size-204 respon6-next">

                                       <div class="rs1-select2 bor8 bg0">

                                           <select class="js-select2" name="time">
                                               <?php for($j = 0; $j < count($option_{$option[$i]}); $j++){ ?>
                                               <option><?=$option_{$option[$i]}[$j]?></option>
                                                   <?php
                                               }
                                               ?>
                                           </select>

                                           <div class="dropDownSelect2"></div>

                                       </div>

                                   </div>

                               </div>

                               <?php  } ?>
                               <form action="index.php" method="post">
                               <div class="flex-w flex-r-m p-b-10">

                                   <div class="size-204 flex-w flex-m respon6-next">

                                       <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                           <div class="btn-num-product-down<?=$id?> btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                               <i class="fs-16 zmdi zmdi-minus"></i>
                                           </div>


                                           <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

                                           <div class="btn-num-product-up<?=$id?> btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                               <i class="fs-16 zmdi zmdi-plus"></i>
                                           </div>
                                       </div>
                                       <input type="hidden" id="urun_id" name="urun_id" value="<?=$id?>">
                                       <input class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail " type="submit" name="urun_ekle" value="Sepete Ekle">


                                   </div>

                               </div>
                           </form>
                           </div>

                       </div>
                   </div>
               </div>

               <div class="bor10 m-t-50 p-t-43 p-b-40">
                   <!-- Tab01 -->
                   <div class="tab01">
                       <!-- Nav tabs -->
                       <ul class="nav nav-tabs" role="tablist">
                           <li class="nav-item p-b-10">
                               <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Hakkında</a>
                           </li>

                           <li class="nav-item p-b-10">
                               <a class="nav-link" data-toggle="tab" href="#information" role="tab">Ürün özellikleri</a>
                           </li>

                           <li class="nav-item p-b-10">
                               <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Yorumlar (<?=$related?>)</a>
                           </li>
                       </ul>

                       <!-- Tab panes -->
                       <div class="tab-content p-t-43">
                           <!-- - -->
                           <div class="tab-pane fade show active" id="description" role="tabpanel">
                               <div class="how-pos2 p-lr-15-md">
                                   <p class="stext-102 cl6">
                                       <?=$des_detail?>
                                   </p>
                               </div>
                           </div>

                           <!-- - -->

                           <div class="tab-pane fade" id="information" role="tabpanel" style="padding-left: 18%">
                               <?php
                               for($i = 0; $i < count($urun_info); $i++){

                               ?>
                               <div class="row">

                                   <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">

                                       <ul class="p-lr-28 p-lr-15-sm">

                                           <li class="flex-w flex-t p-b-7">
                                                <span class="stext-102 cl3 size-205">
                                                    <?=$urun_info[$i]?>
                                                </span>

                                               <span class="stext-102 cl6 size-206">
												<?=$urun_infocontent[$i]?>
											    </span>
                                           </li>

                                       </ul>

                                   </div>

                               </div>
                               <?php } ?>
                           </div>

                           <!-- - -->
                           <div class="tab-pane fade" id="reviews" role="tabpanel">
                               <div class="row">
                                   <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                       <div class="p-b-30 m-lr-15-sm">
                                           <!-- Review -->
                                           <div class="flex-w flex-t p-b-68">
                                               <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                   <img src="images/enes.jpg" alt="AVATAR">
                                               </div>

                                               <div class="size-207">
                                                   <div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														Mahmut Turan Cerrah
													</span>

                                                       <span class="fs-18 cl11">
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star"></i>
														<i class="zmdi zmdi-star-half"></i>
													</span>
                                                   </div>

                                                   <p class="stext-102 cl6">
                                                      Ürünü çok beğendim. Tavsiye ederim.
                                                   </p>
                                               </div>
                                           </div>

                                           <!-- Add review -->
                                           <form class="w-full">
                                               <h5 class="mtext-108 cl2 p-b-7">
                                                   Yorum ekleyin
                                               </h5>

                                               <p class="stext-102 cl6">
                                                  Email adresiniz paylaşılmayacaktır.
                                               </p>

                                               <div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Oyla
												</span>

                                                   <span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating">
												</span>
                                               </div>

                                               <div class="row p-b-25">
                                                   <div class="col-12 p-b-5">
                                                       <label class="stext-102 cl3" for="review">Yorumunuz</label>
                                                       <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                   </div>

                                                   <div class="col-sm-6 p-b-5">
                                                       <label class="stext-102 cl3" for="name">İsim</label>
                                                       <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
                                                   </div>

                                                   <div class="col-sm-6 p-b-5">
                                                       <label class="stext-102 cl3" for="email">Email</label>
                                                       <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
                                                   </div>
                                               </div>

                                               <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                   Gönder
                                               </button>
                                           </form>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">

			</span>

               <span class="stext-107 cl6 p-lr-25">

			</span>
           </div>
       </section>




<?php }else{ ?>


<!-- Product -->
<div class="bg0 m-t-23 p-b-140">
    <div class="container">
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                    Tüm Ürünler
                </button>



             <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
                <!-- MEN -->
                </button>





                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".watches">
                    <!-- watches -->
                </button>
            </div>



            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search">
                </div>
            </div>
        </div>


       <?php



       $href_address = "?m=magaza&id=";
       $category = array("*");

       $items = array();
       $items_image = array();
       $urunler;
       if(isset($_GET['search']))
       {
           $user_search = $_GET["search"];
           $user_search = $user->security($user_search);
           if($user->findUrun($user_search))
               $urunler = $user->findUrun($user_search);
            else
                {
                    $urunler = array();
                    echo "Ürün Bulunamadı!";
                }


       }else
           {
               $urunler = $db->getUrun("all");
           }


       foreach ($urunler as $item)
       {
           array_push($items_image, $db->getUrunImg($item['urun_id'])[0][2]);
           array_push($items, $item);
       }


       ?>

        <div class="row isotope-grid">
       <?php
            $i = 0;
            foreach ($items as $item){
       ?>

            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="<?=$items_image[$i]?>" alt="IMG-CONTENT">
                        <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal<?=$item['urun_id']?>">
                            Ürüne Bak
                        </a>
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l ">
                            <a href="<?=$href_address.$item['urun_id']?>" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                               <?=$item['urun_ad']?>
                            </a>
                            <span class="stext-105 cl3">
									<?=$item['urun_fiyat']?> ₺
								</span>
                        </div>
                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

<?php $i++; } $i = 0;
                //////////?>
        </div>

    </div>
</div>


<?php } ?>

