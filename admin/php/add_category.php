<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:59
 */

$category_item = array(
        0=>array("harnup özü",1),
        1=>array("krem",2),
);
?>
<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title"> <?=$editor_name?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" method="post" action="index.php" enctype = "multipart/form-data">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Kategori Ekle: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed"  name="ad_category" placeholder="Kategori Ekle">
                </div>
            </div>
		<input type="hidden" name="admin_category" value="add">
		<input type="submit" class="btn btn-primary" value="Ekle">
    </form>

    <div class="container" style="margin-top: 3%; ">
        <div class="row h2"> Kategoriler </div>

        <?php   foreach ($category_item as $result){ ?>
            <div class="col-12 col-sm-6 col-lg-8 " >
                <a href="#">
                <button type="button" class="btn btn-warning">Kaldır</button>
                </a>
                <?=$result[0] ?>

            </div>
      <?php }?>
    </div>
</article>