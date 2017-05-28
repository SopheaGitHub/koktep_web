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
        	<button type="button" class="btn btn-primary btn-xs"><i class="fa fa-btn fa-eye"></i>1232</button>
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
            	Tags
            </div>
           	<div class="tab-pane" id="tab-categories">
        		Categories
            </div>
        </div>
	</div>
</div>
<br /><br />
<div class="row">
	<div class="col-md-12">
		<div class="detailBox">
		    <div class="titleBox">
		      <label><h4><i class="fa fa-btn fa-comment"></i>Comment</h4></label>
		        <!-- <button type="button" class="close" aria-hidden="true">&times;</button> -->
		    </div>
		    <div class="commentBox">
		    	<div class="row">
		    		<div class="col-md-10">
		    			<input class="form-control" type="text" placeholder="Your comments" />
		    		</div>
		    		<div class="col-md-2">
		    			<button class="btn btn-primary btn-sm"><i class="fa fa-btn fa-check"></i>Submit</button>
		    		</div>
		    	</div>
		    </div>
		    <div class="actionBox">
		        <ul class="commentList">
		            <li>
		                <div class="commenterImage">
		                  <img src="http://placekitten.com/50/50" />
		                </div>
		                <div class="commentText">
		                    <p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>

		                </div>
		            </li>
		            <li>
		                <div class="commenterImage">
		                  <img src="http://placekitten.com/45/45" />
		                </div>
		                <div class="commentText">
		                    <p class="">Hello this is a test comment and this comment is particularly very long and it goes on and on and on.</p> <span class="date sub-text">on March 5th, 2014</span>

		                </div>
		            </li>
		            <li>
		                <div class="commenterImage">
		                  <img src="http://placekitten.com/40/40" />
		                </div>
		                <div class="commentText">
		                    <p class="">Hello this is a test comment.</p> <span class="date sub-text">on March 5th, 2014</span>
		                </div>
		            </li>
		        </ul>
		    </div>
		</div>
	</div>
</div>