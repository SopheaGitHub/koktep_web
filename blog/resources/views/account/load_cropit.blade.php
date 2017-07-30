<style>
  .cropit-preview {
    background-color: #f8f8f8;
    background-size: cover;
    border: 5px solid #ccc;
    border-radius: 3px;
    margin-top: 7px;
    width: 100px;
    height: 100px;
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
<div class="container">
    <div class="row">
      <div class="col-md-2">
        <div class="image-editor">
          <input type="file" class="cropit-image-input">
          <div class="cropit-preview"></div>
          <div class="image-size-label">
            Resize image
          </div>
          <input type="range" class="cropit-image-zoom-input">
          <button class="rotate-ccw"><i class="fa fa-undo"></i></button>
          <button class="rotate-cw"><i class="fa fa-repeat"></i></button>

          <button class="export">Export</button>
        </div>
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
      var imageData = $('.image-editor').cropit('export');
      window.open(imageData);
    });
  });
</script>