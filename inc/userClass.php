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

        function logIT($log, $log_cat)
        {
            $ip = "";
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }

            $tmp_user = $this->getID();

            $ldate = date('Y-m-d H-i-s');

            $this->db->systemLogIt($tmp_user, $log, $log_cat, $ip, $ldate);
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
				$this->logIT("Kullanıcı Giriş Yaptı", "1");
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
		
		/*function userInfos()
		{
			return $this->uinfos;
			//
			//$ui = array($this->id,$this->username,$this->date, $this->statue);
			//return $ui;
		}*/

        function checkPass($old_pass)
        {
            if(md5($old_pass) == $this->password)
            {
                return true;
            }else
            {
                return false;
            }
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
		

		/*function showUserInfo()
		{
			echo ' Kullanıcı: ' . $this->username;
			echo ' Şifre: ' . $this->password;
			echo ' Tarih: ' . $this->udate;
		}*/


		function getUserCount()
        {
            return $this->db->getUserCount();
        }

        function getPermission()
        {
            return $this->permission;
        }

        function updateInfos($id, $email, $adress)
        {
            if($this->db->updateUserMainInfos($id, $email, $adress))
            {
                $this->username = $email;
                $this->adress = $adress;
                $this->logIT("Bilgi Güncellemesi..", "1");
                return true;
            }else
            {
                return false;
            }
        }
        function updateAdress($u_id, $adress, $adress2)
        {
            if($this->db->updateUserAdress($u_id, $adress, $adress2))
            {
                $this->adress = $adress;
                $this->adress2 = $adress2;
                $this->logIT("Adres bilgisi güncellemesi..", "1");
                return true;
            }else
                {
                    return false;
                }

        }
        function updatePassword($id, $new_pass)
        {
            if($this->db->updateUserPassword($id, $new_pass))
            {
                $this->password = md5($new_pass);
                $this->logIT("Şifre bilgisi güncellemesi..", "1");
                return true;
            }else
            {
                return false;
            }
        }

        function getUrun($id, $situat = "user")
        {
            return $this->db->getUrun($id, $situat);
        }

        function getAllCategory()
        {
            return $this->db->getAllCategory();
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
            $this->logIT("Ürün Araması..", "2");
		    return $this->db->findUrun($name);
        }

        function getSiparisByUserID($u_id)
        {
            return $this->db->userGetOrderByUserID($u_id);
        }

        function getSiparisFaturaInfo($s_id)
        {
            return $this->db->userGetOrderBillInfo($s_id);
        }

        function getSiparisUrunInfo($s_id)
        {
            return $this->db->userGetOrderBillItems($s_id);
        }

        function addSiparis($u_id, $u_name, $u_surname, $u_adres, $u_ip, $u_sepet)
        {
            $this->logIT("Sipariş İsteği..", "3");
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
            return $this->db->getUrun($id, "admin");
        }
        function adminGetSoldInfo($s_id)
        {
            return $this->db->adminGetItemSoldInfo($s_id);
        }
        function adminGetBillInfo($s_id)
        {
            return $this->db->adminGetBillInfo($s_id);
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

        //Admin Add New Category to System
        function adminAddNewCat($cat_name)
        {
            $this->logIT("Kategori Eklenmesi..", "2");
            return $this->db->adminAddNewCategory($cat_name);
        }

//Admin İtem Functions..
        function adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            $this->logIT("Yeni Ürün Eklenmesi..", "2");
            return $this->db->adminAddNewItem($urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat);
        }
        function adminAddNewItemImg($urun_id, $urun_img_num, $urun_ad, $urun_img)
        {
            return $this->db->adminAddNewItemImg($urun_id, $urun_img_num, $urun_ad, $urun_img);
        }
        function adminSetItemActive($u_id, $is_active)
        {
            $this->logIT("Ürün Aktifleştirme..", "2");
            return $this->db->adminSetItemActive($u_id, $is_active);
        }
        function adminEditItem($urun_id ,$urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat)
        {
            $this->logIT("Ürün bilgisi güncellemesi..", "2");
            return $this->db->adminEditItem($urun_id ,$urun_ad, $urun_desc, $urun_price, $urun_kdv, $urun_count, $urun_cat);
        }
        function adminEditItemImg($urun_id, $urun_img_id,$urun_ad, $urun_img)
        {
            $this->logIT("Ürün fotoğraf bilgisi güncellemesi..", "2");
            return $this->db->adminEditItemImg($urun_id, $urun_img_id, $urun_ad, $urun_img);
        }
        function adminEditShipInfo($ship_id, $ship_number, $s_result, $s_name)
        {
            $this->logIT("Sipariş bilgisi güncellemesi..", "3");
            return $this->db->adminEditShipInfo($ship_id, $ship_number, $s_result, $s_name);
        }

        function adminDeleteItem($item_id)
        {
            $this->logIT("Ürün silinmesi..", "2");
            return $this->db->adminDeleteItem($item_id);
        }
        function adminDeleteOrder($order_id)
        {
            $this->logIT("Sipariş Silinmesi..", "3");
            return $this->db->adminDeleteOrder($order_id);
        }
	}
?>