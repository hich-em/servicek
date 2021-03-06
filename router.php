<?php

	// preparing url
	$url=explode("/",reset(explode("?",strtolower(urldecode($_SERVER["REQUEST_URI"])))));
	array_shift($url);

	$reserved_urls=array(
		"",
		"about",
		"contact",
		"search",
		"login",
		"logout",
		"register",
		"account",
		"new",
		"job",
		"company",
		"product",
		"service",
		"post",
		"sitemap.xml",
	);

	// selecting page based on url
	switch($url[0]){

		case "":
			$req_page = "pages/home/controller.php";break;
		case "about":
			$req_page = "pages/about/controller.php";break;
		
		case "contact":
			$req_page = "pages/contact/controller.php";break;
		
        case "search":
			if(isset($url[1]) && $url[1]!="autocomplete") $_GET["q"]=$url[1];
			$req_page = "pages/search/controller.php";break;
        case "login":
			$req_page = "pages/login/controller.php";break;
        case "logout":
            session_destroy();
            $user=null;
            $logout=true;
			$req_page = "pages/home/controller.php";break;
        case "register":
			$req_page = "pages/register/controller.php";break;
        case "account":
        	if(isset($url[1]) && $url[1]=="set_user_attrib") $set_user_attrib=true;
			$req_page = "pages/account/controller.php";break;
		case "new":
			if(!isset($url[1])){
				$req_page="pages/404/controller.php";break;
			}else{
				switch ($url[1]) {
					case "company":
						$req_page = "pages/newcompany/controller.php";break;
					case "job":
						$req_page = "pages/newjob/controller.php";break;
					default:
						$req_page="pages/404/controller.php";break;
				}
				break;
			}
        case "job":
			if(isset($url[1])) $_GET["id"]=$url[1];
			if(isset($url[2]) && $url[2]=="publish") $req_page = "pages/publishjob/controller.php";
			else $req_page = "pages/job/controller.php";
			break;
        case "company":
			if(isset($url[1])) $_GET["id"]=$url[1];
			if(isset($url[2]) && $url[2]=="publish") $req_page = "pages/publishcompany/controller.php";
			else $req_page = "pages/company/controller.php";
			break;
        case "product":
			if(isset($url[1])) $_GET["id"]=$url[1];
			$req_page = "pages/product/controller.php";
			break;
        case "service":
			if(isset($url[1])) $_GET["id"]=$url[1];
			$req_page = "pages/service/controller.php";
			break;
        case "post":
			if(isset($url[1])) $_GET["id"]=$url[1];
			$req_page = "pages/post/controller.php";
			break;
        
        /*
		case "page_requires_parameters": // like http://loop.tn/post/123456789/897654321
			if(isset($url[1])) $_GET["param_1"]=$url[1];
			if(isset($url[2])) $_GET["param_2"]=$url[2];
			$req_page = "pages/page/controller.php";break;
        */
        
		case "sitemap.xml":
			die(include"seo/sitemap.php");break;

		default:
			$company = company::get_by_url($url[0]);
			if($company){
				$_GET["id"]=$company->id;
				if(isset($url[1]) && $url[1]=="publish") $req_page = "pages/publishcompany/controller.php";
				else $req_page = "pages/company/controller.php";
				break;
			} else $req_page="pages/404/controller.php";
			break;
	}

	// running selected page
	include (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest" ? $req_page : "master/controller.php");
?>
