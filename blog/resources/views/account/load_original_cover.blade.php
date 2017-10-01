<div class="modal-dialog modal-lg">
  <div class="modal-content" role="document">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title"><i class="fa fa-btn fa-photo"></i>Cover photo of <?php echo $data->user_name; ?></h5>
    </div>
    <div class="modal-body">
      <img src="<?php echo $data->cover_user; ?>" style="width:100%;" alt="">
    </div>
  </div>
</div>