<div class="row">
	<?php
		if(count($data->users_favorite_author) > 0) {
			foreach ($data->users_favorite_author as $favorite) { ?>
				<div class="col-md-6 user-favorite-list-box">
					<div class="row user-favorite-list-box-row">
						<div class="col-md-3" style="margin:0px; padding:5px;">
							<div>
			              		<a href="<?php echo $data->overview_account.'?account_id='.$favorite->profile_id; ?>">
			              			<img class="author-favorite-image" alt="" src="<?php echo ((isset($data->thumb_user[$favorite->profile_id]))? $data->thumb_user[$favorite->profile_id]:''); ?>">
			              		</a>
			          		</div>
						</div>
						<div class="col-md-5">
							<div><a href="<?php echo $data->overview_account.'?account_id='.$favorite->profile_id; ?>"><b><?php echo $favorite->user_name; ?></b></a></div>
							<?php
		                        $skills = explode(',', $favorite->user_skills);
		                        foreach ($skills as $value) {
		                          echo '<div style="color: #cccccc; font-size: 11px;">'.trim($value).'</div>';
		                        }
		                    ?>
						</div>
						<div class="col-md-4" class="box-profile-favorite">
							<?php
								if($favorite->table_note=='u') {
									echo '<b style="color: #91beb1;">(You)</b>';
								}else if ($favorite->table_note=='u_f') { ?>
									<div class="btn-group">
					                  	<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #91beb1;">
					                    	<i class="fa fa-btn fa-heart"></i> <?php echo trans('text.favorited'); ?> <span class="caret"></span>
					                  	</button>
					                  	<ul class="dropdown-menu">
					                    	<li><a href="<?php echo url('/account/unfavorite?favorite_of_id='.$favorite->profile_id); ?>"><?php echo trans('text.unfavorite_this_profile'); ?></a></li>
					                  	</ul>
					                </div>
							<?php } else { ?>
								<!-- table_note = 'n_u_f' -->
								<div id="show-button-favorite"><a href="<?php echo url('/account/favorite?favorite_of_id='.$favorite->profile_id); ?>" type="button" data-trigger="favorite" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-heart"></i> <?php echo trans('text.favorite'); ?>&nbsp;</a></div>
							<?php } ?>
							
						</div>
					</div>
				</div>
		<?php	}
		} else { ?>

	<?php } ?>
</div>