<?php
/**
 * Created by PhpStorm.
 * User: mehmet
 * Date: 6.12.2018
 * Time: 19:05
 */
/** @var $user user */
$user_account_update_pass_alert = "re";

$usertmp_mail = ($user->getUserInfosOut()['e-posta']);
$usertmp_adres = ($user->getUserInfosOut()['adres']);

    $re_pas = (isset($_GET["reload"])) ? $_GET["reload"] : "home";

    //user about update
     if(isset($_POST["control"]))
         switch ($_POST["control"]) {
             case "account":
                 if ( isset( $_POST["password"] ) && isset( $_POST["email-address"] ) && isset( $_POST["address"] )) {
                     if ( $user->checkPass($user->security($_POST['password'], "pass")) && $_POST["email-address"] != "" &&  $_POST["address"] != "")
                     {
                         $user_email = $user->security ( $_POST["email-address"] , "mail");

                         $user_adres = $user->security ( $_POST["address"] , "adres");
                         ///////////////////////////
                         //database user data update
                         //name $name
                         //surname $surname
                         //email  $user_email
                         //adres $user_adres
                         //işlem başarılı ise $user_account_update_pass_alert = "false";
                         //yap

                         $is_ok = $user->updateInfos($user->getID(), $user_email, $user_adres);
                         if($is_ok)
                         {
                             $user_account_update_pass_alert = "false";
                             unset($_SESSION['user']);
                             $_SESSION['user'] = base64_encode(serialize($user));
                             $user->setSecurity();
                             $usertmp_mail = $user_email;
                             $usertmp_adres = $user_adres;
                         }else
                             $user_account_update_pass_alert = "true";


                     }else
                         {
                           ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong> <?=$m_lang[$lang][59]?> !</strong> 
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                    <?php
                         }

                 } else $user_account_update_pass_alert = "true";
              break;
             case "re-pass":
                 if ( isset($_POST['password']) && isset( $_POST['new-password'] ) && isset( $_POST['new-password-r'] )) {
                     if ( $_POST['new-password-r'] != "" && $_POST['new-password'] != "" && $user->checkPass($user->security($_POST['password'], "pass")))
                     {

                         $new_pass = $user->security($_POST['new-password'], "pass");
                         $new_pass_r = $user->security($_POST['new-password-r'], "pass");


                         if($new_pass == $new_pass_r){
                             ///////////////////////////
                             //database user data update password
                             //new password $new_pass
                             //işlem başarılı ise $user_account_update_pass_alert = "false";
                             //yap

                             $is_ok = $user->updatePassword($user->getID(), $new_pass);
                             if($is_ok)
                             {
                                 $user_account_update_pass_alert = "false";
                                 unset($_SESSION['user']);
                                 $_SESSION['user'] = base64_encode(serialize($user));
                                 $user->setSecurity();
                             }else
                                 $user_account_update_pass_alert = "true";
                     }else
                         {
                             $user_account_update_pass_alert = "true";
                         }

                     }else $user_account_update_pass_alert = "true";
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
               echo "<h1>hata</h1>";
             break;
     }






switch ($re_pas){
    case "home":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active">
                <?=$m_lang[$lang][60]?>: <?php echo $user_about[1]." ".$user_about[2]; ?>
            </div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;"> E-mail: <?=$user_about[0]?></div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;"><?=$m_lang[$lang][39]?>: <?=$user_about[4]?> </div>
            <div  class="list-group-item list-group-item-action">
                
            <form method="post">
                    <input type="submit" class="btn btn-primary" formaction="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=update"?>" style="margin: 10px;" value="<?=$m_lang[$lang][61]?>" name="up_ad">
           
                    <input type="submit" class="btn btn-primary" style="margin: 10px;" formaction="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-password"?>" value="<?=$m_lang[$lang][88]?>" name="up_ad">
            </form>
                
                
            </div>
        </div>

        <?php
        break;
    case "update":
        ?>
        <div style="margin:3%;44">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?m=hesabim&account=hesabim&reload=update" method="post">
                <?php if($user_account_update_pass_alert == "true"){ ?>
                    <div class="form-group ">
                        <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][59]?></h3> </label>
                    </div>
                <?php }else if ($user_account_update_pass_alert == "false"){?>
                    <div class="form-group ">
                        <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][63]?></h3> </label>
                    </div>
                <?php  } ?>
                <div class="form-group ">
                    <label for="inputEmail4"><?=$m_lang[$lang][64]?>:</label>
                    <input type="password" class="form-control" id="name" name="password" placeholder="<?=$m_lang[$lang][64]?>" required>
                </div>

                <div class="form-group ">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="email" name="email-address" placeholder="Email" value="<?=$usertmp_mail?>" required>
                </div>
                <div class="form-group">
                    <label for="inputAddress"><?=$m_lang[$lang][39]?></label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="<?=$m_lang[$lang][39]?>" value="<?=$usertmp_adres?>">
                </div>
                <input type="hidden" name="control" value="account" >
                <input type="submit" class="btn btn-primary" value="<?=$m_lang[$lang][61]?>">
                <input type="submit" class="btn btn-primary" formaction="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-password"?>" style="margin: 10px;" value="<?=$m_lang[$lang][88]?>" name="up_ad">
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
                        <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][59]?></h3> </label>
                <?php }else if($user_account_update_pass_alert == "false"){?>
                    <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][65]?></h3> </label>
                <?php } ?>
            </div>
                <div class="form-group ">
                      <label for="inputEmail4"><?=$m_lang[$lang][66]?></label>
                    <input type="password" class="form-control" id="inputAddress" name="password" placeholder="<?=$m_lang[$lang][66]?>">
                </div>
                <div class="form-group">
                   <label for="inputAddress"><?=$m_lang[$lang][67]?></label>
                    <input type="password" class="form-control" id="inputAddress" name="new-password" placeholder="<?=$m_lang[$lang][67]?>">
                </div>
                <div class="form-group">
                      <label for="inputAddress"><?=$m_lang[$lang][68]?></label>
                    <input type="password" class="form-control" id="inputAddress" name="new-password-r" placeholder="<?=$m_lang[$lang][68]?>">
                </div>
                <input type="hidden" name="control" value="re-pass">
                <input type="submit" class="btn btn-primary" value="<?=$m_lang[$lang][88]?>">
            </form>
        </div>

        <?php
        break;
    case "adres":
        ?>
        <div class="container">
            <div class="list-group-item list-group-item-action active" style="overflow: scroll;">
                  <?=$m_lang[$lang][39]?> :<br><?=$user_about[4]?>
            </div>
            <div  class="list-group-item list-group-item-action" style="overflow: scroll;"> <?=$m_lang[$lang][39]?>:<br> <?=(strlen($user_about[5]) > 0) ? $user_about[5] : "-" ?></div>
            <form action="<?=$home_link."/index.php?m=hesabim&account=hesabim&reload=re-adres"?>" method="post">
                    <input type="submit" class="btn btn-primary" style="margin: 10px;" value="<?=$m_lang[$lang][69]?>" name="up_ad">
            </form>
            
        </div>
        <?php
        break;
    case "re-adres":
        ?>
        <div style="margin:3%;" class="container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?m=hesabim&account=hesabim&reload=re-adres" method="post">
                <?php if($user_account_update_pass_alert == "true"){ ?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][71]?></h3> </label>
                    </div>
                <?php }else if($user_account_update_pass_alert == "false"){?>
                    <div class="form-group col-md-6">
                        <label for="inputEmail4"><h3 class="alert"><?=$m_lang[$lang][70]?></h3> </label>
                    </div>

                <?php } ?>
                <div class="form-group">
                    <label for="exampleInputEmail1"><?=$m_lang[$lang][39]?>: </label>
                    <input type="text" class="form-control" id="InputAdress" name="address" aria-describedby="adresHelp" placeholder="<?=$m_lang[$lang][39]?>" value="<?php echo $user_about[4]; ?>" required>
                    <small id="adresHelp" class="form-text text-muted"><?=$m_lang[$lang][72]?>.</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1"><?=$m_lang[$lang][39]?>: </label>
                    <input type="text" class="form-control" id="InputAdress" name="second-address" placeholder="<?=$m_lang[$lang][89]?>" value="<?php echo (strlen($user_about[5]) > 0) ? $user_about[5]:"-"; ?>">
                </div>
                <input type="hidden" name="control" value="re-adres" >
                <input type="submit" class="btn btn-primary" value="<?=$m_lang[$lang][73]?>">
            </form>
        </div>
      <?php
        break;
    default:
         echo $m_lang[$lang][58];
        break;
    }
        ?>
