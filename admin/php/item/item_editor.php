<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 21:59
 */

$kategoriler = array("1","2","3");

?>
<article class="content item-editor-page">
    <div class="title-block">
        <h3 class="title"> <?=$editor_name?>
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <?php if(isset($_GET['c'])){ ?>
    <form name="item" method="post" action="index.php" enctype = "multipart/form-data">
        <div class="card card-block">
            <input type="hidden" name="item_id" value="<?php echo $_GET['c']; ?>">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> İsim: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_name" placeholder="ürün adı" value="<?=$editor_itemname?>"> </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Açıklama: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed"  name="item_desc" placeholder="ürün açıklaması" value="<?=$editor_itemdesc?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Fiyat: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_price" placeholder="Fiyat" value="<?=$editor_itemprice?>"> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Adet: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_count" placeholder="Adet" value="<?=$editor_itemcount?>"> </div>
            </div>
            <?php if(count($editor_itemcat) > 0){ ?>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Kategori: </label>
                <div class="col-sm-10">

                    <select name="category" class="c-select form-control boxed">
                        <?php for ($raund = 0;$raund < count($editor_itemcat); $raund++){ ?>
                        <option value="<?php echo $raund; ?>" <?php if($editor_defaultopt == ($raund+1)){ ?> selected="selected" <?php } ?>><?php echo $editor_itemcat[$raund];?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <?php for($a=0;$a<count($editor_itemimg);$a++){ ?>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Ürün görseli: </label>
                <div class="col-sm-10" style="max-width: 65%;">
                    <input type="file" class="form-control "  name="item-image-<?php echo $a; ?>">
                </div><div class="" style="width: 60px; height: 60px; position: relative; margin-left: 5%;"> <img src="<?="../".$editor_itemimg[$a]?>" style="width: 60px; height: 60px;" alt="IMG-LOGO"> </div>
            </div>
            <?php }?>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <input type="submit" class="btn btn-primary" name="ch_item" value="<?=$editor_process?>">
                </div>
            </div>
        </div>
    </form>
    <?php }else if(isset($_GET['c_siparis'])){ ?>
    <form name="item" method="post" action="index.php">
        <div class="card card-block">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş ID: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_id" placeholder="Sipariş ID" value="<?=$editor_ship_id?>" readonly> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş Verenin Adı Soyadı: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_nasur" placeholder="Ad Soyad" value="<?=$editor_ship_nasur?>" readonly> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Ürün Adı: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed"  name="ship_itemid" placeholder="ürün açıklaması" value="<?=$editor_itemname?>" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Fiyat: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_itemprice" placeholder="Fiyat" value="<?=$editor_itemprice." ₺"?>" readonly> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş Adeti: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_itemcount" placeholder="Sipariş Adet" value="<?=$editor_shipcount?>" readonly> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş Adresi: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_adress" placeholder="Sipariş Adresi" value="<?=$editor_s_adres?>" readonly> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Kargo Numarası: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="ship_shipnumber" placeholder="Kargo Numarası" value="<?=$editor_shipnumber?>" > </div>
            </div>

            <?php for($a=0;$a<count($editor_itemimg);$a++){ ?>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label text-xs-right"> Ürün görseli: </label>
                    <div class="col-sm-10" style="max-width: 65%;">
                        <div class="" style="width: 60px; height: 60px; position: relative; margin-left: 5%;"> <img src="<?="../".$editor_itemimg[$a]?>" style="width: 60px; height: 60px;" alt="IMG-LOGO"></div>
                    </div>

                </div>
            <?php }?>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş Tamamlandı: </label>
                <input type="checkbox" name="is_ship_ok" value="is_ok" <?php if($editor_shipnumber == "0"){?> disabled <?php } ?>>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Sipariş Iade: </label>
                <input type="checkbox" name="is_ship_reject" value="is_reject" <?php if($editor_shipnumber == "0"){?> disabled <?php } ?>>
            </div>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <input type="submit" class="btn btn-primary" name="ch_ship" value="<?=$editor_process?>">
                </div>
            </div>
        </div>
    </form>
    <?php }else{ ?>
    <form name="item" method="post" action="index.php" enctype = "multipart/form-data">
        <div class="card card-block">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> İsim: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_name" placeholder="Ürün Adı" value="<?=$editor_itemname?>" required> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Açıklama: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed"  name="item_desc" placeholder="Ürün Açıklaması" value="<?=$editor_itemdesc?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Fiyat: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_price" placeholder="Fiyat" value="<?=$editor_itemprice?>" required> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> KDV: </label>
                <div class="col-sm-10">
                    <input type="number" class="form-control boxed" name="item_kdv" placeholder="KDV Oranı" value="<?=$editor_itemkdv?>" required> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Ürün Adet: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_count" placeholder="Ürün Adeti" value="<?=$editor_itemcount?>" required> </div>
            </div>
            <?php if(count($editor_itemcat) > 0){ ?>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label text-xs-right"> Kategori: </label>
                    <div class="col-sm-10">

                        <select name="category" class="c-select form-control boxed" required>
                            <?php for ($raund = 0;$raund < count($editor_itemcat); $raund++){ ?>
                                <option value="<?php echo $raund;?>" ><?php echo $editor_itemcat[$raund];?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <?php for($a=0;$a<count($editor_itemimg);$a++){ ?>
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label text-xs-right"> Ürün görseli: </label>
                    <div class="col-sm-10" style="max-width: 65%;">
                        <input type="file" class="form-control " name="item-image-<?php echo $a; ?>">
                    </div><div class="" style="width: 60px; height: 60px; position: relative; margin-left: 5%;"> <img src="<?="../".$editor_itemimg[$a]?>" style="width: 60px; height: 60px;" alt="IMG-LOGO"> </div>

                </div>
            <?php }?>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <input type="submit" name="add_new_item" class="btn btn-primary" value="<?=$editor_process?>">
                </div>
            </div>
        </div>
    </form>
    <?php } ?>
</article>
