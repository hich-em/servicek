<?php
	// definig SEO parameters
	// ...
	
	$r=array_slice(gf::news(), 0, 50);
	$rslt=array();
	foreach ($r as $e) {
		switch (get_class($e)) {
			case 'company':
				$rslt[]=array(
					"type"=>get_class($e),
					"title"=>$e->name,
					"sub_title"=>$e->slogan,
					"content"=>$e->description,
					"image_url"=>($e->logo ? $paths->company_logo->url.$e->logo : null),
					"url"=>url_root."/".$e->url
					);
				break;
			case 'job':
				$rslt[]=array(
					"type"=>get_class($e),
					"title"=>$e->name,
					"sub_title"=>"",
					"content"=>$e->description,
					"image_url"=>($e->image ? $paths->job_image->url.$e->image : null),
					"url"=>url_root."/job/".$e->id
					);
				break;
		}
	}

	// select and display right view
	// ...
	include "view_1.php";
?>
