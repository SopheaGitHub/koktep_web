<?php
  $post_category = ((isset($data->post_categories['0']))? $data->post_categories['0']['category_id'].'-'.str_replace(' ', '-', strtolower($data->post_categories['0']['name'])):'0');
  $view_detail = $data->post_detail.'?account_id='.$data->author_id.'&post_id='.$data->post_id.'&category_id='.$post_category;
  $description = mb_substr(strip_tags(html_entity_decode($data->description, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($data->description)>100)? '...':'');
?>
<div class="modal-dialog modal-lg">
  <div class="modal-content" style="-webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border:1px solid #ddd;">
    <div class="modal-header">
      <div class="row">
        <div class="col-md-6"><h4 class="modal-title"><b><i class="fa fa-btn fa-upload"></i><?php echo $data->titlelist; ?></b></h4></div>
        <div class="col-md-6">
            <span class="pull-right">
              <a href="<?php echo $data->go_back.'?account_id='.$data->auth_id; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-angle-double-left"></i> <?php echo $data->button_back; ?></a>
            </span>
        </div>
      </div>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="col-sm-6 col-md-6">
          <p>- Click <a href="<?php echo $view_detail; ?>" class="btn btn-primary btn-xs">Go To <i class="fa fa-arrow-circle-o-right"></i>
</a> view detail.</p>
          <p>- Click <a href="<?php echo $data->action_post_management; ?>" class="btn btn-default btn-xs">Go To <i class="fa fa-arrow-circle-o-right"></i>
</a> upload management.</p>
        </div>
        <div class="col-sm-6 col-md-6">
          <a href="<?php echo $view_detail; ?>"><img src="<?php echo $data->image ?>" alt="" style="width:100%"></a>
          <div><b><a href="<?php echo $view_detail; ?>"><?php echo $data->title; ?></a></b></div>
          <p><?php echo $description; ?></p>
        </div>
      </div>

    </div>
    <div class="modal-footer"></div>
  </div>
</div>