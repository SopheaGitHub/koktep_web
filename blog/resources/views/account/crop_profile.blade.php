<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header">
      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
      <h4 class="modal-title"><i class="fa fa-btn "></i><?php echo $data->title; ?></h4>
    </div>
    <div class="modal-body">

      <style>
        .cropit-preview {
          background-color: #f8f8f8;
          background-size: cover;
          border: 5px solid #ccc;
          border-radius: 3px;
          margin-top: 7px;
          width: 110px;
          height: 110px;
          border-radius: 50%;
        }

        .cropit-preview-image-container {
          cursor: move;
          border-radius: 50%;
        }

        .cropit-preview-background {
          opacity: .2;
          cursor: auto;
        }

        .image-size-label {
          margin-top: 10px;
        }

        input, .export {
          /* Use relative position to prevent from being covered by image background */
          position: relative;
          z-index: 10;
          display: block;
        }

        button {
          margin-top: 10px;
        }
      </style>

      <div class="row">
        <div class="col-md-12">
          <div class="image-editor">
            <button type="button" class="btn btn-default btn-sm" data-toggle="reselect-profile" data-dismiss="modal"><i class="fa fa-pencil fa-lg"></i></button>
            <!-- <input type="file" class="cropit-image-input"> -->
            <div style="padding-bottom: 10px; padding-left: 18px;">
              <div class="cropit-preview"></div>
            </div>
            <div class="image-size-label">
              Resize image
            </div>
            <input type="range" class="cropit-image-zoom-input">
            <button class="rotate-ccw"><i class="fa fa-undo"></i></button>
            <button class="rotate-cw"><i class="fa fa-repeat"></i></button>
          </div>
        </div>
      </div>

      <form id="save-profile" action="<?php echo $data->action_save_profile; ?>" method="GET">
        <input type="hidden" name="original_image" value="<?php echo $data->image; ?>">
        <input type="hidden" id="image_profile" name="image_profile" value="">
      </form>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm" data-toggle="cancel-profile" data-dismiss="modal"><i class="fa fa-btn fa-close"></i>Cancel</button>
      <button type="botton" class="btn btn-primary btn-sm export" data-dismiss="modal"><i class="fa fa-btn fa-check"></i>Save</button>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
      // Load Image Manager
      $(document).delegate('button[data-toggle=\'cancel-profile\']', 'click', function() {
        $('#modal-image').remove();
      });

  });
  $(document).ready(function() {
      // Load Image Manager
      $(document).delegate('button[data-toggle=\'reselect-profile\']', 'click', function() {
          $('#modal-image').remove();
          $.ajax({
              url: 'filemanager?target=select-profile',
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
<script type="text/javascript" src="<?php echo asset('/javascript/cropit/dist/jquery.cropit.js'); ?>"></script>
<script>
  $(function() {
    $('.image-editor').cropit({
      exportZoom: 1,
      imageBackground: true,
      imageBackgroundBorderWidth: 20,
      imageState: {
        src: '<?php echo $data->image; ?>',
      },
    });

    $('.rotate-cw').click(function() {
      $('.image-editor').cropit('rotateCW');
    });
    $('.rotate-ccw').click(function() {
      $('.image-editor').cropit('rotateCCW');
    });

    $('.export').click(function() {
      var imageData = $('.image-editor').cropit('export', {
        type: 'image/jpeg',
      });
      // window.open(imageData);
      $('#image_profile').val(imageData);
      $('#save-profile').submit();
    });
  });
</script>