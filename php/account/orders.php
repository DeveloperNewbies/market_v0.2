<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 17:53
 */

?>


<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 17:53
 */


if(count($siparisler)>0)
    $account_order = true;
else
    $account_order = false;

?>

<article class="container responsive-tables-page">
    <?php if($account_order == true){ ?>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="card-title-block">
                                  <h3 class="title"> <?=$m_lang[$lang][75]?> </h3>
                            </div>
                            <section class="example">
                                <div class="table-flip-scroll" style="overflow: scroll;">
                                    <table class="table table-striped table-bordered table-hover flip-content" >
                                        <thead class="flip-header">
                                        <tr>

                                             <th><?=$m_lang[$lang][76]?></th>
                                            <th><?=$m_lang[$lang][77]?></th>
                                            <th><?=$m_lang[$lang][78]?></th>
                                            <th><?=$m_lang[$lang][79]?></th>
                                            <th><?=$m_lang[$lang][80]?></th>
                                            <th><?=$m_lang[$lang][81]?></th>
                                            <th><?=$m_lang[$lang][82]?></th>
                                            <th><?=$m_lang[$lang][83]?></th>
                                            <th><?=$m_lang[$lang][84]?></th>
                                            <th><?=$m_lang[$lang][85]?></th>
                                            <th><?=$m_lang[$lang][86]?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($siparisler as $result){ ?>
                                            <tr class="odd gradeX">

                                                <td><?=$result[1]?></td>
                                                <td>
                                                    <?php for($i = 0; $i<count($result[2]); $i++){ ?>
                                                        <div class="header-cart-item-img">
                                                            <img src="<?=$result[2][$i]?>" alt="<?=$result[4][$i]?>">
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td><?=$result[3]?></td>
                                                <td class="center"><?php for($i = 0; $i<count($result[0]); $i++){ ?><a href="<?=$home_link."/index.php?m=magaza&id=".$result[0][$i]?>"><?php echo (($i+1) == count($result[0])) ? $result[4][$i] : $result[4][$i]." - ";?> </a>  <?php } ?> </td>
                                                <td class="center"><?=$result[5][count($result[5])-1]?> ₺</td>
                                                <td class="center"><?php for($i = 0; $i<count($result[6]); $i++){ echo (($i+1) == count($result[6])) ? $result[6][$i] : $result[6][$i]." - "; } ?></td>
                                                <td class="center"><?=$result[7]?></td>
                                                <td class="center"><?=$result[8]?></td>
                                                <td class="center"><?=$result[9]?></td>
                                                <td><?=$result[10]?></a></td>
                                                <td><?=$result[11]?></td>
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
    <?php }else{?>
          <h2><?=$m_lang[$lang][74]?>.</h2>


    <?php }?>
</article>