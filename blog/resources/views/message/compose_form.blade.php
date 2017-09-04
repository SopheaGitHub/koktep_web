<div class="modal-dialog modal-sm">
  <div class="modal-content" style="-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border:1px solid #ddd;">
    <div class="modal-header">
      <h4 style="margin:0px; padding:0px;"><i class="fa fa-btn fa-envelope"></i><?php echo $data->text_message; ?></h4>
    </div>
    <div class="modal-body">
      <p id="popup-compose-message"></p>
      <form role="form" class="form-horizontal" enctype="multipart/form-data" id="popup-form-compose-message">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="parent_id" value="<?php echo $data->message_parent_id; ?>">
        <input type="hidden" name="receiver_id" id="receiver_id" value="">
        <div class="form-group">
          <label class="col-sm-12" for="inputTo"><?php echo $data->text_receiver; ?></label>
          <div class="col-sm-12"><input type="text" name="search" class="form-control" placeholder="<?php echo $data->text_receiver; ?>"></div>
          <div class="col-sm-12" id="display-user">
            <!-- <img style="width:30px; margin-top:5px; border-radius:50%;" src="<?php // echo $data->receiver_image; ?>"> &nbsp; <span style="font-size: 12px;"><?php // echo $data->receiver_name; ?></span> -->
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-12" for="inputSubject"><?php echo $data->text_subject; ?> <span style="color:red;">*</span></label>
          <div class="col-sm-12"><input type="text" name="subject" class="form-control" placeholder="<?php echo $data->text_subject; ?>"></div>
        </div>
        <div class="form-group">
          <label class="col-sm-12" for="inputBody"><?php echo $data->text_message; ?> <span style="color:red;">*</span></label>
          <div class="col-sm-12">
            <textarea name="message" class="form-control" placeholder="<?php echo $data->text_message; ?>" style="min-height:150px; max-height:150px; min-width: 100%; max-width: 100%;"></textarea>
          </div>
        </div>
      </form>
    </div>
    <div class="modal-footer" style="text-align:center;">
      <button type="button" data-toggle="tooltip" id="popup-send-message" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-send"></i><?php echo $data->button_send; ?></button>
      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i><?php echo $data->button_close; ?></button>     
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	
	requestSubmitForm5('popup-send-message', 'popup-form-compose-message', "<?php echo $data->action_send; ?>", "popup-compose-message");
  	// Related
	$('input[name=\'search\']').autocomplete({
      'source': function(request, response) {
        $.ajax({
          url: "<?php echo url('/post-account/compose-autocomplete');?>?filter_title=" +  encodeURIComponent(request),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item['title'],
                value: item['user_id']
              }
            }));
          }
        });
      },
      'select': function(item) {
      	$('#display-user').html(item['label']).show();
      	$('#receiver_id').val(item['value']);
        return false;
      }
    });

});
</script>