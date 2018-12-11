<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 19:05
 */
$user_account_update_pass_alert = "re";

    $re_pas = (isset($_GET["reload"])) ? $_GET["reload"] : "home";

    //user about update
     if(isset($_POST["control"]) )
         switch ($_POST["control"]) {
             case "account":
                 if ( isset( $_POST["password"] ) ) {
                     if ( hash ( "sha256" , $user->security ( $_POST["password"] ) ) == $_SESSION["security_pass"] ) {
                         if ( isset( $_POST["name"] ) )
                             $name = $user->security ( $_POST["name"] );
                         if ( isset( $_POST["surname"] ) )
                             $surname = $user->security ( $_POST["surname"] );
                         if ( isset( $_POST["email"] ) )
                             $user_email = $user->security ( $_POST["email"] );
                         if ( isset( $_POST["address"] ) )
                             $user_adres = $user->security ( $_POST["address"] );
                         ///////////////////////////
                         //database user data update
                         //name $name
                         //surname $surname
                         //email  $user_email
                         //adres $user_adres
                         //işlem başarılı ise $user_account_update_pass_alert = "false";
                         //yap

                         //demo
                         $user_account_update_pass_alert = "false";






                     } else  $user_account_update_pass_alert = "true";
                 } else $user_account_update_pass_alert = "true";
              break;
             case "re-pass":
                 if ( isset( $_POST["password"] ) ) {
                     if ( hash ( "sha256" , $user->security ( $_POST["password"] ) ) == $_SESSION["security_pass"] ) {
                         if ( isset( $_POST["email"] ) ){
                             if(hash ("sha256",$user->security ($_POST["email"])) == $_SESSION["security_username"]){
                                 if ( isset( $_POST["new-password"] ) )
                                     $new_pass = $user->security ( $_POST["new-password"] );
                                 if ( isset( $_POST["new-password-r"] ) )
                                     $new_pass_r = $user->security ( $_POST["new-password-r"] );
                                 if($new_pass == $new_pass_r){
                                     ///////////////////////////
                                     //database user data update password
                                     //new password $new_pass
                                     //işlem başarılı ise $user_account_update_pass_alert = "false";
                                     //yap


                                     //demo
                                     $user_account_update_pass_alert = "false";







                                 }else $user_account_update_pass_alert = "true";
                             }else $user_account_update_pass_alert = "true";
                         }else $user_account_update_pass_alert = "true";
                     } else  $user_account_update_pass_alert = "true";
                 } else $user_account_update_pass_alert = "true";
                 break;
             case "re-adres":
                 $adres = "";
                 $second_adres ="";
                 if(isset($_POST['address']) && !empty($_POST['address'])){

                     if(isset($_POST['second-address']))
                     {

                         $adres = $user->security($_POST['address'], "adres");
                         $second_adres = $_POST['second-address'];
                         if(empty($second_adres))
                             $second_adres = "-";

                         $second_adres = $user->security ($_POST['second-address'], "adres");


                         $is_ok = $user->updateAdress($user->getID(), $adres, $second_adres);
                         if($is_ok)
                         {
                             $user_account_update_pass_alert = "false";
                             unset($_SESSION['user']);
                             $_SESSION['user'] = base64_encode(serialize($user));
                             $user->setSecurity();
                             $user_about = array(
                                 //0 eposta,
                                 //1 ad,
                                 //2 soyad,
                                 //3 tel,
                                 //4 adres1,
                                 //5 adres2
                             );
                             foreach ($user->getUserInfosOut() as $item)
                             {
                                 array_push($user_about, $item);
                             }
                         }else
                             $user_account_update_pass_alert = "true";




                     }


                     //user database update new adres
                     //işlem başarılı ise $user_account_update_pass_alert = "false";
                     //yap
                     //first adres $adres
                     //second adres $second adres

                     //demo

                 }else $user_account_update_pass_alert = "true";
                 break;
         default:
             echo "<h1>Hata</h1>";
             break;
     }






