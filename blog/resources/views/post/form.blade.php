<div class="modal-dialog modal-lg">
  <div class="modal-content" style="-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border:1px solid #ddd;">
    <div class="modal-header">
      <div class="row">
        <div class="col-md-6"><h4 class="modal-title"><b><i class="fa fa-btn <?php echo (($data->icon=='icon_create')? 'fa-upload':'fa-pencil-square'); ?>"></i><?php echo $data->titlelist; ?></b></h4></div>
        <div class="col-md-6">
            <span class="pull-right">
              <?php
                if($data->request_from=='popup') { ?>
                  <button type="button" id="popup-submit-post" data-toggle="tooltip" title="" class="btn btn-sm btn-primary button-submit-post"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save; ?></button>
                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i><?php echo $data->button_close; ?></button>
              <?php  }else { ?>
                  <button type="button" id="submit-post" data-toggle="tooltip" title="" class="btn btn-sm btn-primary button-submit-post"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save; ?></button>
                  <a href="<?php echo $data->go_back.'?account_id='.$data->auth_id; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-angle-double-left"></i> <?php echo $data->button_back; ?></a>
              <?php  }
              ?>
            </span>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <p id="<?php echo (($data->request_from=='popup')? 'popup-message':'message'); ?>"></p>
      <form action="#" method="post" enctype="multipart/form-data" id="<?php echo (($data->request_from=='popup')? 'popup-form-post':'form-post'); ?>">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="row">
          <div class="col-md-6">

            <div class="table-responsive">
              <table id="images" class="table">
                <thead>
                  <tr>
                    <td class="text-left" style="font-weight: 700;"><?php echo $data->entry_image; ?></td>
                    <td class="text-left" style="font-weight: 700;"><span data-toggle="tooltip" title="" data-original-title="<?php echo $data->title_watermark; ?>"><?php echo $data->entry_watermark; ?></span></td>
                    <td></td>
                  </tr>
                </thead>
                <tbody>
                  <?php $image_row = 0; ?>
                  <tr id="image-row<?php echo $image_row; ?>">
                    <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->thumb; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a><input type="hidden" name="post_image[<?php echo $image_row; ?>][image]" value="<?php echo $data->image; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                    <td class="text-left"><input type="checkbox" name="post_image[<?php echo $image_row; ?>][watermark]" value="1" <?php echo (($data->watermark_status=='1')? 'checked="checked"':'' ); ?>/></td>
                    <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle fa-btn"></i><?php echo $data->button_remove; ?></button></td>
                  </tr>
                  <?php $image_row++; ?>
                  <?php foreach ($data->post_images as $post_image) { ?>
                  <tr id="image-row<?php echo $image_row; ?>">
                    <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $post_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a><input type="hidden" name="post_image[<?php echo $image_row; ?>][image]" value="<?php echo $post_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                    <td class="text-left"><input type="checkbox" name="post_image[<?php echo $image_row; ?>][watermark]" value="1" <?php echo (($post_image['watermark_status']=='1')? 'checked="checked"':''); ?> /></td>
                    <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" class="btn btn-danger btn-xs"><i class="fa fa-minus-circle fa-btn"></i><?php echo $data->button_remove; ?></button></td>
                  </tr>
                  <?php $image_row++; ?>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
                    <td class="text-left"><button type="button" onclick="addImage();" class="btn btn-primary btn-xs"><i class="fa fa-plus-circle fa-btn"></i><?php echo $data->button_image_add; ?></button></td>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
          <div class="col-md-6">

            <?php foreach ($data->languages as $language) { ?>
              <div class="form-group required">
                <label for="input-title<?php echo $language->language_id; ?>"><?php echo $data->entry_title; ?></label>
                <input type="text" name="post_description[<?php echo $language->language_id; ?>][title]" value="<?php echo $data->post_description[$language->language_id]['title']; ?>" placeholder="<?php echo $data->entry_title; ?>" id="input-title<?php echo $language->language_id; ?>" class="form-control" />
              </div>
              <div class="form-group required">
                <label for="input-description<?php echo $language->language_id; ?>"><?php echo $data->entry_description; ?></label>
                <textarea name="post_description[<?php echo $language->language_id; ?>][description]" placeholder="<?php echo $data->entry_description; ?>" id="input-description<?php echo $language->language_id; ?>" class="text_summernote form-control"><?php echo $data->post_description[$language->language_id]['description']; ?></textarea>
              </div>
              <div class="form-group">
                <label for="input-tag<?php echo $language->language_id; ?>"><span data-toggle="tooltip" title="<?php echo $data->title_tags; ?>"><?php echo $data->entry_tag; ?></span></label>
                <input type="text" name="post_description[<?php echo $language->language_id; ?>][tag]" value="<?php echo $data->post_description[$language->language_id]['tag']; ?>" placeholder="<?php echo $data->entry_tag; ?>" id="input-tag<?php echo $language->language_id; ?>" class="form-control" />
              </div>
            <?php } ?>

            <div class="form-group">
              <label for="status"><?php echo $data->entry_enabled; ?></label><br />
              <input type="checkbox" name="status" id="status" value="1" <?php echo (($data->post_status=='1')? 'checked="checked"':''); ?> />
            </div>

            <div class="form-group">
              <label for="input-category"><span data-toggle="tooltip" title="" data-original-title="<?php echo $data->title_category; ?>"><?php echo $data->entry_category; ?></span></label>
              <input type="text" name="category" value="" placeholder="<?php echo $data->entry_category; ?>" id="input-category" class="form-control" />
              <div id="post-category" class="well well-sm" style="height: 80px; overflow: auto;">
                <?php foreach ($data->post_categories as $post_category) { ?>
                <div id="post-category<?php echo $post_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $post_category['name']; ?>
                  <input type="hidden" name="post_category[]" value="<?php echo $post_category['category_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <label for="input-related"><span data-toggle="tooltip" title="" data-original-title="<?php echo $data->title_related; ?>"><?php echo $data->entry_related; ?></span></label>
              <input type="text" name="related" value="" placeholder="<?php echo $data->entry_related; ?>" id="input-related" class="form-control" />
              <div id="post-related" class="well well-sm" style="height: 80px; overflow: auto;">
                <?php foreach ($data->post_relateds as $post_related) { ?>
                <div id="post-related<?php echo $post_related['post_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $post_related['title']; ?>
                  <input type="hidden" name="post_related[]" value="<?php echo $post_related['post_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>
<script type="text/javascript"><!--
<?php foreach ($data->languages as $language) { ?>
$('#input-description<?php echo $language->language_id; ?>').summernote({
  toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    // ['fontsize', ['fontsize']],
    ['color', ['color']],
    // ['para', ['ul', 'ol', 'paragraph']],
    // ['height', ['height']],
    // ['misc', ['fullscreen','help']]
    // ['misc', ['fullscreen']]
  ], height: 150
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->placeholder; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /><input type="hidden" name="post_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-left"><input type="checkbox" name="post_image[' + image_row + '][watermark]" value="1" <?php echo (($data->watermark_status=="1")? "checked=\'checked\'":"" ); ?> /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" class="btn btn-danger btn-xs"><i class="fa fa-btn fa-minus-circle"></i><?php echo $data->button_remove; ?></button></td>';
  html += '</tr>';

  $('#images tbody').append(html);

  image_row++;
}
//--></script>
<script type="text/javascript"><!--
// Category
$('input[name=\'category\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: '<?php echo $data->go_category_autocomplete;?>?filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category\']').val('');

    $('#post-category' + item['value']).remove();

    $('#post-category').append('<div id="post-category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="post_category[]" value="' + item['value'] + '" /></div>');
  }
});

$('#post-category').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

// Related
$('input[name=\'related\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: '<?php echo $data->go_related_autocomplete;?>?filter_title=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        response($.map(json, function(item) {
          return {
            label: item['title'],
            value: item['post_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'related\']').val('');

    $('#post-related' + item['value']).remove();

    $('#post-related').append('<div id="post-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="post_related[]" value="' + item['value'] + '" /></div>');
  }
});

$('#post-related').delegate('.fa-minus-circle', 'click', function() {
  $(this).parent().remove();
});

//--></script>
<script type="text/javascript">
$('#language a:first').tab('show');
</script>
<script type="text/javascript">
$(document).on('mouseover', '.button-submit-post', function(e) {
  <?php foreach ($data->languages as $language) { ?>
    $('#input-description<?php echo $language->language_id; ?>').val($('#input-description<?php echo $language->language_id; ?>').code());
  <?php } ?>
});

// Override summernotes image manager
$('button[data-original-title=\'Picture\']').attr('data-toggle', 'image').removeAttr('data-event');
// End
</script>
<script type="text/javascript">
$(document).ready(function() {
    requestSubmitForm4('popup-submit-post', 'popup-form-post', "<?php echo $data->action; ?>", "popup-message");
});
</script>