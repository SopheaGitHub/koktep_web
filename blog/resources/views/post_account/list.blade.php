<div class="row">
    <?php
    if (count($data->posts) > 0) {
            foreach ($data->posts as $post) {
                    $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
                    $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
                
                    $description = mb_substr(strip_tags(html_entity_decode($post->description, ENT_QUOTES, 'UTF-8')), 0, 100).((mb_strlen($post->description)>100)? '...':'');

                ?>
                <div class="col-sm-6 col-md-6">
                    <a href="<?php echo $view_detail; ?>"><img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%"></a>
                    <div><b><a href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a></b></div>
                    <p><?php echo $description; ?></p>
                    <div class="row">
                        <div class="col-md-8">
                            <div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$post->post_id]))? $data->thumb_user[$post->post_id]:''); ?>"></span> &nbsp; <a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"> <b><?php echo $post->author_name; ?></b></a></div>
                        </div>
                        <div class="col-md-4">
                            <span class="pull-right" style="font-size:11px;">
                                <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?> &nbsp;
                                <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $post->commented; ?> &nbsp;
                                <a href="<?php echo $view_detail; ?>"><i data-toggle="tooltip" title="<?php echo $data->icon_image; ?>" class="fa fa-btn fa-picture-o"></i></a><?php echo ($post->total_post_image+1); ?>
                            </span>
                        </div>
                    </div>
                    <hr />
                </div>
        <?php   }
        } else { ?>
        <em><?php echo $data->text_empty; ?></em>
    <?php    }
    ?>
</div>
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