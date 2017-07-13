<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" id="modal-unauthorized" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><i class="fa fa-btn fa-info-circle"></i><?php echo trans('auth.unauthorized'); ?></h5>
      </div>
      <div class="modal-body">
        <?php echo trans('auth.unauthorized_message'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i><?php echo trans('button.cancel'); ?></button>
        <a href="<?php echo url('/login'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-btn fa-check"></i><?php echo trans('button.continue_login'); ?></a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#modal-unauthorized').modal('show');
</script>