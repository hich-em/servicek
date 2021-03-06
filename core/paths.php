<?php
	class paths{

		private $content_files_paths = array(
			"category_icon"=>"/content/category/icon/",
			"company_logo"=>"/content/company/logo/",
			"company_cover"=>"/content/company/cover/",
			"job_image"=>"/content/job/image/",
			"offer_image"=>"/content/offer/image/",
			"product_image"=>"/content/product/image/",
			"service_image"=>"/content/service/image/"
		);

		public function __get($name){
            if(!array_key_exists($name, $this->content_files_paths)) return null;
            return new path($this->content_files_paths[$name]);
        }
	}

	class path{
		private $path;

		public function __construct($path){
            $this->path = $path;
        }

		public function __get($name){
			switch ($name) {
				case 'dir':
					return dirname(__DIR__).$this->path;
					break;
				case 'url':
					return url_root.$this->path;
					break;
				
				default:
					return null;
					break;
			}
        }	
	}

?>