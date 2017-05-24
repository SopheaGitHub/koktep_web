<?php
  if(count($data->posts) > 0) {
    foreach ($data->posts as $post) { ?>
      <div class="row">
      <div class="col-sm-6 col-md-6">
          <img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%">
      </div>
      <div class="col-sm-6 col-md-6">
          <div class="w3-container w3-white">
              <p><b><?php echo $post->title; ?></b></p>
              <p><?php echo $post->description; ?></p>
          </div>
          <hr />
              <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
          <hr />
          <div class="row">
            <div class="col-md-6">
              <a href="<?php echo url('/posts/edit/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
              <a href="<?php echo url('/posts/delete/1'); ?>" class="btn btn-sm btn-danger"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
            </div>
            <div class="col-md-6">
              <span class="pull-right">
                <i class="fa fa-btn <?php echo (($post->status=='1')? 'fa-check':'fa-times') ?>"></i> <?php echo ((isset($data->status[$post->status]))? $data->status[$post->status]:$post->status) ?>
              </span>
            </div>
          </div>
      </div>
    </div>
    <hr />
    <?php } 
  } else { ?>
  <em><?php echo $data->text_empty; ?></em>
<?php }
?>
<div class="row">
  	<div class="col-sm-6 text-left" id="render-post"><?php echo $data->posts->render(); ?></div>
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
      Showing <?php echo $start; ?> to <?php echo $stop; ?> of <?php echo $data->posts->total(); ?> &nbsp;&nbsp; (<?php echo $data->posts->currentPage(); ?> Pages)
	</div>
</div>