@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12"><h4><i class="fa fa-btn fa-cogs"></i><?php echo $data->text_title; ?></h4></div>
                </div>
                <p id="message"></p>
                <div id="load-form">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
loadingForm("<?php echo $data->action_form; ?>");
$(document).ready(function() {
  requestSubmitForm3('submit-setting-information', 'form-setting-information', "<?php echo $data->action_setting_information; ?>", "message-setting-information");
  requestSubmitForm3('submit-setting-contact', 'form-setting-contact', "<?php echo $data->action_setting_contact; ?>", "message-setting-contact");
  requestSubmitForm3('submit-setting-technical-skills', 'form-setting-technical-skills', "<?php echo $data->action_setting_technical_skills; ?>", "message-setting-technical-skills");
  requestSubmitForm3('submit-setting-watermark', 'form-setting-watermark', "<?php echo $data->action_setting_watermark; ?>", "message-setting-watermark");
});
</script>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Image Manager
        $(document).delegate('a[data-toggle=\'select-watermark\']', 'click', function() {
            $('#modal-image').remove();
            $.ajax({
                url: 'filemanager?target=select-watermark',
                dataType: 'html',
                beforeSend: function() {
                    $('#block-loader').show();
                },
                complete: function() {
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });
            return false;
        });

        $(document).delegate('a[data-toggle=\'choose-watermark\']', 'click', function() {
      
            $('#modal-image').remove();
              var image = $(this).data("image");
              $.ajax({
                url: 'account/crop-watermark?image='+encodeURIComponent(image),
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
                    $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });
            return false;
        });

        $(document).delegate('a[data-toggle=\'reselect-watermark\']', 'click', function() {
            $('#modal-image').remove();
                $.ajax({
                    url: 'filemanager?target=select-watermark',
                    dataType: 'html',
                    beforeSend: function() {
                        $('#block-loader').show();
                    },
                    complete: function() {
                        $('#block-loader').hide();
                    },
                    success: function(html) {
                        $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                        $('#modal-image').modal('show');
                    }
              });
              return false;
        });

    });
</script>
@endsection