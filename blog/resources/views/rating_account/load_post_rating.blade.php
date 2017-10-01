
<div class="modal-dialog">
  <div class="modal-content" role="document">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title"><i class="fa fa-btn fa-star"></i>Rating</h5>
    </div>
    <div class="modal-body">

      <div style="width: 100%; height: 350px; overflow-y: scroll;">
        
        <?php
          if(count($data->post_ratings) > 0) { ?>
            <?php 
                foreach ($data->post_ratings as $rating) { ?>
                  <div class="row" style="margin: 0px;">
                    <div class="col-md-2" style="margin:0px; padding:5px;">
                      <div>
                        <a href="<?php echo $data->overview_account.'?account_id='.$rating->user_id; ?>"><img style="background: #fff; border-radius: 50%; border: 5px solid #91beb1; width:80px;" alt="" src="<?php echo ((isset($data->thumb_user[$rating->user_id]))? $data->thumb_user[$rating->user_id]:''); ?>"></a>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div><a href="<?php echo $data->overview_account.'?account_id='.$rating->user_id; ?>"><b><?php echo $rating->user_name; ?></b></a></div>
                      <?php
                        $skills = explode(',', $rating->user_skills);
                        foreach ($skills as $value) {
                          echo '<div style="color: #cccccc; font-size: 11px;">'.trim($value).'</div>';
                        }
                      ?>
                    </div>
                    <div class="col-md-4" style="margin-top:5px; margin-bottom: 5px;">
                      <div style="color: #cccccc; font-size: 11px;"><i class="fa fa-btn fa-calendar"></i>on <?php echo date('M dS, Y', strtotime($rating->rating_date)); ?></div>
                      <br />
                      <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <?php if ($rating->star < $i) { ?>
                            <?php
                              if(($rating->star+0.5)==$i) { ?>
                                <span class="fa fa-stack" style="color: #91beb1;"><i class="fa fa-star-half-o fa-stack-2x"></i></span>
                              <?php }else { ?>
                                <span class="fa fa-stack" style="color: #999;"><i class="fa fa-star-o fa-stack-2x"></i></span>
                              <?php }
                            ?>
                        <?php } else { ?>
                        <span class="fa fa-stack" style="color: #91beb1;"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                        <?php } ?>
                      <?php } ?>
                    </div>
                  </div>
                <?php } ?>
          <?php }else { ?>
              <!-- no user rating -->
          <?php } ?>

      </div>

    </div>
  </div>
</div>