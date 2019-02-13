<?php

	class dbMain
	{

		private $host = "localhost";//main decleration
		private $huser = "root";
		private $hpass = "";
		private $database = "marketing";
		private $dsn;

        /**
         * @var $pdo PDO
         */
		protected $pdo;
		private $connection = false;
			
		function __construct()
		{
			$this->dsn = "mysql:host=".$this->host."; dbname=".$this->database."";
		}
		public function __sleep()
		{
			return array('dsn', 'huser', 'hpass', 'host', 'database', 'connection', 'pdo');
		}
		public function __wakeup()
		{
			$this->connect();
		}
		
	    function connect()
		{
			try
			{
				$this->pdo = new PDO($this->dsn, $this->huser, $this->hpass);
				$this->pdo->exec("SET CHARACTER SET utf8");
				$this->connection = true;
				//echo 'its ok '.$this->host . ' ' . $this->huser . ' ' . $this->hpass . ' ' . $this->dsn;
			}catch(PDOException $e)
			{
				//echo 'Connection Failed ' . $e->getMessage();
			}
		}
		
		function disconnect()
		{
			$this->pdo = null;
			$this->connection = false;
		}

        function security($text, $texttype = "normal")
        {

            if($texttype == "normal")
                $text = substr($text, 0, 32);
            else
                $text = substr($text, 0, 1024);

            $text = addslashes(htmlspecialchars(strip_tags(trim($text)), ENT_NOQUOTES || ENT_SUBSTITUTE, "UTF-8"));

            return $text;
        }

		function systemLogIt($user_name, $u_log, $u_lcat, $u_ip, $u_date)
        {
            try
            {
                $prepare = $this->pdo->prepare("INSERT INTO m_log(k_adi, log, log_cat, ip, tarih) VALUES (:k_ad, :l_log, :l_logcat, :l_ip, :l_date)");
                $prepare->execute(array(
                    "k_ad" => $user_name,
                    "l_log" => $u_log,
                    "l_logcat" => $u_lcat,
                    "l_ip" => $u_ip,
                    "l_date" => $u_date
                ));
            }catch (PDOException $e)
            {
                //echo "Log Does Not Response..";
            }
        }
		
		function logIn($uname, $upass)
		{

			$prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE k_adi = '{$uname}' AND k_sifre = '{$upass}'");
			$prepare->execute();
			
			if($prepare->rowCount())
			{
				//$result = $prepare->fetchAll();
				$this->pdo->query("UPDATE m_users SET online = 1 WHERE k_adi = '{$uname}'");
				return true;
			}else
			{
				$error = $this->pdo->errorInfo();
				echo 'Cant logged in ' . $error[2];
				return false;
			}
		}

		function getUserPermission($id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE id = '{$id}'");
            $prepare->execute();

            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                foreach ($result as $item)
                {
                    $result = $item['user_group'];
                }

                return $result;
            }else
            {
                $error = $this->pdo->errorInfo();
                echo 'Cant get permissions user not found! ' . $error[2];
                return false;
            }
        }

		function logOut($uname, $upass)
		{
			try
			{
				$this->pdo->query("UPDATE m_users SET online = 0 WHERE k_adi = '{$uname}'");
			}catch(PDOException $e)
			{
				echo 'Maybe you already logged out.. ';
				echo '' . $e->getMessage();
			}
		}

        function createNewUser($ad, $soyad, $hash, $ip, $uname, $upass)
        {
            try
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_uactive WHERE u_mail =:mail");
                $prepare->execute(array(
                    "mail" => $uname
                ));

                if($prepare->rowCount()>0)
                {
                    echo "Bu E-Posta Adresi Kullanımda!";
                    return false;
                }else
                {
                    $prepare = $this->pdo->prepare("INSERT INTO m_uactive(u_mail, u_pass, u_ad, u_soyad, u_hash, u_ip, u_active) VALUES(:umail, :upass, :uad, :usoyad, :uhash, :uip, :uactive)");

                    $prepare->execute(array(
                        "umail" => $uname,
                        "upass" => $upass,
                        "uad" => $ad,
                        "usoyad" => $soyad,
                        "uhash" => $hash,
                        "uip" => $ip,
                        "uactive" => 0
                    ));

                    if($prepare->rowCount()>0)
                    {
                        return true;
                    }else
                    {
                        return false;
                    }
                }



            }catch(PDOException $e)
            {
                echo 'Cant Create User ' . $e->getMessage();
                return false;
            }

        }

        function activateUser($email, $hash)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_uactive WHERE u_mail =:umail AND u_hash =:uhash");
            $prepare->execute(array(
                "umail" => $email,
                "uhash" => $hash
            ));
            $info = $prepare->fetchAll();
            if($prepare->rowCount())
            {
                $mail = "";
                $pw = "";
                $ad = "";
                $soyad = "";
                $active_id = 0;
                $is_active = 0;

                foreach ($info as $item)
                {
                    $mail = $item['u_mail'];
                    $pw = $item['u_pass'];
                    $ad = $item['u_ad'];
                    $soyad = $item['u_soyad'];
                    $active_id = $item['id'];
                    $is_active = $item['u_active'];
                }

                if($is_active == 1)
                {
                    return false;
                }else
                    {
                        $prepare = $this->pdo->prepare("INSERT INTO m_users(k_adi, k_sifre) VALUES (:mail, :pw)");
                        $prepare->execute(array(
                            "mail" => $mail,
                            "pw" => $pw
                        ));

                        if($prepare->rowCount()>0)
                        {
                            $id = $this->pdo->lastInsertId();

                            try
                            {
                                $prepare = $this->pdo->prepare("INSERT INTO m_uinfo(k_id, k_ad, k_soyad, k_tel, k_adresi) VALUES(:k_id, :k_ad, :k_soyad, :k_tel, :k_adres)");
                                $prepare->execute(array(
                                    "k_id" => $id,
                                    "k_ad" => $ad,
                                    "k_soyad" => $soyad,
                                    "k_tel" => 0,
                                    "k_adres" => "-"
                                ));
                                if($prepare->rowCount()>0)
                                {
                                    $prepare = $this->pdo->prepare("UPDATE m_uactive SET u_active=:active WHERE id=:kid");
                                    $prepare->execute(array(
                                        "active" => 1,
                                        "kid" => $active_id
                                    ));
                                    return true;
                                }

                            }catch(PDOException $e)
                            {
                                echo 'Cant Create User Infos ' . $e->getMessage();
                                return false;
                            }
                        }
                    }


            }else
            {
                echo 'Cant Active User';
                return false;
            }
        }

        function getUserInfo($uname, $upass)
		{
			$prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE k_adi = '{$uname}' AND k_sifre = '{$upass}'");
			$prepare->execute();
			
			if($prepare->rowCount())
			{
				$result = $prepare->fetchAll();
				return $result;
			}else
			{
				$error = $this->pdo->errorInfo();
				echo 'Cant get the user infos' . $error[2];
				return false;
			}
		}
		//Get User Specific Infos
		function getUserSpecInfo($spec, $id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_uinfo WHERE k_id = '{$id}'");
            $prepare->execute();

            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                foreach ($result as $item)
                {
                    if($spec == "ad")
                        $result = $item['k_ad'];
                    else if($spec == "soyad")
                        $result = $item['k_soyad'];
                    else if($spec == "tel")
                        $result = $item['k_tel'];
                    else if($spec == "adres")
                        $result = $item['k_adresi'];
                    else if($spec == "adres2")
                        $result = $item['k_adresi2'];
                    else
                        $result = false;
                }
                return $result;
            }else
            {
                //$error = $this->pdo->errorInfo();
                //echo 'Cant get the user infos' . $error[2];
            }
        }
		
		function setSecure($id)
		{
		    $u_adress = "";
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $u_adress = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $u_adress = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $u_adress = $_SERVER["REMOTE_ADDR"];
            }
			$info=''.$_SERVER['HTTP_USER_AGENT'].''.$u_adress.''.$id.''.$_SESSION['user'].'';
			$hash = hash("sha256",$info);
			
			try
			{
				$prepare = $this->pdo->prepare("UPDATE m_users SET ip = '{$u_adress}', session_hash = '{$hash}' WHERE id = '{$id}'");
				$prepare->execute();
			}catch(PDOException $e)
			{
				
				//echo 'ERROR! '.$e->getMessage();
			}

		}
		
		function getHash($id)
		{
            $prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE id = '{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                //echo 'Cant Get Hash '.$error[2];
            }
		}


		function getUserCount()
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_users");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                return false;
            }
        }

        function updateUserMainInfos($u_id, $email, $adres)
        {
            try
            {
                $prepare = $this->pdo->prepare("UPDATE m_users SET k_adi=:email WHERE id=:u_id");
                $prepare->execute(array(
                    "email" => $email,
                    "u_id" => $u_id
                ));
                try
                {
                    $prepare = $this->pdo->prepare("UPDATE m_uinfo SET k_adresi=:k_adres WHERE k_id=:u_id");
                    $prepare->execute(array(
                        "k_adres" => $adres,
                        "u_id" => $u_id
                    ));
                    return true;
                }catch (PDOException $e)
                {
                    return false;
                }
            }catch (PDOException $e)
            {
                return false;
            }
        }
        function updateUserAdress($u_id ,$adres, $adres2)
        {
            $prepare = $this->pdo->prepare("UPDATE m_uinfo SET k_adresi=:adres, k_adresi2=:adres2 WHERE k_id=:u_id");
            $prepare->execute(array(
                "adres" => $adres,
                "adres2" => $adres2,
                "u_id" => $u_id
            ));
            if($prepare->rowCount())
            {
                return true;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                return false;
            }
        }

        function updateUserPassword($u_id, $new_password)
        {
            $prepare = $this->pdo->prepare("UPDATE m_users SET k_sifre=:sifre WHERE id=:u_id");
            $prepare->execute(array(
                "sifre" => md5($new_password),
                "u_id" => $u_id
            ));
            if($prepare->rowCount())
            {
                return true;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                return false;
            }
        }



        function userAddOrder($u_id, $u_name, $u_surname, $u_ip, $u_adres, $u_sepet, $u_tel, $is_ok)
        {
            try
            {
                $k_sonuc = ($is_ok) ? 0:5;
                $prepare = $this->pdo->prepare("INSERT INTO m_order(k_id, k_ip, kargo_firma, satis_sonuc) VALUES(:k_id, :k_ip, :k_firma, :k_sonuc)");
                $prepare->execute(array(
                    "k_id" => $u_id,
                    "k_ip" => $u_ip,
                    "k_firma" => "",
                    "k_sonuc" => $k_sonuc
                ));
                $s_id = $this->pdo->lastInsertId();
                try
                {
                    $s_id = $this->pdo->lastInsertId();
                    foreach ($u_sepet as $item)
                    {
                        $prepare = $this->pdo->prepare("INSERT INTO m_orderbill(s_id, urun_id, urun_ad, urun_fiyat, urun_adet) VALUES(:sip_id, :u_id, :u_ad, :u_fiyat, :u_adet)");
                        $prepare->execute(array(
                            "sip_id" => $s_id,
                            "u_id" => $item[0],
                            "u_ad" => $item[2],
                            "u_fiyat" => $item[3],
                            "u_adet" => $item[5]
                        ));
                    }
                    try
                    {
                        $prepare = $this->pdo->prepare("INSERT INTO m_orderbill_info(s_id, u_id, u_name, u_surname, u_adress, u_tel) VALUES(:s_id, :u_id, :u_name, :u_surname, :u_adress, :u_tel)");
                        $prepare->execute(array(
                            "s_id" => $s_id,
                            "u_id" => $u_id,
                            "u_name" => $u_name,
                            "u_surname" => $u_surname,
                            "u_adress" => $u_adres,
                            "u_tel" => $u_tel
                        ));
                        return $s_id;
                    }catch (PDOException $e)
                    {
                        echo 'Cand Add User Billing İnfo to DB';
                        return false;
                    }
                }catch (PDOException $e)
                {
                    //echo 'Cant Add User List Info To Db'
                    return false;
                }

            }catch(PDOException $e)
            {
                echo 'Cant Create User Infos ' . $e->getMessage();
                return false;
            }
        }

        function changeOrderSituat($o_id, $is_ok)
        {
            $prepare = $this->pdo->prepare("UPDATE m_order SET satis_sonuc=:sonuc WHERE id=:o_id");
            $prepare->execute(array(
                "satis_sonuc" => $is_ok,
                "o_id" => $o_id
            ));
            if($prepare->rowCount())
            {
                return true;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                return false;
            }
        }

        function getUrun($id, $situat = "user")
        {
            if($id == "all")
            {
                if($situat == "admin")
                    $prepare = $this->pdo->prepare("SELECT * FROM m_market");
                else
                    $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE is_active > 0");
            }else
            {
                if($situat == "admin")
                    $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE urun_id = '{$id}'");
                else
                    $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE urun_id = '{$id}' AND is_active > 0");
            }
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                //echo 'Cant Get Urun '.$error[2];
            }

        }

        function getAllCategory()
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_itemcat");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                //echo 'Cant Get Item Category At All'.$error[2];
                return false;
            }
        }

        function getUrunKategori($item_cat_id)
        {
            if($item_cat_id == "all")
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_itemcat");
            }else
                {
                    $prepare = $this->pdo->prepare("SELECT * FROM m_itemcat WHERE item_cat_id = '{$item_cat_id}'");
                }
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                //$error = $this->pdo->errorInfo();
                //echo 'Cant Get Item Category At All'.$error[2];
            }

        }
        function getUrunImg($id)
        {
            if($id == "all")
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_marketimg");
            }else
                {
                    $prepare = $this->pdo->prepare("SELECT * FROM m_marketimg WHERE urun_id = '{$id}'");
                }
                $prepare->execute();
                if($prepare->rowCount())
                {
                    $result = $prepare->fetchAll();
                    return $result;
                }
                else
                {
                    return false;
                }

        }

        function getCategory($id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE urun_id = '{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $res = "";
                foreach ($prepare as $item)
                {
                    $res = $item['urun_grup'];
                }
                $prepare = $this->pdo->prepare("SELECT * FROM m_kategori WHERE kat_id = '{$res}'");
                $prepare->execute();
                if($prepare->rowCount())
                    $result = $prepare->fetchAll();
                else
                    $result = false;
                return $result;
            }
            else
            {
                return false;
            }
        }

        function getUrunInfo($id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_marketinfo WHERE urun_id = '{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }


        function findUrun($like_name)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE urun_ad LIKE ?");
            $prepare->execute(array('%'.$like_name.'%'));
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }

        function userGetOrderByUserID($id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE k_id ='{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }
        function userGetOrderBillItems($s_id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_orderbill WHERE s_id ='{$s_id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }
        function userGetOrderBillInfo($s_id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_orderbill_info WHERE s_id ='{$s_id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }

        /*
         * db For Admin Panel
         *
         *
         */

        //Admin Gets His Sold İtem Count İnfo $id = Sold item ID

        function adminGetFirstLog()
        {
            $prepare = $this->pdo->prepare("SELECT tarih FROM m_log LIMIT 1");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result[0][0];
            }
            else
            {
                return false;
            }
        }

        function adminGetItemSoldInfo($s_id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_orderbill WHERE s_id = '{$s_id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }

        function adminGetBillInfo($s_id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_orderbill_info WHERE s_id = '{$s_id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }
            else
            {
                return false;
            }
        }

        function adminUpdateItemCount($item_id, $order_count)
        {
            $item_count = 0;
            foreach ($this->getUrun($item_id) as $item)
            {
                $item_count = $item['urun_adet'];
            }
            $item_count -= $order_count;
            if($item_count < 0)
                return false;

            $prepare = $this->pdo->prepare("UPDATE m_market SET urun_adet=:u_adet WHERE urun_id=:u_id");
            $prepare->execute(array(
               "u_adet" => $item_count,
                "u_id" => $item_id
            ));
            if($prepare->rowCount())
            {
                return true;
            }else
                {
                    return false;
                }
        }
		
        function adminGetItemSoldInfoCount($id)
        {
            $prepare = $this->pdo->prepare("SELECT urun_adet FROM m_orderbill WHERE urun_id = '{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result[0][0];
            }
            else
            {
                return false;
            }
        }

        function adminGetOrderList($limit, $showreq, $dateforcount = false, $order_id = "all", $min_date, $max_date)
        {
            if($dateforcount)
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc > 2 ORDER BY id DESC LIMIT 1");
                $prepare->execute();

                if($prepare->rowCount())
                {
                    $result = $prepare->fetchAll();
                    return $result;
                }else
                {
                    return false;
                }
            }else
            {
                if($limit == "" && $showreq == "")
                {
                    if($order_id == "all")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 ORDER BY id DESC");
                    }
                    else if($order_id == "completed")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc > 2 AND satis_sonuc < 4 ORDER BY id DESC");
                    }
                    else if($order_id == "uncompleted")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 2 AND last_op_date BETWEEN :min_date AND :max_date ORDER BY id DESC");
                        $prepare->bindValue(':min_date', $min_date, PDO::PARAM_STR);
                        $prepare->bindValue(':max_date', $max_date, PDO::PARAM_STR);
                    }
                    else
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 AND id='{$order_id}'");
                    }
                    $prepare->execute();

                    if($prepare->rowCount())
                    {
                        $result = $prepare->fetchAll();
                        return $result;
                    }else
                    {
                        return false;
                    }
                }else
                {
                    if($order_id == "all")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 ORDER BY id DESC LIMIT :limit OFFSET :showReq");
                    }
                    else if($order_id == "completed")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc > 2 AND satis_sonuc < 4 ORDER BY id DESC LIMIT :limit OFFSET :showReq");
                    }
                    else if($order_id == "uncompleted")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 2 AND last_op_date BETWEEN :min_date AND :max_date ORDER BY id DESC LIMIT :limit OFFSET :showReq");
                        $prepare->bindValue(':min_date', $min_date, PDO::PARAM_STR);
                        $prepare->bindValue(':max_date', $max_date, PDO::PARAM_STR);
                    }
                    else
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 AND id='{$order_id}' LIMIT :limit OFFSET :showReq");
                    }
                    $prepare->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                    $prepare->bindValue(':showReq', (int)$showreq, PDO::PARAM_INT);
                    $prepare->execute();

                    if($prepare->rowCount())
                    {
                        $result = $prepare->fetchAll();
                        return $result;
                    }else
                    {
                        return false;
                    }
                }


            }

        }
        function adminFindUserFromOrder($order_id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE id = '{$order_id}'");
            $prepare->execute();

            if($prepare->rowCount())
            {
                $user_id = "";
                foreach ($prepare as $item)
                {
                    $user_id = $item['k_id'];
                }
                $prepare = $this->pdo->prepare("SELECT * FROM m_uinfo WHERE k_id = '{$user_id}'");
                $prepare->execute();
                if($prepare->rowCount())
                {
                    $result = $prepare->fetchAll();
                    return $result;
                }else
                    {
                        return false;
                    }

            }else
            {
                return false;
            }
        }

        function adminFindUser($id)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE id = '{$id}'");
            $prepare->execute();
            if($prepare->rowCount())
            {
                $result = $prepare->fetchAll();
                return $result;
            }else
            {
                return false;
            }
        }



        function adminAddNewCategory($cat_name)
        {
            $prepare = $this->pdo->prepare("INSERT INTO m_itemcat(item_cat_name) VALUES (:ic_name)");
            $prepare->execute(array(
                "ic_name" => $cat_name
            ));
            if($prepare->rowCount())
            {
                return true;
            }else
                {
                    return false;
                }
        }

        function adminDeleteCategory($cat_id)
        {

            try
            {
                $prepare = $this->pdo->prepare("DELETE FROM m_itemcat WHERE item_cat_id =:cat_id");
                $prepare->execute(array(
                   "cat_id" => $cat_id
                ));
                if($prepare->rowCount()>0)
                {
                    try
                    {
                        $prepare = $this->pdo->prepare("DELETE FROM m_item WHERE kat_id=:cat_id");
                        $prepare->execute(array(
                            "cat_id" => $cat_id
                        ));

                    }catch (PDOException $e)
                    {

                    }
                }
                return true;
            }catch (PDOException $e)
            {
                return false;
            }

        }


        function adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            try
            {
                $prepare = $this->pdo->prepare("INSERT INTO m_market(urun_ad, urun_aciklama, urun_details, urun_fiyat, kdv, urun_adet, urun_tarih, urun_grup) VALUES(:u_ad, :u_acik, :u_detay, :u_fiyat, :u_kdv, :u_adet, :u_tarih, :u_grup)");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "u_ad" => $urun_ad,
                    "u_acik" => $urun_desc,
                    "u_detay" => $urun_desc,
                    "u_fiyat" => $urun_price,
                    "u_kdv" => $urun_kdv,
                    "u_adet" => $urun_count,
                    "u_tarih" => $adate,
                    "u_grup" => $urun_cat
                ));
               return $new_id = $this->pdo->lastInsertId();

            }catch (PDOException $e)
            {
                return false;
            }
        }
        function adminAddNewItemImg($urun_id, $urun_img_num, $urun_ad, $urun_img)
        {
            $is_there = false;
            try
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_marketimg WHERE urun_id = '{$urun_id}'");
                $prepare->execute();
                if($prepare->rowCount())
                {
                    $result = $prepare->fetchAll();
                    for($i = 0; $i < count($result); $i++)
                    {
                        if($i == $urun_img_num)
                            $is_there = true;
                    }

                }
                if($is_there)
                {
                    $this->adminEditItemImg($urun_id, $urun_img_num, $urun_ad, $urun_img);
                }else
                    {
                        $prepare = $this->pdo->prepare("INSERT INTO m_marketimg(urun_id, urun_img) VALUES(:u_id, :u_img)");
                        $prepare->execute(array(
                            "u_id" => $urun_id,
                            "u_img" => "images/".$urun_ad.$urun_id."/".$urun_img
                        ));
                    }

                return true;

            }catch (PDOException $e)
            {
                return false;
            }
        }
        function adminSetItemActive($u_id ,$is_active)
        {

            try
            {
                if($is_active)
                {
                    $prepare = $this->pdo->prepare("UPDATE m_market SET is_active=:active WHERE urun_id=:u_id");
                    $prepare->execute(array(
                        "active" => 1,
                        "u_id" => $u_id
                    ));
                }else
                {
                    $prepare = $this->pdo->prepare("UPDATE m_market SET is_active=:active WHERE urun_id=:u_id");
                    $prepare->execute(array(
                        "active" => 0,
                        "u_id" => $u_id
                    ));
                }

                return true;

            }catch (PDOException $e)
            {
                return false;
            }
        }
        function adminEditItem($urun_id ,$urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            try{
                $prepare = $this->pdo->prepare("UPDATE m_market SET urun_ad=:u_ad, urun_aciklama=:u_acik, urun_details=:u_detay, urun_fiyat=:u_fiyat, kdv=:u_kdv, urun_adet=:u_adet, urun_tarih=:u_tarih, urun_grup=:u_grup WHERE urun_id =:u_id");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "u_ad" => $urun_ad,
                    "u_acik" => $urun_desc,
                    "u_detay" => $urun_desc,
                    "u_fiyat" => $urun_price,
                    "u_kdv" => $urun_kdv,
                    "u_adet" => $urun_count,
                    "u_tarih" => $adate,
                    "u_grup" => $urun_cat,
                    "u_id" => $urun_id
                ));
                return true;

            }catch (PDOException $e)
                {
                return false;
                }
        }
        function adminEditItemImg($urun_id, $urun_img_id, $urun_ad, $urun_img)
        {
            try
            {

                $prepare = $this->pdo->prepare("SELECT * FROM m_marketimg WHERE urun_id = '{$urun_id}'");
                $prepare->execute();
                if($prepare->rowCount())
                {
                    $images = $prepare->fetchAll();
                }

                $prepare = $this->pdo->prepare("UPDATE m_marketimg SET urun_img=:u_img WHERE urun_id=:u_id AND id=:u_img_id");
                $prepare->execute(array(
                    "u_img" => "images/".$urun_ad.$urun_id."/".$urun_img,
                    "u_id" => $urun_id,
                    "u_img_id" => $images[$urun_img_id][0]
                ));
                return true;

            }catch (PDOException $e)
            {
                return false;
            }
        }
