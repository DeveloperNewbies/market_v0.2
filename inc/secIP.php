<?php
	class secIP
	{
	    private $protocol = "https://";
		private $local = "optimumilac.com";
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