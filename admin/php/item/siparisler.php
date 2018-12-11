<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:55
 */?>
<article class="content items-list-page">
    <div class="title-search-block">
        <div class="title-block">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="title"> Siparişler

                    </h3>

                </div>
            </div>
        </div>
        <div class="items-search">
            <form class="form-inline" action="#" method="get">
                <div class="input-group">
                    <input type="text" class="form-control boxed rounded-s" placeholder="Ara...">
                    <span class="input-group-btn">
                                        <button class="btn btn-secondary rounded-s" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="card items">
        <ul class="item-list striped">
            <li class="item item-list-header">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check" id="select-all-items">
                            <input type="checkbox" class="checkbox">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col item-col-header fixed item-col-img md">
                        <div>
                            <span>Görsel</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-title">
                        <div>
                            <span>Ürün Adı</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-saleid">
                        <div>
                            <span>Sipariş ID</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-sales">
                        <div>
                            <span>Sipariş Adeti</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                            <span>Fiyat</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-category">
                        <div class="no-overflow">
                            <span>Kategori</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-author">
                        <div class="no-overflow">
                            <span>Alıcı</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-shipping">
                        <div class="no-overflow">
                            <span>Kargo Numarası</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-date2">
                        <div class="no-overflow">
                            <span>Tamamlanma Durumu</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-date">
                        <div class="no-overflow">
                            <span>Sipariş Tarihi</span>
                        </div>
                    </div>

                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
              <?php
              $foreach = 0;
                 foreach ($shipping_list_array as $result){
                     if($foreach >= 10)
                         break;
              ?>

            <li class="item">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check" id="select-all-items">
                            <input type="checkbox" class="checkbox">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img md">
                        <?php for($i = 0; $i<count($result[0]); $i++){ ?>
                       <div class="item-img rounded" style="background-image: url(<?=$result[0][$i]?>)"></div>
                        <?php } ?>
                        </div>
                    <div class="item-col fixed pull-left item-col-title">
                        <div>
                            <?php for($i = 0; $i<count($result[1]); $i++){ ?>
                            <a href="<?=$home_link."?m=item-editor&c=".$result[2][$i]?>" class="">

                                <h4 class="item-title"> <?=$result[1][$i]?></h4>

                            </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item-col item-col-saleid">
                        <div> <?=$result[3]?> </div>
                    </div>
                    <div class="item-col item-col-sales">
                        <?php for($i = 0; $i<count($result[4]); $i++){ ?>
                        <div> <?=$result[4][$i]?> </div>
                        <?php } ?>
                    </div>
                    <div class="item-col item-col-category no-overflow">
                        <div class="no-overflow" style="padding-left: 25%">
                            <?=$result[5][count($result[5])-1]." ₺"?>
                        </div>
                    </div>
                    <div class="item-col item-col-category no-overflow">
                        <?php for($i = 0; $i<count($result[6]); $i++){ ?>
                        <div class="no-overflow">
                            <?=$result[6][$i]?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="item-col item-col-author">
                        <div class="no-overflow">
                            <?=$result[7]?>
                        </div>
                    </div>
                    <div class="item-col item-col-shipping">
                        <div class="no-overflow"> <?=$result[8]?></div>
                    </div>
                    <div class="item-col item-col-date2">

                        <div class="no-overflow"> <?php echo ($result[9] < 3)? "Tamamlanmadı":"Tamamlandı";?></div>
                    </div>
                    <div class="item-col item-col-date">
                        <div class="item-heading"></div>
                        <div class="no-overflow"> <?=$result[10]?></div>
                    </div>
                    <div class="item-col fixed item-col-actions-dropdown">
                        <div class="item-actions-dropdown">
                            <a class="item-actions-toggle-btn">
                                                <span class="inactive">
                                                    <i class="fa fa-cog"></i>
                                                </span>
                                <span class="active">
                                                    <i class="fa fa-chevron-circle-right"></i>
                                                </span>
                            </a>
                            <div class="item-actions-block">
                                <ul class="item-actions-list">
                                    <!-- <li>
                                        <a class="remove" href="<?=$home_link."?m=item-editor&c_siparis=".$result[3]?>&e=delete" data-toggle="modal" data-target="#confirm-modal">
                                            <i class="fa fa-trash-o "></i>
                                        </a>
                                    </li>
                                    -->
                                    <li>
                                        <a class="edit" href="<?=$home_link."?m=item-editor&c_siparis=".$result[3]?>">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <?php $foreach++;
                 }  ?>



        </ul>
    </div>
    <nav class="text-right">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href=""> Prev </a>
            </li>
            <li class="page-item active">
                <a class="page-link" href=""> 1 </a>
            </li>
            <li class="page-item">
                <a class="page-link" href=""> 2 </a>
            </li>
            <li class="page-item">
                <a class="page-link" href=""> 3 </a>
            </li>
            <li class="page-item">
                <a class="page-link" href=""> 4 </a>
            </li>
            <li class="page-item">
                <a class="page-link" href=""> 5 </a>
            </li>
            <li class="page-item">
                <a class="page-link" href=""> Next </a>
            </li>
        </ul>
    </nav>
</article>