//TODO Change This
        function adminEditShipInfo($ship_id, $ship_number, $s_result, $s_name)
        {
            try
            {
                $prepare = $this->pdo->prepare("UPDATE m_order SET kargo_takip_no=:s_number, last_op_date=:s_lastch, satis_sonuc=:s_result, kargo_firma=:k_firma WHERE id=:s_id");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "s_number" => $ship_number,
                    "s_lastch" => $adate,
                    "s_result" => $s_result,
                    "k_firma" => $s_name,
                    "s_id" => $ship_id
                ));
                return true;

            }catch (PDOException $e)
            {
                return false;
            }
        }
//TODO Warning about Delete ..// like directories maybe $item_img_desc['1'] could be empty like, and it can delete all images.
        function adminDeleteItem($item_id)
        {
            try
            {
                $prepare = $this->pdo->prepare("DELETE FROM m_market WHERE urun_id=:u_id");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "u_id" => $item_id
                ));
                try
                {
                    $item_img = $this->getUrunImg($item_id);
                    if($item_img)
                    {
                        foreach($item_img as $item)
                        {
                            $item_img_desc = explode("/", $item[2]);
                            break;
                        }
                        $secure = false;
                        if(empty($item_img_desc[1]))
                        {
                            $secure = false;
                        }else
                            {
                                $dirPath = "../images/".$item_img_desc[1];
                                $secure = true;
                            }


                        $prepare = $this->pdo->prepare("DELETE FROM m_marketimg WHERE urun_id=:u_id");
                        $adate = date('Y-m-d H-i-s');
                        $prepare->execute(array(
                            "u_id" => $item_id
                        ));
                        if($prepare->rowCount() > 0 && $secure)
                        {
                            //Its So Dangerous Deleting Be CareFULL!
                            $this->deleteDir($dirPath);
                            return true;
                        }


                    }else
                        {
                            echo "Ürünü Sildiniz yada Öyle Bir Ürün Bulunamadı..";
                        }


                }catch (PDOException $e)
                {
                    return false;
                }


            }catch (PDOException $e)
            {
                return false;
            }
        }

        function adminDeleteOrder($order_id)
        {
            try
            {
                $prepare = $this->pdo->prepare("DELETE FROM m_order WHERE id=:o_id");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "o_id" => $order_id
                ));
                try
                {
                    $prepare = $this->pdo->prepare("DELETE FROM m_orderbill WHERE s_id=:o_id");
                    $adate = date('Y-m-d H-i-s');
                    $prepare->execute(array(
                        "o_id" => $order_id
                    ));
                    try
                    {
                        $prepare = $this->pdo->prepare("DELETE FROM m_orderbill_info WHERE s_id=:o_id");
                        $adate = date('Y-m-d H-i-s');
                        $prepare->execute(array(
                            "o_id" => $order_id
                        ));
                        return true;
                    }catch (PDOException $e)
                    {
                        return false;
                    }
                }catch (PDOException $e)
                {
                    return false;
                }


            }catch (PDOException $e)
            {
                return false;
            }
        }

        //Be CAREFULL
        private function deleteDir($dirPath) {
            if (! is_dir($dirPath) || strlen($dirPath) < 10) {
                throw new InvalidArgumentException("$dirPath must be a directory");
                return;
            }
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }

	}

	

	

	

	
?>