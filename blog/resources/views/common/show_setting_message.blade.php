<?php
	$objUser = new App\User();
	$author_id = ((\Request::has('account_id'))? \Request::get('account_id'):'0');
    $author_logged_id = ((\Auth::check())? \Auth::user()->id:'0');
    $user_completed = $objUser->checkIfUserCompleted($author_id);

    if(\Session::has('locale')) {
        $locale = \Session::get('locale');
    }else {
        $locale = 'en';
    }
?>
<?php
	if($author_logged_id==$author_id) {
		if( ($user_completed->total_description <= 0) || ($user_completed->total_address <= 0) || ($user_completed->total_technical <= 0) ) { ?>
			<div class="row" style="padding: 0 18px;">
			    <div class="col-md-12">
			        <div class="alert alert-success" id="success">
			            <button type="button" class="close" data-dismiss="alert">&times;</button>
			            <?php
			            	if($locale=='kh') { ?>
			            	<i class="fa fa-info-circle fa-btn"></i>ដើម្បីធ្វើឱ្យងាយស្រួលសម្រាប់អតិថិជនរបស់អ្នកក្នុងការស្វែងរកអ្នក! សូមបំពេញ 
			            	<a href="<?php echo url('/account/settings?account_id='.$author_id); ?>"><b>ការកំណត់</b></a> គណនីរបស់អ្នកទៅលើពត៌មានដូចជា៖
							<?php
								if($user_completed->total_description <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=information'); ?>"><b>ពិពណ៌នាគណនី</b></a>&nbsp;
							<?php }
							?>
							<?php
								if($user_completed->total_technical <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=skill'); ?>"><b>ជំនាញ</b></a> &nbsp; 
							<?php }
							?>
							<?php
								if($user_completed->total_address <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=contact'); ?>"><b>ព័ត៌មានទំនាក់ទំនង</b></a>.
			            	<?php }
							?>
			            <?php }else { ?>
			            	<i class="fa fa-info-circle fa-btn"></i>To make it easy for your customers to find you! Please complete your account <a href="<?php echo url('/account/settings?account_id='.$author_id); ?>"><b>Settings</b></a> of the following information:
							<?php
								if($user_completed->total_description <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=information'); ?>"><b>Account Description</b></a> &nbsp; 
							<?php }
							?>
							<?php
								if($user_completed->total_technical <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=skill'); ?>"><b>Skill</b></a> &nbsp; 
							<?php }
							?>
							<?php
								if($user_completed->total_address <= 0) { ?>
								<a href="<?php echo url('/account/settings?account_id='.$author_id.'&tab=contact'); ?>"><b>Contact Information</b></a>.
			            	<?php }
							?>
			            <?php }
			            ?>
			        </div>
			    </div>
			</div>
		<?php } 
	}
?>
