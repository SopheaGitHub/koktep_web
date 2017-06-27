<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><b><i class="fa fa-btn <?php echo (($data->icon=='icon_create')? 'fa-plus-square':'fa-pencil-square') ?>"></i><?php echo $data->titlelist; ?></b></h3>
    </div>
    <div class="panel-body">

      <form action="#" method="post" enctype="multipart/form-data" id="form-post-group" class="form-horizontal">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $data->tab_general; ?></a></li>
          <li><a href="#tab-data" data-toggle="tab"><?php echo $data->tab_data; ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
            <?php foreach ($data->languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language->language_id; ?>">
                    <div class="form-group required">
                        <label class="col-sm-3 control-label" for="input-name<?php echo $language->language_id; ?>"><?php echo $data->entry_name; ?></label>
                    <div class="col-sm-9">
                        <input type="text" name="post_group_description[<?php echo $language->language_id; ?>][name]" value="<?php echo ((isset($data->post_group_description[$language->language_id]['name']))? $data->post_group_description[$language->language_id]['name']:''); ?>" placeholder="<?php echo $data->entry_name; ?>" id="input-name<?php echo $language->language_id; ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="tab-pane" id="tab-data">
            <div class="form-group">
                <label class="col-sm-3 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $data->title_related; ?>"><?php echo $data->entry_related; ?></span></label>
                <div class="col-sm-9">
                    <input type="text" name="related" value="" placeholder="<?php echo $data->entry_related; ?>" id="input-related" class="form-control" />
                    <div id="post-related" class="well well-sm" style="height: 150px; overflow: auto;">
                      <?php foreach ($data->post_relateds as $post_related) { ?>
                      <div id="post-related<?php echo $post_related['post_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $post_related['title']; ?>
                        <input type="hidden" name="post_related[]" value="<?php echo $post_related['post_id']; ?>" />
                      </div>
                      <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $data->entry_status; ?></label>
                <div class="col-sm-9">
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
          
        </div>
      </form>

    </div>
  </div>
</div>

<script type="text/javascript"><!--
// Related
$('input[name=\'related\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: '<?php echo $data->go_post_autocomplete;?>?filter_title=' +  encodeURIComponent(request),
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