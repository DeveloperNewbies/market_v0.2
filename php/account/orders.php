<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 17:53
 */

?>

<article class="container responsive-tables-page">

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block">
                        <div class="card-title-block">
                            <h3 class="title"> Siparişlerim </h3>
                        </div>
                        <section class="example">
                            <div class="table-flip-scroll">
                                <table class="table table-striped table-bordered table-hover flip-content">
                                    <thead class="flip-header">
                                    <tr>
                                        <th>Bilgiler</th>
                                        <th>Teslimat durumu</th>
                                        <th>Ürün görseli</th>
                                        <th>Sipariş No</th>
                                        <th>Ürün adı</th>
                                        <th>Toplam fiyat</th>
                                        <th>Tarih</th>
                                        <th>Kargo Takibi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($sipraisler as $result){ ?>
                                    <tr class="odd gradeX">
                                        <td><button type="button" class="btn btn-primary btn-sm"><a href="<?=$home_link."/index.php?m=hesabim&account=siparis&sp=".$result[0]?>"> Ürün ayrıntıları</a></button></td>
                                        <td><?=$result[1]?></td>
                                        <td>
                                            <div class="header-cart-item-img">
                                                <img src="<?=$result[2]?>" alt="<?=$result[4]?>">
                                            </div>
                                        </td>
                                        <td><?=$result[3]?></td>
                                        <td class="center"><a href="<?=$home_link."/index.php?m=hesabim&urun=".$result[0]?>"><?=$result[4]?></a></td>
                                        <td class="center"><?=$result[5]?> ₺</td>
                                        <td class="center"><?=$result[6]?></td>
                                        <td><a href="<?=$home_link."/index.php?m=hesabim&urun=".$result[0]?>"> Kargo bilgileri <br> <?=$result[7]?></a></td>
                                    </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
</article>
