@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-6"><h3><i class="fa fa-btn fa-tasks"></i>Posts Management</h3></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            <a href="<?php echo url('/posts?account_id=1'); ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-undo"></i> Cancel</a>
                            <button type="button" id="submit-post" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> Save</button>
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <div class="row">


                    <div class="container-fluid">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-plus"></i> <b><?php echo $data->titlelist; ?></b></h3>
                          </div>
                          <div class="panel-body">

                            <form action="#" method="post" enctype="multipart/form-data" id="form-post" class="form-horizontal">
                              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $data->tab_general; ?></a></li>
                                <li><a href="#tab-data" data-toggle="tab"><?php echo $data->tab_data; ?></a></li>
                                <li><a href="#tab-links" data-toggle="tab"><?php echo $data->tab_links; ?></a></li>
                                <li><a href="#tab-image" data-toggle="tab"><?php echo $data->tab_image; ?></a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab-general">
                                    <?php foreach ($data->languages as $language) { ?>
                                    <div class="tab-pane" id="language<?php echo $language->language_id; ?>">
                                      <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-title<?php echo $language->language_id; ?>"><?php echo $data->entry_title; ?></label>
                                        <div class="col-sm-10">
                                          <input type="text" name="post_description[<?php echo $language->language_id; ?>][title]" value="<?php echo $data->post_description[$language->language_id]['title']; ?>" placeholder="<?php echo $data->entry_title; ?>" id="input-title<?php echo $language->language_id; ?>" class="form-control" />
                                        </div>
                                      </div>
                                      <div class="form-group required">
                                        <label class="col-sm-2 control-label" for="input-description<?php echo $language->language_id; ?>"><?php echo $data->entry_description; ?></label>
                                        <div class="col-sm-10">
                                          <textarea name="post_description[<?php echo $language->language_id; ?>][description]" placeholder="<?php echo $data->entry_description; ?>" id="input-description<?php echo $language->language_id; ?>" class="text_summernote form-control"><?php echo $data->post_description[$language->language_id]['description']; ?></textarea>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-sm-2 control-label" for="input-tag<?php echo $language->language_id; ?>"><span data-toggle="tooltip" title="comma separated"><?php echo $data->entry_tag; ?></span></label>
                                        <div class="col-sm-10">
                                          <input type="text" name="post_description[<?php echo $language->language_id; ?>][tag]" value="<?php echo $data->post_description[$language->language_id]['tag']; ?>" placeholder="<?php echo $data->entry_tag; ?>" id="input-tag<?php echo $language->language_id; ?>" class="form-control" />
                                        </div>
                                      </div>
                                    </div>
                                    <?php } ?>
                                </div>

                                <div class="tab-pane" id="tab-data">
                                  <div class="form-group required">
                                    <label class="col-sm-2 control-label"><?php echo $data->entry_image; ?></label>
                                    <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->thumb; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a>
                                      <input type="hidden" name="image" value="<?php echo $data->image; ?>" id="input-image" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label"><?php echo $data->entry_status; ?></label>
                                    <div class="col-sm-10">
                                      <select name="status" id="input-status" class="form-control">
                                        <?php
                                          foreach ($data->status as $key => $status) { ?>
                                            <option <?php echo (($key == $data->post_status)? 'selected="selected"':''); ?> value="<?php echo $key; ?>"><?php echo $status; ?></option>
                                          <?php }
                                        ?>
                                      </select>
                                    </div>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-links">
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-category"><span data-toggle="tooltip" title="" data-original-title="<?php echo $data->title_category; ?>"><?php echo $data->entry_category; ?></span></label>
                                    <div class="col-sm-10">
                                      <input type="text" name="category" value="" placeholder="<?php echo $data->entry_category; ?>" id="input-category" class="form-control" />
                                      <div id="post-category" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($data->post_categories as $post_category) { ?>
                                        <div id="post-category<?php echo $post_category['category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $post_category['name']; ?>
                                          <input type="hidden" name="post_category[]" value="<?php echo $post_category['category_id']; ?>" />
                                        </div>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $data->title_related; ?>"><?php echo $data->entry_related; ?></span></label>
                                    <div class="col-sm-10">
                                      <input type="text" name="related" value="" placeholder="<?php echo $data->entry_related; ?>" id="input-related" class="form-control" />
                                      <div id="post-related" class="well well-sm" style="height: 150px; overflow: auto;">
                                        <?php foreach ($data->post_relateds as $post_related) { ?>
                                        <div id="post-related<?php echo $post_related['post_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $post_related['name']; ?>
                                          <input type="hidden" name="post_related[]" value="<?php echo $post_related['post_id']; ?>" />
                                        </div>
                                        <?php } ?>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-image">
                                  <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <td class="text-left"><?php echo $data->entry_image; ?></td>
                                          <td class="text-right"><?php echo $data->entry_sort_order; ?></td>
                                          <td></td>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <?php $image_row = 0; ?>
                                        <?php foreach ($data->post_images as $post_image) { ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                          <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $post_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /></a><input type="hidden" name="post_image[<?php echo $image_row; ?>][image]" value="<?php echo $post_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                          <td class="text-right"><input type="text" name="post_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $post_image['sort_order']; ?>" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>
                                          <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $image_row++; ?>
                                        <?php } ?>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="2"></td>
                                          <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $data->button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>
                                
                              </div>
                            </form>

                          </div>
                        </div>
                      </div>


                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript"><!--
<?php foreach ($data->languages as $language) { ?>
$('#input-description<?php echo $language->language_id; ?>').summernote({
  height: 300
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $data->placeholder; ?>" alt="" title="" data-placeholder="<?php echo $data->placeholder; ?>" /><input type="hidden" name="post_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="post_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $data->entry_sort_order; ?>" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $data->button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
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
$(document).on('mouseover', '#submit-post', function(e) {
  <?php foreach ($data->languages as $language) { ?>
    $('#input-description<?php echo $language->language_id; ?>').val($('#input-description<?php echo $language->language_id; ?>').code());
  <?php } ?>
});
$(document).ready(function() {
  requestSubmitForm('submit-post', 'form-post', "<?php echo $data->action; ?>");
});
</script>
@endsection