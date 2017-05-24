<?php
  if(count($data->posts_groups) > 0) {
    foreach ($data->posts_groups as $post_group) { ?>
      <div class="row">
        <div class="col-md-7"><h5><a href="#"><?php echo $post_group->name; ?></a></h5></div>
        <div class="col-md-3">
            <span class="pull-right">
              <a href="<?php echo url('/posts-groups/edit/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
              <a href="<?php echo url('/posts-groups/delete/1'); ?>" class="btn btn-sm btn-danger"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
            </span>
        </div>
        <div class="col-md-2">
            <span class="pull-right">
              <i class="fa fa-btn <?php echo (($post_group->status=='1')? 'fa-check':'fa-times') ?>"></i> <?php echo ((isset($data->status[$post_group->status]))? $data->status[$post_group->status]:$post_group->status) ?>
            </span>
        </div>
      </div>
      <div style="border:1px solid #ddd;">
        <div id="main" role="main">
          <section class="slider">
            <div class="flexslider carousel">
              <ul class="slides">
                <?php
                  if(isset($data->post_group_items[$post_group->post_group_id])) {
                    foreach ($data->post_group_items[$post_group->post_group_id] as $post_group_items) { ?>
                      <li>
                        <a href="#"><img src="<?php echo $post_group_items['thumb']; ?>" alt="" /></a>
                      </li>
                <?php }
                  }
                ?>
              </ul>
            </div>
          </section>
        </div>
      </div>
      <br />
    <?php } 
  } else { ?>
  <em><?php echo $data->text_empty; ?></em>
<?php }
?>
<div class="row">
  	<div class="col-sm-6 text-left" id="render-post"><?php echo $data->posts_groups->render(); ?></div>
  	<div class="col-sm-6 text-right">
  		<?php
        $start = ($data->posts_groups->currentPage() * $data->posts_groups->perPage()) - $data->posts_groups->perPage() + 1;
        $stop = $data->posts_groups->currentPage() * $data->posts_groups->perPage();
        if($stop > $data->posts_groups->total()){
          $stop = ( $start + $data->posts_groups->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      Showing <?php echo $start; ?> to <?php echo $stop; ?> of <?php echo $data->posts_groups->total(); ?> &nbsp;&nbsp; (<?php echo $data->posts_groups->currentPage(); ?> Pages)
	</div>
</div>