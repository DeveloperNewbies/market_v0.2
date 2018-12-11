<?php
include('dbClass.php');
	class user
	{
		private $id;
		public $username;
		public $name;
		public $surname;
        private $adress;
        private $adress2;
        private $tel;
		private $password;
		public $udate;

		/** @var $db dbMain */
		protected $db;

		private $isLog;
		private $uinfos;
		public $statue;
		private $ip_addr;
		private $permission;
		
		function __construct()
		{
            $this->createDb();
			
		}
		
		//Setting up for serializing PDO
		public function __sleep()
		{
			unset($this->db);
			unset($this->uinfos);
			$this->uinfos = '';
			$this->db = '';
			return array_keys(get_object_vars($this));
		}
		//Retrieve all variables to object of user
		public function __wakeup()
		{
			$this->createDb();
			
			$this->getUserInfos($this->username, $this->password);
			//echo ' '.$this->username;
		}
		
		
		public static function userCreator()
		{
			return (new self());
		}
		
		function createUser($nuname, $nupass)
		{
			$this->createDb();
			
			$nuname = $this->security($nuname);
			$nupass = $this->security($nupass);
			
			$nupass = md5($nupass);
			
			$this->logIn($nuname, $nupass);
			if($this->isLogged())
			{
                $this->getUserInfos($nuname, $nupass);

                $this->permission = $this->db->getUserPermission($this->id);

            }

			

		}
		
		function registerNewUser($ad, $soyad, $nuname, $nupass)
		{
			$this->createDb();
			
			$ad = $this->security($ad);
			$soyad = $this->security($soyad);
			$nuname = $this->security($nuname);
			$nupass = $this->security($nupass);
			$nupass = md5($nupass);
			
			$result = $this->db->createNewUser($ad, $soyad, $nuname, $nupass);
			return $result;
		}
		
		function security($text, $texttype = "normal")
		{
			return $this->db->security($text, $texttype);
		}
		
		
		function getUserInfos($nuname, $nupass)
		{
			unset($this->uinfos);
			$this->uinfos = $this->db->getUserInfo($nuname,$nupass);
			foreach($this->uinfos as $row)
			{
				$this->id = $row['id'];
				$this->username = $row['k_adi'];
				$this->name = $this->db->getUserSpecInfo("ad", $row['id']);
				$this->surname = $this->db->getUserSpecInfo("soyad", $row['id']);
				$this->tel = $this->db->getUserSpecInfo("tel", $row['id']);
				$this->adress = $this->db->getUserSpecInfo("adres", $row['id']);
				$this->adress2 = $this->db->getUserSpecInfo("adres2", $row['id']);
				$this->password = $row['k_sifre'];
				$this->udate = $row['tarih'];
				$this->statue = $row['online'];
				$this->ip_addr = $row['ip'];
			}
			
		}
		function getUserInfosOut()
        {
            return array(
                "e-posta" => $this->username,
                "ad" => $this->name,
                "soyad" => $this->surname,
                "tel" => $this->tel,
                "adres" => $this->adress,
                "adres2" => $this->adress2
            );
        }
		function logIn($uname1, $upass1)
		{
			$this->isLog = $this->db->logIn($uname1, $upass1);
		}
		
		function isLogged()
		{
			return $this->isLog;
		}
		
		function logOut()
		{
			$this->db->logOut($this->username, $this->password);
			$this->db->disconnect();
		}
		
		function createDb()
		{
			unset($this->db);
			$this->db = new dbMain();
			$this->db->connect();
		}
		
		/*function dcDb()
		{
			
			$this->db->disconnect();
			$this->db = null;
			
		}*/
		
		//Sends array of users all infos
		
		function userInfos()
		{
			return $this->uinfos;
			//
			//$ui = array($this->id,$this->username,$this->date, $this->statue);
			//return $ui;
		}
		
		function setSecurity()
		{
			$this->createDb();
			$this->db->setSecure($this->id);
		}
		
		function getHash()
		{
			return $this->db->getHash($this->id);
		}
		
		function getIp()
		{
			return $this->ip_addr;
		}
		function getID()
		{
			return $this->id;
		}
		

		function showUserInfo()
		{
			echo ' Kullanıcı: ' . $this->username;
			echo ' Şifre: ' . $this->password;
			echo ' Tarih: ' . $this->udate;
		}


		function getUserCount()
        {
            return $this->db->getUserCount();
        }

        function getPermission()
        {
            return $this->permission;
        }

        function updateAdress($u_id, $adress, $adress2)
        {
            if($this->db->updateUserAdress($u_id, $adress, $adress2))
            {
                $this->adress = $adress;
                $this->adress2 = $adress2;
                return true;
            }else
                {
                    return false;
                }

        }


        function getUrun($id)
        {
            return $this->db->getUrun($id);
        }

        function getUrunKategori($item_cat_id)
        {
            return $this->db->getUrunKategori($item_cat_id);
        }

        function getUrunIMG($id)
        {
            return $this->db->getUrunImg($id);
        }

        function findUrun($name)
        {
		    return $this->db->findUrun($name);
        }

        function getSiparis($u_id)
        {
            return $this->db->userGetOrder($u_id);
        }

        function addSiparis($u_id, $u_name, $u_surname, $u_adres, $u_ip, $u_sepet)
        {
            return $this->db->userAddOrder($u_id, $u_name, $u_surname, $u_ip, $u_adres, $u_sepet);
        }


		/*
		 * There is Admin Power Activated
		 * $permission > 1
		 * Admin Privileges Granted
		 * */
		function adminGetFirstLog()
        {
            return $this->db->adminGetFirstLog();
        }
        function adminGetItem($id)
        {
            return $this->db->getUrun($id);
        }
        function adminGetItemSoldCount($id)
        {
            return $this->db->adminGetItemSoldInfoCount($id);
        }
        function adminGetOrderCount($limit, $showrequest, $dateforcount = false, $order_id = "all")
        {
            return $this->db->adminGetOrderList($limit, $showrequest, $dateforcount, $order_id);
        }
        function adminFindUser($id)
        {
            return $this->db->adminFindUserFromOrder($id);
        }

//Admin İtem Functions..
        function adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            return $this->db->adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat);
        }
        function adminAddNewItemImg($urun_id, $urun_ad, $urun_img)
        {
            return $this->db->adminAddNewItemImg($urun_id, $urun_ad, $urun_img);
        }
        function adminEditItem($urun_id ,$urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            return $this->db->adminEditItem($urun_id ,$urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat);
        }
        function adminEditItemImg($urun_id, $urun_img_id,$urun_ad, $urun_img)
        {
            return $this->db->adminEditItemImg($urun_id, $urun_img_id, $urun_ad, $urun_img);
        }
        function adminEditShipInfo($ship_id, $ship_number, $s_result)
        {
            return $this->db->adminEditShipInfo($ship_id, $ship_number, $s_result);
        }

        function adminDeleteItem($item_id)
        {
            return $this->db->adminDeleteItem($item_id);
        }
        function adminDeleteOrder($order_id)
        {
            return $this->db->adminDeleteOrder($order_id);
        }
	}
?>