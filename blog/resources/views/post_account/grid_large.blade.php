<div class="row_grid_large">
	<?php
	    if(count($data->posts) > 0) {
	      foreach ($data->posts as $key => $post) { 
	          	$post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
	          	$view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
	          	$description = mb_substr(strip_tags(html_entity_decode($post->description, ENT_QUOTES, 'UTF-8')), 0, 150).((mb_strlen($post->description)>150)? '...':'');
	        ?>
	        
	        <div class="item_grid_large well">
				<div>
	              	<a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"><img style="width:40px; margin-top:5px; border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$post->post_id]))? $data->thumb_user[$post->post_id]:''); ?>"> &nbsp; <span><?php echo $post->author_name; ?></span></a>
	            </div>
	            <br />
	            <div>
                    <div style="color:#cccccc; font-size: 12px;"><i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y H:i', strtotime($post->created_at)); ?></div>
                    <a class="well-title" href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a>
                    <p class="well-description"><?php echo $description; ?></p>
                </div>
	            <div class="image-container">
	                <a href="<?php echo $view_detail; ?>"><img class="image" src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" style="width:100%;"></a>
	                <a href="<?php echo $view_detail; ?>" class="overlaylogo">&nbsp;</a>
	            </div>

	            <div style="text-align:right; font-size:12px; color: #ccc;">
	                <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?> &nbsp;
	                <i data-toggle="tooltip" title="<?php echo $data->icon_rating; ?>" class="fa fa-btn fa-star"></i><?php echo (($post->average_rating!='')? $post->average_rating:'0'); ?> &nbsp;
	                <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $post->commented; ?> &nbsp;
	                <a href="<?php echo $view_detail; ?>"><i data-toggle="tooltip" title="<?php echo $data->icon_image; ?>" class="fa fa-btn fa-picture-o"></i></a><?php echo ($post->total_post_image+1); ?>
	            </div>
			</div>
	        

	      <?php }
	    } else { ?>
	    <em><?php echo $data->text_empty; ?></em>
	  <?php }
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