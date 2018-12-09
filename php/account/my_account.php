<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 19:05
 */

    $re_pas = (isset($_GET["reload"])) ? $_GET["reload"] : "home";

switch ($re_pas){
    case "home":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active">
                Ad soyad: <?=$user_about[0]?>
            </div>
            <div  class="list-group-item list-group-item-action"> E-mail: <?=$user_about[1]?></div>
            <div  class="list-group-item list-group-item-action">Adres: <?=$user_about[2]?> </div>
            <div  class="list-group-item list-group-item-action">
                <button type="submit" class="btn btn-primary">
                    <a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=update"?>">Hesabımı Güncelle</a>
                </button>
                <button class="btn btn-primary"><a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-password"?>">Şifremi Değiştir</a> </button>
            </div>
        </div>

        <?php
        break;
    case "update":
        ?>
        <div style="margin:3%;">
            <form action="index.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Ad</label>
                        <input type="text" class="form-control" id="name" placeholder="Ad">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Soyad</label>
                        <input type="text" class="form-control" id="surname" placeholder="Soyad">
                    </div>
                </div>
                <div class="form-group ">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Addres</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Adres bilginizi giriniz">
                </div>
                <button type="submit" class="btn btn-primary">Hesabımı Güncelle</button>
                <button class="btn btn-primary"><a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-password"?>">Şifremi Değiştir</a> </button>
            </form>

        </div>
        <?php
        break;
    case "re-password":
        ?>
        <div style="margin:3%;">
            <form action="index.php" method="post">
                <div class="form-group ">
                    <label for="inputEmail4">Eski parola</label>
                    <input type="email" class="form-control" id="inputEmail4" placeholder="Eski parola">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Yeni parola</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Yeni Parola">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Yeni parola tekrar</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Yeni parola tekrar">
                </div>
                <button type="submit" class="btn btn-primary" >Şifremi Değiştir</button>
            </form>
        </div>

        <?php
        break;
    case "adres":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active">
                Adres :<br><?=$user_about[2]?>
            </div>
            <div  class="list-group-item list-group-item-action"> Diğer adresim:<br> <?=$user_about[2]?></div>
            <button class="btn btn-primary"><a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-adres"?>">Adresi Güncelle</a> </button>
        </div>
        <?php
        break;
    case "re-adres":
        ?>
        <div style="margin:3%;" class="container">
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="exampleInputEmail1">Adres: </label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="adresHelp" placeholder="Adres">
                    <small id="adresHelp" class="form-text text-muted">Asıl adres kısmı boş bırakılamaz.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Diğer adres: </label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Diğer adres">
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
            </form>
        </div>
<?php
        break;
    default:
        echo "Hata";
        break;
    }
        ?>
