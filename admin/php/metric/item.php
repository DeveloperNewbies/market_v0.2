<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:06
 */?>


 <section class="section">
    <div class="row sameheight-container">
        <div class="col-xl-12">
            <div class="card sameheight-item items" data-exclude="xs,sm,lg">
                <div class="card-header bordered">
                    <div class="header-block">
                        <h3 class="title"> Ürünler </h3>
                        <a href="<?=$home_link."?m=item-editor";?>" class="btn btn-primary btn-sm"> Yeni ürün ekle </a>
                    </div>
                    <div class="header-block pull-right">
                        <label class="search">
                            <input class="search-input" placeholder="ara ...">
                            <i class="fa fa-search search-icon"></i>
                        </label>
                        <div class="pagination">
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-up"></i>
                            </a>
                            <a href="" class="btn btn-primary btn-sm">
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <ul class="item-list striped">
                    <li class="item item-list-header">
                        <div class="item-row">
                            <div class="item-col item-col-header fixed item-col-img xs"></div>
                            <div class="item-col item-col-header item-col-title">
                                <div>
                                    <span>Ürün</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-sales">
                                <div>
                                    <span>Satılan adet sayısı</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-stats">
                                <div class="no-overflow">
                                    <span>Fiyat</span>
                                </div>
                            </div>
                            <div class="item-col item-col-header item-col-date">
                                <div>
                                    <span>Eklenme Tarihi</span>
                                </div>
                            </div>
                        </div>
                    </li>

                           <?php  if(!isset($list_item_list)){
                                 ?>

                               <li class="item">
                                   <div class="item-row">
                                       <!-- <div class="item-col fixed item-col-img xs">
                                           <a href="">
                                               <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg)"></div>
                                           </a>
                                       </div> -->
                                       <div class="item-col item-col-title no-overflow">
                                           <div>
                                               <a href="" class="">
                                                   <h4 class="item-title no-wrap">  </h4>
                                               </a>
                                           </div>
                                       </div>
                                       <div class="item-col item-col-sales">
                                           <div class="item-heading"></div>
                                           <div>  </div>
                                       </div>
                                       <div class="item-col item-col-stats">
                                           <div class="item-heading"></div>
                                           <div class="no-overflow">
                                               <div class="item-stats sparkline" data-type="bar"></div>
                                           </div>
                                       </div>
                                       <div class="item-col item-col-date">
                                           <div class="item-heading"></div>
                                           <div></div>
                                       </div>
                                   </div>
                               </li>



                           <?php    }else{
                               $item_sayac =0;
                               foreach ($list_item_list as $result){
                                   if($item_sayac >= 10) break;
                                   ?>
                                   <li class="item">
                                       <div class="item-row">
                                           <!-- <div class="item-col fixed item-col-img xs">
                                               <a href="">
                                                   <div class="item-img xs rounded" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/brad_frost/128.jpg)"></div>
                                               </a>
                                           </div> -->
                                           <div class="item-col item-col-title no-overflow">
                                               <div>
                                                   <a href="<?="http://localhost/index.php?m=magaza&id=".$result[0]?>" class="">
                                                       <h4 class="item-title no-wrap"> <?=$result[1]?> </h4>
                                                   </a>
                                               </div>
                                           </div>
                                           <div class="item-col item-col-header fixed item-col-img xs"></div>
                                           <div class="item-col item-col-header item-col-sales">
                                               <div>
                                                   <span><?=$result[2]?></span>
                                               </div>
                                           </div>

                                           <div class="item-col item-col-sales">
                                               <div> <?=$result[3]?> </div>
                                           </div>
                                           <div class="item-col item-col-date">
                                               <div> <?=$result[4]?> </div>
                                           </div>
                                       </div>
                                   </li>

                      <?php   $item_sayac++; }
                             } ?>


                </ul>
            </div>
        </div>

    </div>
</section>
