<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 30.11.2018
 * Time: 20:49
 */

?>
<article class="content dashboard-page">
    <section class="section">
        <div class="row sameheight-container">
            <div class="col-xl-12">
                <div class="card sameheight-item stats" data-exclude="xs">
                    <div class="card-block">
                        <div class="title-block">
                            <h4 class="title"> Veriler </h4>
                            <p class="title-description"> Website istatistik

                            </p>
                        </div>
                        <div class="row row-sm stats-container">
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-rocket"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$active_items?> </div>
                                    <div class="name"> Aktif satılan ürün sayısı </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 75%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$items_sold?> </div>
                                    <div class="name"> Toplam satılan ürün sayısı </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 25%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-line-chart"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$monthly_income?> ₺ </div>
                                    <div class="name"> Aylık gelir </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 60%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$total_users?> </div>
                                    <div class="name"> Toplam kullanıcı sayısı </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 34%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-list-alt"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$tickets_closed?> </div>
                                    <div class="name"> Müşteri bildirimleri </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 50%;"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 stat-col">
                                <div class="stat-icon">
                                    <i class="fa fa-dollar"></i>
                                </div>
                                <div class="stat">
                                    <div class="value"> <?=$total_income?> </div>
                                    <div class="name"> Toplam gelir </div>
                                </div>
                                <div class="progress stat-progress">
                                    <div class="progress-bar" style="width: 15%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php  require_once ("metric/item.php"); ?>

</article>

<footer class="footer">


</footer>
