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
                    <h3 class="title"> Ürünler
                        <a href="<?=$home_link."?m=item-editor"?>" class="btn btn-primary btn-sm rounded-s">  Ekle </a>
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
                            <span>İsim</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-sales">
                        <div>
                            <span>Satıştaki Adet</span>
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
                            <span>Ürün ID</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header item-col-date">
                        <div>
                            <span>Satış Tarihi</span>
                        </div>
                    </div>
                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
            <?php
            $foreach = 0;
            foreach ($item_list_array as $result){
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
                            <div class="item-img rounded" style="background-image: url(<?=$result[0]?>)"></div>
                        </div>
                        <div class="item-col fixed pull-left item-col-title">
                            <div>
                                <a href="<?=$home_link."?m=item-editor&c=".$result[5]?>" class="">
                                    <h4 class="item-title"> <?=$result[1]?></h4>
                                </a>
                            </div>
                        </div>
                        <div class="item-col item-col-sales">
                            <div> <?=$result[2]?> </div>
                        </div>
                        <div class="item-col item-col-stats no-overflow">
                            <div class="no-overflow">
                                <?=$result[3]." ₺"?>
                            </div>
                        </div>
                        <div class="item-col item-col-category no-overflow">
                            <div class="no-overflow">
                                <?=$result[4]?>
                            </div>
                        </div>
                        <div class="item-col item-col-author">
                            <div class="no-overflow">
                                <?=$result[5]?>
                            </div>
                        </div>
                        <div class="item-col item-col-date">
                            <div class="item-heading"></div>
                            <div class="no-overflow"> <?=$result[6]?></div>
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
                                        <li>
                                            <a class="remove" href="<?=$home_link."?m=item-editor&e=delete&c=".$result[5]?>" data-toggle="modal" data-target="#confirm-modal">
                                                <i class="fa fa-trash-o "></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="edit" href="<?=$home_link."?m=item-editor&c=".$result[5]?>">
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
