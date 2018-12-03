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
				echo 'Connection Failed ' . $e->getMessage();
			}
		}
		
		function disconnect()
		{
			$this->pdo = null;
			$this->connection = false;
		}

        function security($text)
        {
            $text = substr($text, 0, 32);
            $text = addslashes(htmlspecialchars(strip_tags(htmlentities(trim($text)))));
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
                    else if($spec = "adres")
                        $result = $item['k_adresi'];
                    else
                        $result = false;
                }
                return $result;
            }else
            {
                $error = $this->pdo->errorInfo();
                echo 'Cant get the user infos' . $error[2];
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
				
				echo 'ERROR! '.$e->getMessage();
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
                $error = $this->pdo->errorInfo();
                echo 'Cant Get Hash '.$error[2];
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
                $error = $this->pdo->errorInfo();
                echo 'Cant Get Urun '.$error[2];
            }

        }
        function getUrunKategori($item_cat_id)
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
                $error = $this->pdo->errorInfo();
                echo 'Cant Get Hash '.$error[2];
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
                    $error = $this->pdo->errorInfo();
                    echo 'Cant Get Urun IMG '.$error[2];
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


        /*
         * db For Admin Panel
         *
         *
         */

        //Admin Gets His Sold İtem Count İnfo $id = Sold item ID

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

        function adminGetOrderList($limit, $showreq)
        {
            $prepare = $this->pdo->prepare("SELECT * FROM m_order WHERE satis_sonuc > 2");
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

	

	

	

	
?>