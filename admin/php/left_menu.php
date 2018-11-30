<?php
/**
 * Date: 30.11.2018
 * Time: 20:41
 */?>


<aside class="sidebar">
    <div class="sidebar-container">
        <div class="sidebar-header">
            <div class="brand">
                <div class="logo">
                    <span class="l l1"></span>
                    <span class="l l2"></span>
                    <span class="l l3"></span>
                    <span class="l l4"></span>
                    <span class="l l5"></span>
                </div>  Admin </div>
        </div>
        <nav class="menu">
            <ul class="sidebar-menu metismenu" id="sidebar-menu">
                <li class="active">
                    <a href="<?=$home_link?>">
                        <i class="fa fa-home"></i> Yönetim paneli </a>
                </li>
                <li>
                    <a href="">
                        <i class="fa fa-th-large"></i> Ürün Yönetimi
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li>
                            <a href="<?=$home_link."?m=orders";?>"> Siparişler </a>
                        </li>
                        <li>
                            <a href="<?=$home_link."?m=item-list";?>"> Ürün Listesi </a>
                        </li>
                        <li>
                            <a href="<?=$home_link."?m=item-editor";?>"> Ürün Düzenleyici </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="">
                        <i class="fa fa-table"></i> Tables
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li>
                            <a href="static-tables.html"> Static Tables </a>
                        </li>
                        <li>
                            <a href="responsive-tables.html"> Responsive Tables </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="forms.html">
                        <i class="fa fa-pencil-square-o"></i> Forms </a>
                </li>
     <!--
                <li>
                    <a href="">
                        <i class="fa fa-file-text-o"></i> Pages
                        <i class="fa arrow"></i>
                    </a>
                    <ul class="sidebar-nav">
                        <li>
                            <a href="login.html"> Login </a>
                        </li>




                    </ul>
                </li>
 -->


                </li>
            </ul>
        </nav>
    </div>

</aside>
