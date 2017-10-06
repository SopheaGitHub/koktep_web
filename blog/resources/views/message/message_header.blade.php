<div>
    <ul class="nav nav-pills" style="margin:0px; padding:0px;">
        <li role="presentation"><button type="button" data-trigger="compose-message" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i><?php echo trans('message.compose'); ?></button></li>
        <li role="presentation" class="enabled <?php echo (($data->load=='inbox')? 'active':'') ?>"><a href="<?php echo $data->action_url.'&amp;load=inbox'; ?>"><i class="fa fa-btn fa-inbox"></i><?php echo trans('message.inbox'); ?> <?php echo (($data->message_inbox->total>0)? '<span style="background: #91beb1; padding:0px 5px; border-radius:50%; font-size:12px; color: #fff;">'.$data->message_inbox->total.'</span>':''); ?></a></li>
        <li role="presentation" class="enabled <?php echo (($data->load=='sent')? 'active':'') ?>"><a href="<?php echo $data->action_url.'&amp;load=sent'; ?>"><i class="fa fa-btn fa-send"></i><?php echo trans('message.sent'); ?> </a></li>
        <!-- <li role="presentation" class="enabled"><a href="<?php // echo $data->action_url.'&amp;load=draft'; ?>"><i class="fa fa-btn fa-pencil-square-o"></i>Draft <?php // echo (($data->message_draft->total>0)? '<span style="background: #91beb1; padding:0px 5px; border-radius:50%; font-size:12px; color: #fff;">'.$data->message_draft->total.'</span>':''); ?></a></li>
        <li role="presentation" class="enabled"><a href="<?php // echo $data->action_url.'&amp;load=trash'; ?>"><i class="fa fa-btn fa-trash"></i>Trash</a></li> -->
    </ul>
</div>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).delegate('button[data-trigger=\'compose-message\']', 'click', function() {
      $('#modal-compose-message-form').remove();
      var information_id = $(this).data("id");
      var language_id = $(this).data("languageid");
      $.ajax({
        url: 'message/load-compose-message-form',
        dataType: 'html',
        beforeSend: function() {
          // before send
          $('#block-loader').show();
        },
        complete: function() {
          // completed
          $('#block-loader').hide();
        },
        success: function(html) {
          $('body').append('<div id="modal-compose-message-form" class="modal">' + html + '</div>');

          $('#modal-compose-message-form').modal('show');
        }
      });
      return false;
    });
  });
</script>