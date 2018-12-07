<?php
include('dbClass.php');
	class user
	{
		private $id;
		public $username;
		public $name;
		public $surname;
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
		
		function security($text)
		{
			return $this->db->security($text);
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
				$this->password = $row['k_sifre'];
				$this->udate = $row['tarih'];
				$this->statue = $row['online'];
				$this->ip_addr = $row['ip'];
			}
			
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


        function adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_cat, $urun_img)
        {
            return $this->adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_cat, $urun_img);
        }
	}
?>