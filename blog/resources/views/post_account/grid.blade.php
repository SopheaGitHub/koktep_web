<style type="text/css">
.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    position: relative;
    min-height: 1px;
    padding-right: 10px;
    padding-left: 10px;
}
</style>
<div class="row">
  <?php
    if(count($data->posts) > 0) {
      foreach ($data->posts as $post) { 
          $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
          $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
          $description = mb_substr(strip_tags(html_entity_decode($post->description, ENT_QUOTES, 'UTF-8')), 0, 150).((mb_strlen($post->description)>150)? '...':'');
        ?>
        <div class="col-md-2" style="margin-bottom: 10px;">

            <div style="background:#fff; padding:5px; padding-bottom:0px;">

              <div class="image-container">
                <a href="<?php echo $view_detail; ?>"><img class="image" src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" style="width:100%;"></a>
                <a href="<?php echo $view_detail; ?>" class="overlaylogo">
                  <div class="text">
                    <span style="color: #91beb1;"><?php echo $post->title; ?></span>
                    <div><i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y', strtotime($post->created_at)); ?></div>
                    <p><?php echo $description; ?></p>
                  </div>
                </a>
                <div class="overlay">
                  <div class="text"><a href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a></div>
                </div>
              </div>

              <div style="text-align:right; font-size:10px; color: #ccc;">
                <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?> &nbsp;
                <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $post->commented; ?> &nbsp;
                <a href="<?php echo $view_detail; ?>"><i data-toggle="tooltip" title="<?php echo $data->icon_image; ?>" class="fa fa-btn fa-picture-o"></i></a><?php echo ($post->total_post_image+1); ?>
              </div>
            </div>

            <div>
              <a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"><img style="width:25px; margin-top:5px; border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$post->post_id]))? $data->thumb_user[$post->post_id]:''); ?>"> &nbsp; <span style="font-size: 10px;"><?php echo $post->author_name; ?></span></a>
            </div>

        </div>
      <?php }
    } else { ?>
    <em><?php echo $data->text_empty; ?></em>
  <?php }
  ?>
</div>
<div style="clear:both;">&nbsp;</div>
<div class="row">
    <div class="col-sm-6 text-left" id="render-overview"><?php echo $data->posts->render(); ?></div>
    <div class="col-sm-6 text-right">
        <?php
        $start = ($data->posts->currentPage() * $data->posts->perPage()) - $data->posts->perPage() + 1;
        $stop = $data->posts->currentPage() * $data->posts->perPage();
        if($stop > $data->posts->total()){
          $stop = ( $start + $data->posts->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->posts->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->posts->currentPage(); ?> )
    </div>
</div>