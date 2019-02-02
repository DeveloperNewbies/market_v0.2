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
		public function getFile(){
		    return $this->file;
        }
	}
?>