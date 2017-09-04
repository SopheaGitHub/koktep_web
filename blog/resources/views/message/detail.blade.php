@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content" style="overflow:hidden;">
               <div style="text-align:center; background: #91beb1; color: #fff; padding: 5px 0px;">
                  <h3><?php echo $data->text_detail; ?></h3>
               </div>
               <br />
               <div class="row">
                  <div class="col-md-6">
                     <a href="<?php echo $data->action_back; ?>" class="btn btn-default btn-xs"><i class="fa fa-btn fa-angle-double-left"></i><?php echo $data->button_back; ?></a>
                  </div>
                  <div class="col-md-6">
                     <span class="pull-right">
                        <button type="button" data-trigger="reply-message" class="btn btn-xs btn-primary button-submit-post" data-original-title=""><i class="fa fa-btn fa-reply"></i><?php echo $data->button_reply; ?></button>
                     </span>
                  </div>
               </div>
               <div id="load-sub-message">

               </div>
               <hr />
               <div>
                  <p style="font-size: 11px;">
                    <i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y', strtotime($data->message->created_at)); ?>
                  </p>
                  <div>
                     <img style="width:30px; margin-top:5px; border-radius:50%;" src="<?php echo $data->thumb_author; ?>"> &nbsp; <span style="font-size: 12px;"><?php echo $data->message->author_name; ?></span>
                  </div>
                  <br />
                  <?php
                    $subject = mb_substr(strip_tags(html_entity_decode($data->message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($data->message->subject)>100)? '...':'');
                    $text = mb_substr(strip_tags(html_entity_decode($data->message->text, ENT_QUOTES, 'UTF-8')), 0, 225).((mb_strlen($data->message->text)>225)? '...':'');
                  ?>
                  <div><b><?php echo $subject; ?></b></div>
                  <p><?php echo $text; ?></p>

               </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function() {

    loadingFormToID("<?php echo $data->action_load_sub_message; ?>", "load-sub-message");

    $(document).delegate('button[data-trigger=\'reply-message\']', 'click', function() {
      $('#modal-message-reply-form').remove();
      var information_id = $(this).data("id");
      var language_id = $(this).data("languageid");
      $.ajax({
        url: "<?php echo $data->action_reply; ?>",
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
          $('body').append('<div id="modal-message-reply-form" class="modal">' + html + '</div>');

          $('#modal-message-reply-form').modal('show');
        }
      });
      return false;
    });
  });
</script>
@endsection