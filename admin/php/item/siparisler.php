<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:55
 */?>
<style>

.ml-1 {
  margin-left: ($spacer * .25) !important;
}
</style>


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
        <div class="row">
        
        
        
        <form action="index.php?m=orders&l=ok&p=1" method="post">
            From: <input type="date" min="<?=$orders_min_date->format("Y-m-d")?>" max="<?=date("Y-m-d")?>" name="from" value="<?=$orders_min_default?>" required>
            To: <input type="date" min="<?=$orders_min_date->format("Y-m-d")?>" max="<?=date("Y-m-d")?>"  name="to" value="<?=$orders_max_default?>" required>
            <input class="btn btn-info ml-1" type="submit" name="especially" value="Ara">
        </form>

        <?php if(isset($result1)){ if($result1){ ?>
            <form action="php/wex.php" method="post" target="_blank">
                <input  type="hidden" name="mb_content" value="<?=base64_encode(serialize($mb_wex))?>">
                <input  class="btn btn-primary ml-1" type="submit" name="mb" value="Müşteri Bilgilerini Ara">
            </form>
        <?php } } ?>
            <?php if(isset($result1)){ if($result1){ ?>
                <form action="php/jex.php" method="post" target="_blank">
                    <input  type="hidden" name="mb_content" value="<?=base64_encode(serialize($mb_wex))?>">
                    <input  class="btn btn-primary ml-1" type="submit" name="mb" value="Müşteri Bilgilerini Ara(Excel)">
                </form>
            <?php } } ?>

            <?php if(isset($result1)){ if($result1){ ?>
                <form action="php/wex.php" method="post" target="_blank">
                    <input type="hidden" name="ksl_content" value="<?=base64_encode(serialize($ksl_wex))?>">
                    <input class="btn btn-danger ml-1"  type="submit" name="ksl" value="Kesin Sipariş Listesi Oluştur">
                </form>
            <?php } } ?>
            <?php if(isset($result1)){ if($result1){ ?>
                <form action="php/jex.php" method="post" target="_blank">
                    <input type="hidden" name="ksl_content" value="<?=base64_encode(serialize($ksl_wex))?>">
                    <input class="btn btn-danger ml-1"  type="submit" name="ksl" value="Kesin Sipariş Listesi Oluştur(Excel)">
                </form>
            <?php } } ?>

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
                      <div class="item-col item-col-header fixed item-col-img xs"></div>
                      <div class="item-col item-col-header item-col-title">
                        <div>
                          <span>Ürün Adı</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span> ID</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span> Adeti</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span>Fiyat</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span>Kategori</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span>Alıcı</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span>Kargo Numarası</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-stats">
                        <div class="no-overflow">
                          <span>Tamamlanma Durumu</span>
                        </div>
                      </div>
                      <div class="item-col item-col-header item-col-date">
                        <div>
                          <span>Sipariş Tarihi</span>
                        </div>
                      </div>

                    <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
                </div>
            </li>
              <?php
              $foreach = 0;
                 foreach ($shipping_list_array as $result){
                     
              ?>

            <li class="item">
                <div class="item-row">
                    <div class="item-col fixed item-col-check">
                        <label class="item-check" id="select-all-items">
                            <input type="checkbox" class="checkbox">
                            <span></span>
                        </label>
                    </div>
                    <div class="item-col fixed item-col-img xs">
                  <?php for($i = 0; $i<count($result[0]); $i++){ ?>
                        <div class="item-img xs rounded" style="background-image: url(<?=$result[0][$i]?>)"></div>
                        <?php } ?>
                    </div>
                    <div class="item-col item-col-title no-overflow">
                      <div>
                        <?php for($i = 0; $i<count($result[1]); $i++){ ?>
                            <a href="<?=$realip."/?m=magaza&id=".$result[2][$i]?>" class="" target="_blank">

                            <h4 class="item-title"> <?=$result[1][$i]?></h4>

                        </a>
                        <?php } ?>
                      </div>
                    </div>


                    <div class="item-col item-col-sales">
                      <div class="item-heading">Sipariş ID</div>
                      <div><?=$result[3]?>  </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Sipariş Adeti</div>
                      <div> <?php for($i = 0; $i<count($result[4]); $i++){ ?>
                      <div> <?=$result[4][$i]?> </div>
                      <?php } ?> </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Fiyat</div>
                      <div> <?=$result[5][count($result[5])-1]." ₺"?> </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Kategori</div>
                      <div>   <?php for($i = 0; $i<count($result[6]); $i++){ ?>
                        <div class="no-overflow">
                            <?=$result[6][$i]?>
                        </div>
                        <?php } ?> </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Alıcı</div>
                      <div>   <?=$result[7]?> </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Kargo Numarası</div>
                      <div> <?=$result[8]?> </div>
                    </div>

                    <div class="item-col item-col-sales">
                      <div class="item-heading">Tamamlanma Durumu</div>
                      <div> <?php echo ($result[9] < 3)? "Tamamlanmadı":"Tamamlandı";?> </div>
                    </div>

                    <div class="item-col item-col-date">
                      <div class="item-heading">Published</div>
                      <div> <?=$result[10]?> </div>
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
                <a class="page-link" href="index.php?m=orders&prev=ok<?=isset($is_listing) ? "&l=ok":""?>&p=<?=((($page_counter) > 0 ? $page_counter-1 : $page_counter) * $sayfa_adet)+1?>"> Prev </a>
            </li>
            <?php
                for($i = ($page_counter * $sayfa_adet); $i < ((($page_count - (($page_counter+1) * $orders_full_item)) >= $sayfa_adet) ? ($page_counter+1)*$sayfa_adet : $page_count); $i++)
                {
                ?>
                    <li class="page-item <?php if($i == ($page_num - 1)){ ?>active<?php } ?>">
                        <a class="page-link" href="index.php?m=orders<?=isset($is_listing) ? "&l=ok":""?>&p=<?=$i+1?>"> <?=$i+1?> </a>
                    </li>
            <?php
                }
                ?>
            <li class="page-item">
                <a class="page-link" href="index.php?m=orders&next=ok<?=isset($is_listing) ? "&l=ok":""?>&p=<?=(($page_counter+1 * $sayfa_adet < $page_count ? $page_counter + 1 : $page_counter) * $sayfa_adet)+1?>"> Next </a>
            </li>
        </ul>
    </nav>

</article>
