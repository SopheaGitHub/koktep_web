<div class="row">
    <div class="col-md-8"><h4><?php echo $data->title; ?></h4></div>
    <div class="col-md-4">
        <span class="pull-right">
        	<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_counter addthis_pill_style"></a></div>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
			<!-- AddThis Button END -->	
        </span>
        <span class="pull-right" style="margin-top:-2px;">
        	<button type="button" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-eye"></i>View 1</button>
        </span>&nbsp;
    </div>
</div>
<p><img src="<?php echo $data->image; ?>" alt="" width="100%"></p>
<?php
	if(count($data->post_images)) {
		foreach ($data->post_images as $post_image) { ?>
			<p><img src="<?php echo $post_image['thumb']; ?>" alt="" width="100%"></p>
	<?php	}
	}
?>
<p><?php echo $data->description; ?></p>
<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs">
	        <li class="active"><a href="#tab-tags" data-toggle="tab" aria-expanded="true"><i class="fa fa-btn fa-tags"></i>Tags</a></li>
            <li class=""><a href="#tab-categories" data-toggle="tab" aria-expanded="false"><i class="fa fa-btn fa-book"></i>Categories</a></li>
      	</ul>
      	<div class="tab-content" style="padding:20px;">
            <div class="tab-pane active" id="tab-tags">
            	<?php
                    if(count($data->tags) > 0) {
                        foreach ($data->tags as $tag) { ?>
                            <a href="<?php echo $data->url_tag.trim($tag); ?>" class="btn btn-primary btn-xs"><?php echo $tag; ?></a>
                    <?php    }
                    }
                ?>
            </div>
           	<div class="tab-pane" id="tab-categories">
        		<?php
                    if(count($data->post_categories) > 0) {
                        foreach ($data->post_categories as $post_category) { 
                            $category_id = (($post_category['category_id'])? $post_category['category_id'].'-'.str_replace(' ', '-', strtolower($post_category['name'])):'0'); ?>
                            <a href="<?php echo $data->url_category.$category_id; ?>" class="btn btn-primary btn-xs"><?php echo $post_category['name']; ?></a>
                    <?php    }
                    }
                ?>                
            </div>
        </div>
	</div>
</div>
<br /><br />
<div class="row">
	<div class="col-md-12">
        <form action="#" method="post" enctype="multipart/form-data" id="form-comment" class="form-horizontal">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    		<div class="detailBox">
    		    <div class="titleBox">
    		      <label><h4><i class="fa fa-btn fa-comment"></i>Comment</h4></label>
    		        <!-- <button type="button" class="close" aria-hidden="true">&times;</button> -->
    		    </div>
                <div id="load-form">

                </div>
    		</div>    
        </form>
	</div>
</div>
<hr >
<div><h4><i class="fa fa-btn fa-retweet"></i>Related Post</h4></div>
<div class="row">
    <?php
    if (count($data->post_relateds) > 0) {
            foreach ($data->post_relateds as $post) {
                    $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
                    $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
                ?>
                <div class="col-sm-3 col-md-3">
                    <a href="<?php echo $view_detail; ?>"><img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%"></a>
                    <div><b><a href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a></b></div>
                    <p><?php echo $post->description; ?></p>
                    <div class="row">
                        <div class="col-md-8"><b><a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"><?php echo $post->author_name; ?></a></b></div>
                        <div class="col-md-4">
                            <span class="pull-right" style="font-size:11px;">
                                <i class="fa fa-btn fa-eye"></i> 0121 &nbsp;&nbsp;&nbsp;
                                <a href="<?php echo $view_detail; ?>"><i class="fa fa-btn fa-picture-o"></i></a> 2
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
<script type="text/javascript">
$(document).ready(function() {
    loadingForm("<?php echo $data->action_comment_form; ?>");
    requestSubmitForm('submit-comment', 'form-comment', "<?php echo $data->action; ?>");
});
</script>