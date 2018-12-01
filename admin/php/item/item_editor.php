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
        <h3 class="title"> Yeni Ürün Ekle
            <span class="sparkline bar" data-type="bar"></span>
        </h3>
    </div>
    <form name="item" method="<?=$item_memthod_name?>" action="">
        <div class="card card-block">
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> İsim: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_name" placeholder="ürün adı"> </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Açıklama: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed"  name="description" placeholder="ürün açıklaması"> </div>
                <!-- <div class="col-sm-10">
                    <div class="wyswyg">
                        <div class="toolbar">
                            <select class="ql-size">
                                <option value="small"></option>
                                <option selected></option>
                                <option value="large"></option>
                                <option value="huge"></option>
                            </select>
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-strike"></button>
                            <select title="Text Color" class="ql-color">
                                <option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)" selected></option>
                                <option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
                                <option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
                                <option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
                                <option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
                                <option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
                                <option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
                                <option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)"></option>
                                <option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
                                <option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
                                <option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
                                <option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
                                <option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
                                <option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
                                <option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
                                <option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
                                <option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
                                <option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
                                <option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
                                <option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
                                <option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
                                <option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
                                <option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
                                <option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
                                <option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
                                <option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
                                <option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
                                <option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
                                <option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
                                <option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
                                <option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
                                <option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
                                <option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
                                <option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
                                <option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
                            </select>
                            <select title="Background Color" class="ql-background">
                                <option value="rgb(0, 0, 0)" label="rgb(0, 0, 0)"></option>
                                <option value="rgb(230, 0, 0)" label="rgb(230, 0, 0)"></option>
                                <option value="rgb(255, 153, 0)" label="rgb(255, 153, 0)"></option>
                                <option value="rgb(255, 255, 0)" label="rgb(255, 255, 0)"></option>
                                <option value="rgb(0, 138, 0)" label="rgb(0, 138, 0)"></option>
                                <option value="rgb(0, 102, 204)" label="rgb(0, 102, 204)"></option>
                                <option value="rgb(153, 51, 255)" label="rgb(153, 51, 255)"></option>
                                <option value="rgb(255, 255, 255)" label="rgb(255, 255, 255)" selected></option>
                                <option value="rgb(250, 204, 204)" label="rgb(250, 204, 204)"></option>
                                <option value="rgb(255, 235, 204)" label="rgb(255, 235, 204)"></option>
                                <option value="rgb(255, 255, 204)" label="rgb(255, 255, 204)"></option>
                                <option value="rgb(204, 232, 204)" label="rgb(204, 232, 204)"></option>
                                <option value="rgb(204, 224, 245)" label="rgb(204, 224, 245)"></option>
                                <option value="rgb(235, 214, 255)" label="rgb(235, 214, 255)"></option>
                                <option value="rgb(187, 187, 187)" label="rgb(187, 187, 187)"></option>
                                <option value="rgb(240, 102, 102)" label="rgb(240, 102, 102)"></option>
                                <option value="rgb(255, 194, 102)" label="rgb(255, 194, 102)"></option>
                                <option value="rgb(255, 255, 102)" label="rgb(255, 255, 102)"></option>
                                <option value="rgb(102, 185, 102)" label="rgb(102, 185, 102)"></option>
                                <option value="rgb(102, 163, 224)" label="rgb(102, 163, 224)"></option>
                                <option value="rgb(194, 133, 255)" label="rgb(194, 133, 255)"></option>
                                <option value="rgb(136, 136, 136)" label="rgb(136, 136, 136)"></option>
                                <option value="rgb(161, 0, 0)" label="rgb(161, 0, 0)"></option>
                                <option value="rgb(178, 107, 0)" label="rgb(178, 107, 0)"></option>
                                <option value="rgb(178, 178, 0)" label="rgb(178, 178, 0)"></option>
                                <option value="rgb(0, 97, 0)" label="rgb(0, 97, 0)"></option>
                                <option value="rgb(0, 71, 178)" label="rgb(0, 71, 178)"></option>
                                <option value="rgb(107, 36, 178)" label="rgb(107, 36, 178)"></option>
                                <option value="rgb(68, 68, 68)" label="rgb(68, 68, 68)"></option>
                                <option value="rgb(92, 0, 0)" label="rgb(92, 0, 0)"></option>
                                <option value="rgb(102, 61, 0)" label="rgb(102, 61, 0)"></option>
                                <option value="rgb(102, 102, 0)" label="rgb(102, 102, 0)"></option>
                                <option value="rgb(0, 55, 0)" label="rgb(0, 55, 0)"></option>
                                <option value="rgb(0, 41, 102)" label="rgb(0, 41, 102)"></option>
                                <option value="rgb(61, 20, 102)" label="rgb(61, 20, 102)"></option>
                            </select>
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                            <select title="Text Alignment" class="ql-align">
                                <option selected></option>
                                <option value="center" label="Center"></option>
                                <option value="right" label="Right"></option>
                                <option value="justify" label="Justify"></option>
                            </select>
                            <button class="ql-link"></button>
                            <button style="width: auto;" type="button" title="Image" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-media">
                                <i class="fa fa-image"></i>  </button>
                        </div>
                        <div class="editor">  </div>
                    </div>
                </div>-->
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Fiyat: </label>
                <div class="col-sm-10">
                    <input type="text" class="form-control boxed" name="item_fiyat" placeholder="Fiyat"> </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Kategori: </label>
                <div class="col-sm-10">
                    <select name="category" class="c-select form-control boxed">
                        <?php for ($raund = 0;$raund < count($kategoriler); $raund++){ ?>
                        <option value="<?=$kategoriler[$raund]?>"><?=$kategoriler[$raund]?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <?php for($a=0;$a<3;$a++){ ?>
            <div class="form-group row">
                <label class="col-sm-2 form-control-label text-xs-right"> Ürün görseli: </label>
                <div class="col-sm-10">
                    <input type="file" class="form-control "  name="item-image-<?php $a ?>"> </div>
            </div>
            <?php }?>
            <div class="form-group row">
                <div class="col-sm-10 col-sm-offset-2">
                    <button type="submit" class="btn btn-primary"> Ekle </button>
                </div>
            </div>
        </div>
    </form>
</article>
