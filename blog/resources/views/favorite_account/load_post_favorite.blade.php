<div class="modal-dialog">
  <div class="modal-content" role="document">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title"><i class="fa fa-btn fa-heart"></i>Favorite</h5>
    </div>
    <div class="modal-body">

      <div style="width: 100%; height: 350px; overflow-y: scroll;">
        
        <?php
          if(count($data->post_favorites) > 0) { ?>
            <?php 
                foreach ($data->post_favorites as $favorite) { ?>
                  <div class="row" style="margin: 0px;">
                    <div class="col-md-2" style="margin:0px; padding:5px;">
                      <div>
                        <a href="<?php echo $data->overview_account.'?account_id='.$favorite->user_id; ?>"><img style="background: #fff; border-radius: 50%; border: 5px solid #91beb1; width:80px;" alt="" src="<?php echo ((isset($data->thumb_user[$favorite->user_id]))? $data->thumb_user[$favorite->user_id]:''); ?>"></a>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div><a href="<?php echo $data->overview_account.'?account_id='.$favorite->user_id; ?>"><b><?php echo $favorite->user_name; ?></b></a></div>
                      <?php
                        $skills = explode(',', $favorite->user_skills);
                        foreach ($skills as $value) {
                          echo '<div style="color: #cccccc; font-size: 11px;">'.trim($value).'</div>';
                        }
                      ?>
                    </div>
                    <div class="col-md-4" style="margin-top:5px; margin-bottom: 5px;">
                      <div style="color: #cccccc; font-size: 11px;"><i class="fa fa-btn fa-calendar"></i>on <?php echo date('M dS, Y', strtotime($favorite->rating_date)); ?></div>
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