switch ($re_pas){
    case "home":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active">
                Ad soyad: <?php echo $user_about[1]." ".$user_about[2]; ?>
            </div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;"> E-mail: <?=$user_about[0]?></div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;">Adres: <?=$user_about[4]?> </div>
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?m=hesabim&account=hesabim&reload=update" method="post">
                <?php if($user_account_update_pass_alert == "true"){ ?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert">Parolanız hatalı</h3> </label>
                    </div>
                <?php }else if ($user_account_update_pass_alert == "false"){?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert">Hesap bilgileri güncellendi</h3> </label>
                    </div>
                <?php  } ?>
                <div class="form-group ">
                    <label for="inputEmail4">Parolanızı giriniz:</label>
                    <input type="text" class="form-control" id="name" name="password" placeholder="Parola" required>
                </div>

                <div class="form-group ">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Addres</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Adres bilginizi giriniz">
                </div>
                <input type="hidden" name="control" value="account" >
                <button type="submit" class="btn btn-primary">Hesabımı Güncelle</button>
                <button class="btn btn-primary"><a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-password"?>">Şifremi Değiştir</a> </button>
            </form>

        </div>
        <?php
        break;
    case "re-password":
        ?>
        <div style="margin:3%;">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?m=hesabim&account=hesabim&reload=re-password" method="post">
            <div class="form-group">
                <?php if($user_account_update_pass_alert == "true"){ ?>
                        <label for="inputEmail4"><h3 class="alert">Parolanız veya E-postanız hatalı</h3> </label>
                <?php }else if($user_account_update_pass_alert == "false"){?>
                    <label for="inputEmail4"><h3 class="alert">Parolanız Değiştirildi</h3> </label>
                <?php } ?>
            </div>
                <div class="form-group ">
                    <label for="inputEmail4">Eski parola</label>
                    <input type="text" class="form-control" id="inputAddress" name="password" placeholder="Eski parola">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Yeni parola</label>
                    <input type="text" class="form-control" id="inputAddress" name="new-password" placeholder="Yeni Parola">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Yeni parola tekrar</label>
                    <input type="text" class="form-control" id="inputAddress" name="new-password-r" placeholder="Yeni parola tekrar">
                </div>
                <input type="hidden" name="control" value="re-pass">
                <button type="submit" class="btn btn-primary" >Şifremi Değiştir</button>
            </form>
        </div>

        <?php
        break;
    case "adres":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active" style="overflow: scroll;">
                Adres :<br><?=$user_about[4]?>
            </div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;"> Diğer adresim:<br> <?=(strlen($user_about[5]) > 0) ? $user_about[5] : "-" ?></div>
            <button class="btn btn-primary" style="margin: 10px;"><a href="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-adres"?>">Adresi Güncelle</a> </button>
        </div>
        <?php
        break;
    case "re-adres":
        ?>
        <div style="margin:3%;" class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?m=hesabim&account=hesabim&reload=re-adres" method="post">
                <?php if($user_account_update_pass_alert == "true"){ ?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert">Adres değiştirilemedi</h3> </label>
                    </div>
                <?php }else if($user_account_update_pass_alert == "false"){?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert">Adres değiştirildi</h3> </label>
                    </div>

                <?php } ?>
                <div class="form-group">
                    <label for="exampleInputEmail1">Adres: </label>
                    <input type="text" class="form-control" id="InputAdress" name="address" aria-describedby="adresHelp" placeholder="Adres" value="<?php echo $user_about[4]; ?>" required>
                    <small id="adresHelp" class="form-text text-muted">Asıl adres kısmı boş bırakılamaz.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Diğer adres: </label>
                    <input type="text" class="form-control" id="InputAdress" name="second-address" placeholder="Diğer adres" value="<?php echo (strlen($user_about[5]) > 0) ? $user_about[5]:"-"; ?>">
                </div>
                <input type="hidden" name="control" value="re-adres" >
                <input type="submit" class="btn btn-primary" value="Güncelle">
            </form>
        </div>
      <?php
        break;
    default:
        echo "Hata";
        break;
    }
        ?>
