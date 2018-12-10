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
		
		function createNewUser($ad, $soyad, $uname, $upass)
		{
			try
			{
				$prepare = $this->pdo->prepare("INSERT INTO m_users(k_adi, k_sifre, tarih, online) VALUES(:uname, :upass, :udate, :ustate)");
				$adate = date('Y-m-d');
				$prepare->execute(array(
				"uname" => $uname,
				"upass" => $upass,
				"udate" => $adate,
				"ustate" => '0'
				));
				$prepare = $this->pdo->prepare("SELECT * FROM m_users WHERE k_adi = '{$uname}' AND k_sifre = '{$upass}'");
				$prepare->execute();
				
				$result = $prepare->fetchAll();
				$k_id_ptr = "";
				foreach($result as $res)
				{
					$k_id_ptr = $res['id'];
				}
				
				
				try
				{
					$prepare = $this->pdo->prepare("INSERT INTO m_uinfo(k_id, k_ad, k_soyad, k_tel, k_adresi) VALUES(:k_id, :k_ad, :k_soyad, :k_tel, :k_adres)");
					$prepare->execute(array(
					"k_id" => $k_id_ptr,
					"k_ad" => $ad,
					"k_soyad" => $soyad,
					"k_tel" => 0,
					"k_adres" => "",
					));
					
					return true;
				}catch(PDOException $e)
				{
					echo 'Cant Create User Infos ' . $e->getMessage();
					return false;
				}
				
			}catch(PDOException $e)
			{
				echo 'Cant Create User ' . $e->getMessage();
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
			$info=''.$_SERVER['HTTP_USER_AGENT'].''.$_SERVER['REMOTE_ADDR'].''.$id.''.$_SESSION['user'].'';
			$hash = hash("sha256",$info);
			$ip_addr = $_SERVER['REMOTE_ADDR'];
			try
			{
				$prepare = $this->pdo->prepare("UPDATE m_users SET ip = '{$ip_addr}', session_hash = '{$hash}' WHERE id = '{$id}'");
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



		function getUrun($id)
        {
            if($id == "all")
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_market");
            }else
            {
                $prepare = $this->pdo->prepare("SELECT * FROM m_market WHERE urun_id = '{$id}'");
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
        function getUrunKategori($item_cat_id)
        {
            if($item_cat_id == "all")
            {
                $prepare = $this->pdo->prepare("SELECT item_cat_name FROM m_itemcat");
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
            }else
                {
                    $prepare = $this->pdo->prepare("SELECT item_cat_name FROM m_itemcat WHERE item_cat_id = '{$item_cat_id}'");
                    $prepare->execute();
                    if($prepare->rowCount())
                    {
                        $result = $prepare->fetchAll();
                        return $result;
                    }
                    else
                    {
                        //$error = $this->pdo->errorInfo();
                        //echo 'Cant Get Item Category'.$error[2];
                    }
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

        function userGetOrder($id)
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

        function adminGetItemSoldInfoCount($id)
        {
            $prepare = $this->pdo->prepare("SELECT urun_adet FROM m_order WHERE urun_id = '{$id}'");
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

        function adminGetOrderList($limit, $showreq, $dateforcount = false, $order_id = "all")
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
                    if($order_id == "all")
                    {
                        $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 ORDER BY id DESC");
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
                            $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc < 4 AND id='{$order_id}'");
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

        function adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            try
            {
                $prepare = $this->pdo->prepare("INSERT INTO m_market(urun_ad, urun_aciklama, urun_details, urun_fiyat, urun_kdv, urun_adet, urun_tarih, urun_grup) VALUES(:u_ad, :u_acik, :u_detay, :u_fiyat, :u_kdv, :u_adet, :u_tarih, :u_grup)");
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
        function adminAddNewItemImg($urun_id, $urun_ad, $urun_img)
        {
            try
            {
                $prepare = $this->pdo->prepare("INSERT INTO m_marketimg(urun_id, urun_img) VALUES(:u_id, :u_img)");
                $prepare->execute(array(
                    "u_id" => $urun_id,
                    "u_img" => "images/".$urun_ad.$urun_id."/".$urun_img
                ));
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
                $prepare = $this->pdo->prepare("UPDATE m_marketimg SET urun_img=:u_img WHERE urun_id=:u_id AND id=:u_img_id");
                $prepare->execute(array(
                    "u_img" => "images/".$urun_ad.$urun_id."/".$urun_img,
                    "u_id" => $urun_id,
                    "u_img_id" => $urun_img_id
                ));
                return true;

            }catch (PDOException $e)
            {
                return false;
            }
        }

        function adminEditShipInfo($ship_id, $ship_number, $s_result)
        {
            try
            {
                $prepare = $this->pdo->prepare("UPDATE m_order SET kargo_takip_no=:s_number, last_op_date=:s_lastch, satis_sonuc=:s_result WHERE id=:s_id");
                $adate = date('Y-m-d H-i-s');
                $prepare->execute(array(
                    "s_number" => $ship_number,
                    "s_lastch" => $adate,
                    "s_result" => $s_result,
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
                return true;

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