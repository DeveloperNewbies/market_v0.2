<?php
/**
 * Created by PhpStorm.
 * User: Alp
 * Date: 12.02.2019
 * Time: 02:37
 */

require_once ('inc/dbClass.php');
require_once ('inc/secIP.php');

//$activation is hash there created from register.

$db = new dbMain();
$db->connect();

$secip = new secIP();
$realip = $secip->getLocal().$secip->getFile();


$activation = $_GET['act'];
$email = $_GET['mail'];

$email = $db->security($email, "mail");
$activation = $db->security($activation, "hash");

try
{
    $result = $db->activateUser($email, $activation);
    if($result == true)
    {
        header("Refresh: 0; url=".$realip."/login/index.php?register=true");
    }else
        {
            header("Refresh: 0; url=".$realip."/login/index.php?register=false");
        }
}catch (PDOException $e)
{
     //echo "Hata oluştu ". $e->getMessage();
}

?>