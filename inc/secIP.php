<?php
	class secIP
	{
	    private $protocol = "http://";
		private $local = "localhost";
		private $port = "80";
		private $file ="";

        public function getLocal()
        {
            return $this->protocol.$this->local;
        }
		public function getPort()
		{
			return $this->port;
		}
		public function getFile()
        {
		    return $this->file;
        }

        public function findUserIp()
        {
            $u_adress = "";
            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $u_adress = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $u_adress = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $u_adress = $_SERVER["REMOTE_ADDR"];
            }
            return $u_adress;
        }
	}
?>