<div class="modal-dialog modal-sm">
  <div class="modal-content" role="document">
    <div class="modal-header">
      <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
      <h5 class="modal-title"><i class="fa fa-btn fa-picture-o"></i><?php echo $data->title; ?></h5>
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

        input {
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
          <?php
            if($data->width < 100 || $data->height < 100 ) { ?>
              <div class="alert alert-warning" id="warning">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <i class="fa fa-btn fa-info-circle"></i><?php echo $data->error_size; ?><br />
              </div>
          <?php  }
          ?>
          <div class="image-editor">
            <a href="#" role="button" data-toggle="reselect-profile" data-dismiss="modal"><i class="fa fa-pencil fa-lg"></i></a>
            <!-- <input type="file" class="cropit-image-input"> -->
            <div style="padding-bottom: 10px; padding-left: 18px;">
              <div class="cropit-preview"></div>
            </div>
            <div class="image-size-label"></div>
            <div class="row">
              <span class="col-md-1" style="color:#eee;"><i class="fa fa-btn fa-picture-o"></i></span>
              <div class="col-md-9"><input type="range" class="cropit-image-zoom-input"></div>
              <span class="col-md-1" style="color:#eee; font-size:20px;"><i class="fa fa-btn fa-picture-o"></i></span>
            </div>
            <button type="button" class="btn btn-primary btn-xs rotate-ccw"><i class="fa fa-undo"></i></button>
            <button type="button" class="btn btn-primary btn-xs rotate-cw"><i class="fa fa-repeat"></i></button>
          </div>
        </div>
      </div>

      <form id="save-profile" action="<?php echo $data->action_save_profile; ?>" method="POST">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="original_image" value="<?php echo $data->image; ?>">
        <input type="hidden" id="image_profile" name="image_profile" value="">
      </form>

    </div>
    <div class="modal-footer" style="padding-top:2px;">
      <button type="botton" class="btn btn-primary btn-sm export" data-dismiss="modal"><i class="fa fa-btn fa-check"></i><?php echo $data->button_save; ?></button>
      <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i><?php echo $data->button_cancel; ?></button>
    </div>
  </div>
</div>
<script>
  $(function() {
    $('.image-editor').cropit({
      exportZoom: 1,
      imageBackground: true,
      imageBackgroundBorderWidth: 20,
      imageState: {
        src: '<?php echo $data->image2; ?>',
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