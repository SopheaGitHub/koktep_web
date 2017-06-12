<?php
	$objLanguage = new App\Models\Language();
	$objInformation = new App\Models\Information();

	if(\Session::has('locale')) {
		$locale = \Session::get('locale');
	}else {
		$locale = 'en';
	}
	$language = $objLanguage->getLanguageByCode( $locale );
	$informations = [];
	if($language) {
		$informations = $objInformation->getInformations(['sort'=>'sort_order', 'order'=>'asc', 'language_id'=>$language->language_id])->get();
	}

?>
<div class="container">
	<div class="dropup">
		<ul class="nav nav-pills">
		  	<li role="presentation" class="dropdown">
			    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
			      
			      <?php
			      	if(\Session::get('locale')=='kh') { ?>
			      		<img style="margin-top:-3px;" src="<?php echo url('/images/flags/kh.png') ?>"> &nbsp; <?php echo trans('text.khmer'); ?>
			      	<?php }else { ?>
			      		<img style="margin-top:-3px;" src="<?php echo url('/images/flags/gb.png') ?>"> &nbsp; <?php echo trans('text.english'); ?>
			      	<?php }
			      ?>
			      
			      <span class="caret"></span>
			    </a>
			    <ul class="dropdown-menu dropup">
			    	<li><a href="<?php echo url('/language?locale=en'); ?>"><img style="margin-top:-3px;" src="<?php echo url('/images/flags/gb.png') ?>"> <?php echo trans('text.english'); ?></a></li>
			    	<li><a href="<?php echo url('/language?locale=kh'); ?>"><img style="margin-top:-3px;" src="<?php echo url('/images/flags/kh.png') ?>"> <?php echo trans('text.khmer'); ?></a></li>
			    </ul>
		  	</li>

		  	<?php
		  		if(count($informations) > 0) {
		  			foreach ($informations as $information) { ?>
		  				<li role="presentation" class="dropdown information">
						    <a href="#" role="button" data-toggle="information" data-id="<?php echo $information->information_id; ?>" data-languageid="<?php echo $language->language_id; ?>" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn <?php echo $information->icon; ?>"></i><?php echo $information->title; ?></a>
						</li>
		  		<?php	}
		  		}
		  	?>

		  	<li role="presentation" class="dropdown information">
			    <a href="<?php echo url('/contact-us'); ?>" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-phone"></i><?php echo trans('text.contact_us'); ?></a>
			</li>

			<li role="presentation" class="dropdown information">
			    <a href="<?php echo url('/send-feedback'); ?>" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-comment"></i><?php echo trans('text.send_feedback'); ?> </a>
			</li>

		</ul>
	</div>
</div>