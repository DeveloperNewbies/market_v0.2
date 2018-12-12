<?php
	class secIP
	{
		private $local = "shop.ay-soft.com";
		private $port = "80";
		private $file ="";
		
		public function getLocal()
		{
			return $this->local;
		}
		public function getPort()
		{
			return $this->port;
		}
		public function getFile(){
		    return $this->file;
        }
	}
?>