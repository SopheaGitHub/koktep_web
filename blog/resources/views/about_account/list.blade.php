<div class="row">
    <div class="col-md-6">
        <img class="thumbnail" src="<?php echo $data->thumb_first_cover; ?>" alt="" style="width:100%; border-radius:0px;">
    </div>
    <div class="col-md-6">
        <img class="thumbnail" src="<?php echo $data->thumb_second_cover; ?>" alt="" style="width:100%; border-radius:0px;">
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-12">
        <h4><b><?php echo $data->text_about; ?></b></h4>
        <p><?php echo $data->description; ?></p>
        <hr />
        
        <h4><b><?php echo $data->text_technical_skills; ?></b></h4>
        <!-- Progress bars / Skills -->
        <?php
        	if(count($data->user_technicals) > 0) {
        		foreach ($data->user_technicals as $technical) { ?>
        			<div class="row">
                        <div class="col-md-8"><b><?php echo $technical->skill; ?></b></div>
                        <div class="col-md-4">
                            <span class="pull-right" style="font-size:11px;">
                                Min Charge: <?php echo '$ '.$technical->min_charge; ?> , &nbsp;&nbsp; Max Charge: <?php echo '$ '.$technical->max_charge; ?>
                            </span>
                        </div>
                    </div>
			        <div class="progress">
			            <div class="progress-bar" style="width: <?php echo $technical->percent; ?>%;">
			                <?php echo $technical->percent; ?>
			            </div>
			        </div>
        	<?php	}
        	}
        ?>

        <hr />
        <?php echo $data->go_to_contact_account; ?>
    </div>
</div>