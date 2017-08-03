<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" href="#modal-upload-form" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title"><i class="fa fa-btn fa-image"></i> <?php echo $data['heading_title']; ?></h4>
      <ol class="breadcrumb" style="margin:0px; margin-top:10px; padding:0px; background: none;">
        <li data-toggle="tooltip" title="<?php echo $data['text_diractory_image']; ?>" ><i class="fa fa-btn fa-folder"></i></li>
        <?php
          if (count($data['diractories']) > 0) {
            foreach ($data['diractories'] as $diractory) { ?>
              <li><?php echo $diractory ?></li>
          <?php  }
          }
        ?>
      </ol>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-5"><a href="<?php echo $data['parent']; ?>" data-toggle="tooltip" title="<?php echo $data['button_parent']; ?>" id="button-parent" class="btn btn-default btntooltip"><i class="fa fa-arrow-left"></i></a> 
          <a href="<?php echo $data['refresh']; ?>" data-toggle="tooltip" title="<?php echo $data['button_refresh']; ?>" id="button-refresh" class="btn btn-default btntooltip"><i class="fa fa-refresh"></i></a>
          <button type="button" data-toggle="tooltip" title="<?php echo $data['button_upload']; ?>" id="button-upload" class="btn btn-primary btntooltip"><i class="fa fa-upload"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $data['button_folder']; ?>" id="button-folder" class="btn btn-default btntooltip"><i class="fa fa-folder"></i></button>
          <button type="button" data-toggle="tooltip" title="<?php echo $data['button_delete']; ?>" id="button-delete" class="btn btn-danger btntooltip"><i class="fa fa-trash-o"></i></button>
        </div>
        <div class="col-sm-7">
          <div class="input-group">
            <input type="text" name="search" value="<?php echo $data['filter_name']; ?>" placeholder="<?php echo $data['entry_search']; ?>" class="form-control">
            <span class="input-group-btn">
            <button type="button" data-toggle="tooltip" title="<?php echo $data['button_search']; ?>" id="button-search" class="btn btn-primary btntooltip"><i class="fa fa-search"></i></button>
            </span></div>
        </div>
      </div>
      <hr />
      <?php echo ((count($data['images'])<1)? $data['text_no_results']:''); ?>
      <?php foreach (array_chunk($data['images'], 6) as $image) { ?>
      <div class="row">
        <?php foreach ($image as $image) { ?>
        <div class="col-sm-2 text-center">
          <?php if ($image['type'] == 'directory') { ?>
          <div class="text-center"><a href="<?php echo $image['href']; ?>" class="directory" style="vertical-align: middle;"><i class="fa fa-folder fa-5x"></i></a></div>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
          <?php if ($image['type'] == 'image') { ?>
            <?php
              if($data['target']=='no-input') { ?>
                <div class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></div>
              <?php }else if($data['target']=='select-profile') { ?>
                <a href="#" role="button" data-toggle="choose-profile" data-image="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
              <?php }else if($data['target']=='select-cover') { ?>
                <a href="#" role="button" data-toggle="choose-cover" data-image="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
              <?php }else{ ?>
                <a href="<?php echo $image['href']; ?>" class="thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['name']; ?>" title="<?php echo $image['name']; ?>" /></a>
            <?php  } ?>
          <label>
            <input type="checkbox" name="path[]" value="<?php echo $image['path']; ?>" />
            <?php echo $image['name']; ?></label>
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <br />
      <?php } ?>
    </div>
    <div class="modal-footer"><?php echo $data['pagination']; ?></div>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>" />
  </div>
</div>
<script type="text/javascript"><!--
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
<?php if ($data['target']) { ?>
$('a.thumbnail').on('click', function(e) {
  e.preventDefault();

  <?php if ($data['thumb']) { ?>
  $('#<?php echo $data["thumb"]; ?>').find('img').attr('src', $(this).find('img').attr('src'));
  <?php } ?>

  $('#<?php echo $data["target"]; ?>').attr('value', $(this).parent().find('input').attr('value'));

  $('#modal-image').modal('hide');
});

<?php } else { ?>
// Get the current selection
var range = window.getSelection().getRangeAt(0);
var node = range.startContainer;
var startOffset = range.startOffset;  // where the range starts
var endOffset = range.endOffset;      // where the range ends

$('a.thumbnail').on('click', function(e) {
  e.preventDefault();

    // Create a new range from the orginal selection
    var range = document.createRange();
    range.setStart(node, startOffset);
    range.setEnd(node, endOffset);

    var img = document.createElement('img');
  img.src = $(this).attr('href');

  range.insertNode(img);

  $('#modal-image').modal('hide');
});
<?php } ?>

$('a.directory').on('click', function(e) {
  e.preventDefault();

  $('#modal-image').load($(this).attr('href'));
});

$('.pagination a').on('click', function(e) {
  e.preventDefault();

  $('#modal-image').load($(this).attr('href'));
});

$('#button-parent').on('click', function(e) {
  e.preventDefault();

  $('#modal-image').load($(this).attr('href'));
});

$('#button-refresh').on('click', function(e) {
  e.preventDefault();

  $('#modal-image').load($(this).attr('href'));
});

$('input[name=\'search\']').on('keydown', function(e) {
  if (e.which == 13) {
    $('#button-search').trigger('click');
  }
});

$('#button-search').on('click', function(e) {
  var url = "<?php echo url('/filemanager?_token="+CSRF_TOKEN+"&directory='.$data['directory']); ?>";

  var filter_name = $('input[name=\'search\']').val();

  if (filter_name) {
    url += '&filter_name=' + encodeURIComponent(filter_name);
  }

  <?php if ($data['thumb']) { ?>
  url += '&thumb=' + '<?php echo $data["thumb"]; ?>';
  <?php } ?>

  <?php if ($data['target']) { ?>
  url += '&target=' + '<?php echo $data["target"]; ?>';
  <?php } ?>

  $('#modal-image').load(url);
});
//--></script>
<script type="text/javascript"><!--
$('#button-upload').on('click', function() {
  $('#form-upload').remove();

  $('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" value="" /></form>');

  $('#form-upload input[name=\'file\']').trigger('click');

  if (typeof timer != 'undefined') {
      clearInterval(timer);
  }

  timer = setInterval(function() {
    if ($('#form-upload input[name=\'file\']').val() != '') {
      clearInterval(timer);

      $.ajax({
        url: "<?php echo url('/filemanager/upload?_token="+CSRF_TOKEN+"&directory='.$data['directory']); ?>",
        type: 'post',
        dataType: 'json',
        data: new FormData($('#form-upload')[0]),
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('#button-upload i').replaceWith('<i class="fa fa-circle-o-notch fast-spin"></i>');
          $('#button-upload').prop('disabled', true);
        },
        complete: function() {
          $('#button-upload i').replaceWith('<i class="fa fa-upload"></i>');
          $('#button-upload').prop('disabled', false);
        },
        success: function(json) {
          if (json['error']) {
            alert(json['error']);
          }

          if (json['success']) {
            alert(json['success']);

            $('#button-refresh').trigger('click');
          }
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      });
    }
  }, 500);
});

$('#button-folder').popover({
  html: true,
  placement: 'bottom',
  trigger: 'click',
  title: '<?php echo $data["entry_folder"]; ?>',
  content: function() {
    html  = '<div class="input-group">';
    html += '  <input type="text" name="folder" value="" placeholder="<?php echo $data["entry_folder"]; ?>" class="form-control">';
    html += '  <span class="input-group-btn"><button type="button" title="<?php echo $data["button_folder"]; ?>" id="button-create" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></span>';
    html += '</div>';

    return html;
  }
});

$('#button-folder').on('shown.bs.popover', function() {
  $('#button-create').on('click', function() {
    $.ajax({
      url: "<?php echo url('/filemanager/folder?_token="+CSRF_TOKEN+"&directory='.$data['directory']); ?>",
      type: 'post',
      dataType: 'json',
      data: 'folder=' + encodeURIComponent($('input[name=\'folder\']').val()),
      beforeSend: function() {
        $('#button-create i').replaceWith('<i class="fa fa-circle-o-notch fast-spin"></i>');
        $('#button-create').prop('disabled', true);
      },
      complete: function() {
        $('#button-create i').replaceWith('<i class="fa fa-plus-circle"></i>');
        $('#button-create').prop('disabled', false);
      },
      success: function(json) {
        if (json['error']) {
          alert(json['error']);
        }

        if (json['success']) {
          alert(json['success']);

          $('#button-refresh').trigger('click');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  });
});

$('#modal-image #button-delete').on('click', function(e) {
  if (confirm('<?php echo $data["text_confirm"]; ?>')) {
    $.ajax({
      url: "<?php echo url('/filemanager/delete?_token="+CSRF_TOKEN+"'); ?>",
      type: 'post',
      dataType: 'json',
      data: $('input[name^=\'path\']:checked'),
      beforeSend: function() {
        $('#button-delete i').replaceWith('<i class="fa fa-circle-o-notch fast-spin"></i>');
        $('#button-delete').prop('disabled', true);
      },
      complete: function() {
        $('#button-delete i').replaceWith('<i class="fa fa-trash-o"></i>');
        $('#button-delete').prop('disabled', false);
      },
      success: function(json) {
        if (json['error']) {
          alert(json['error']);
        }

        if (json['success']) {
          alert(json['success']);

          $('#button-refresh').trigger('click');
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    });
  }
});
//--></script>
<script type="text/javascript">
$(document).on('click', '.btntooltip', function() {
  $(this).tooltip('hide');
});

</script>