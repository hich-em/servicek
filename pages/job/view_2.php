<link rel="stylesheet" type="text/css" href="<?php echo cdn;?>/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable<?php echo(rtl?"-rtl":"");?><?php if(!debug) echo ".min";?>.css"/>
<link href="<?php echo cdn;?>/plugins/bootstrap-fileinput/bootstrap-fileinput<?php if(!debug) echo ".min";?>.css" rel="stylesheet" type="text/css"/>

<link href="<?php echo url_root;?>/pages/job/style<?php if(!debug) echo ".min";?>.css" rel="stylesheet" type="text/css">

<?php
	if(!$is_contracted){
		$lc=$job->last_contract;
		if($lc &&$lc->type==0){
?>
<div class="row">
	<div class="col-md-12">
		<div class="note note-danger">
			<h4 class="block">La période d'essai a expiré</h4>
			<p>
				 Ce travail n'est plus disponible au public, vous seul vous pouvez y accéder.<br>
				 <a class="btn green ajaxify" href="<?php echo url_root."/".$job->url;?>/publish"><i class="icon-rocket"></i> Publier maintenant</a>
			</p>
		</div>
	</div>
</div>
<?php }else{?>
<div class="row">
	<div class="col-md-12">
		<div class="note note-danger">
			<h4 class="block">Ce travail n'est pas publiée</h4>
			<p>
				 Ce travail n'est plus disponible au public, vous seul vous pouvez y accéder.<br>
				 <a class="btn green ajaxify" href="<?php echo url_root."/".$job->url;?>/publish"><i class="icon-rocket"></i> Publier maintenant</a>
			</p>
		</div>
	</div>
</div>
<?php }}else{
	$cc=$job->current_contract;
	$rd = $cc->remaining_days;
	if($cc->type==0){
		if($rd>10){
?>
<div class="row">
	<div class="col-md-12">
		<div class="note note-warning">
			<h4 class="block">Ce travail est en période d'essai gratuit</h4>
			<p>
				 Vous pouvez essayer toutes les fonctionnalités pendant 1 mois à partir de la date de création du travail,<br>
				 <span class="text-danger">Au bout de <?php echo $rd;?> jours, ce travail ne sera plus disponible au public.</span><br>
				 Afin d'assurer la disponibilité du travail, créez un contrat de publication avant la fin de la période d'essai.<br><br>
				 <a class="btn green ajaxify" href="<?php echo url_root."/".$job->url;?>/publish"><i class="icon-rocket"></i> Créer un contrat de publication</a><br>
				 <span class="text-success">La date de début contrat de publication sera initialisée à la date fin de la période d'essai.</span>
			</p>
		</div>
	</div>
</div>
<?php }else{?>
<div class="row">
	<div class="col-md-12">
		<div class="note note-danger">
			<h4 class="block">La période d'essai est presque finit</h4>
			<p>
				 <span class="text-danger">Au bout de <?php echo $rd;?> jours, ce travail ne sera plus disponible au public.</span><br>
				 Afin d'assurer la disponibilité du travail, créez un contrat de publication avant la fin de la période d'essai.<br><br>
				 <a class="btn green ajaxify" href="<?php echo url_root."/".$job->url;?>/publish"><i class="icon-rocket"></i> Créer un contrat de publication</a><br>
				 <span class="text-success">La date de début contrat de publication sera initialisée à la date fin de la période d'essai.</span>
			</p>
		</div>
	</div>
</div>
<?php }}elseif($rd<=10){?>
<div class="row">
	<div class="col-md-12">
		<div class="note note-danger">
			<h4 class="block">Le contrat de publication expirera bienôt</h4>
			<p>
				 <span class="text-danger">Au bout de <?php echo $rd;?> jours, ce travail ne sera plus disponible au public.</span><br><br>
				 <a class="btn green ajaxify" href="<?php echo url_root."/".$job->url;?>/publish"><i class="icon-rocket"></i> Renouveler le contrat</a><br>
				 <span class="text-success">La date de début du nouveau contrat de publication sera initialisée à la date fin du contrat existant.</span>
			</p>
		</div>
	</div>
</div>
<?php }}?>
<div class="row">
	<div class="profile-sidebar col-md-3">
		<div class="portlet light profile-sidebar-portlet">
			
			<div class="image fileinput col-sm-offset-3 col-sm-6 col-md-offset-0 col-md-12 fileinput-new" data-provides="fileinput">
				<a class="fileinput-preview thumbnail" data-trigger="fileinput">
					<img src="<?php $image=$job->image; if($image) echo $paths->job_image->url.$image; else {?>http://www.placehold.it/400x300/EFEFEF/AAAAAA&amp;text=Sélectionner+une+image<?php }?>" alt="image"/>
				</a>
				<form class="hide"><input type="file" name="image"></form>
			</div>
			
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">
					 <a href="javascript:;" class="editable" data-name="name" data-type="text" ><?php echo $job->name;?></a>
				</div>
			</div>
		</div>

		<div class="portlet light">
			<h5>A propos :</h5>
			<a href="javascript:;" class="editable" data-name="description" data-type="textarea" ><?php echo $job->description;?></a>
		<hr>
			<h5>Domaines d'activité :</h5>
			<?php if($is_contracted && !$is_trial){?>
				<?php echo $categories;?>
			<?php }else{?>
				<a class="categories-editable" data-name="categories" data-type="select2" data-value='<?php echo json_encode($categories_json);?>' data-available='<?php echo json_encode($available_categories);?>'></a>
			<?php }?>
		</div>

	</div>
	<div class="profile-content col-md-9">
		<div class="row">
			<div class="col-md-6">
				<div class="portlet light">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-globe theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">Contact</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1_1">
								<p class="margin-bottom-30">
									<strong><h5>Adresse :</h5></strong>
									<a href="javascript:;" class="" data-name="address" data-type="textarea" ><?php echo $job->address;?></a>
								</p>
								<p class="margin-bottom-30">
									<strong><h5>Téléphone :</h5></strong>
									<a href="javascript:;" class="editable" data-name="tel" data-type="text" ><?php echo $job->tel;?></a>
								</p>
								<p class="margin-bottom-30">
									<strong><h5>Portable :</h5></strong>
									<a href="javascript:;" class="editable" data-name="mobile" data-type="text" ><?php echo $job->mobile;?></a>
								</p>
								<p class="margin-bottom-30">
									<strong><h5>Email :</h5></strong>
									<a href="javascript:;" class="editable" data-name="email" data-type="text" ><?php echo $job->email;?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="portlet light">
					<div class="portlet-title tabbable-line">
						<div class="caption caption-md">
							<i class="icon-globe theme-font hide"></i>
							<span class="caption-subject font-blue-madison bold uppercase">Map</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="tab-content aspectratio-container aspect-4-3 fit-width">
							<div class="map-canvas aspectratio-content" data-longitude="<?php echo $geolocation->longitude;?>" data-latitude="<?php echo $geolocation->latitude;?>"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- custom page script -->
<script src="<?php echo url_root;?>/pages/job/script_2<?php if(!debug) echo ".min";?>.js" type="text/javascript"></script>

