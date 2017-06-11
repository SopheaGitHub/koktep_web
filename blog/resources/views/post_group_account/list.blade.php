<?php
  if(count($data->posts_groups) > 0) {
    foreach ($data->posts_groups as $post_group) { ?>
      <h5><?php echo $post_group->name; ?></h5>
      <div class="row">
        <div class="col-md-12">
          <?php
            if(isset($data->post_group_items[$post_group->post_group_id])) { ?>
              <div class="slider1">
            <?php  foreach ($data->post_group_items[$post_group->post_group_id] as $post_group_items) {
              $post_category = (($post_group_items['category_id'])? $post_group_items['category_id'].'-'.str_replace(' ', '-', strtolower($post_group_items['category_name'])):'0');
                $view_detail = $data->post_detail.'?account_id='.$post_group_items['author_id'].'&post_id='.$post_group_items['post_id'].'&category_id='.$post_category;
             ?>
                <div class="slide"><a href="<?php echo $view_detail; ?>"><img src="<?php echo $post_group_items['thumb']; ?>" alt=""></a></div>
          <?php } ?>
              </div>
          <?php  }
          ?>
        </div>
      </div>
    <?php } 
  } else { ?>
  <em><?php echo $data->text_empty; ?></em>
<?php }
?>
<div class="row">
  	<div class="col-sm-6 text-left" id="render-post-group-account"><?php echo $data->posts_groups->render(); ?></div>
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
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->posts_groups->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->posts_groups->currentPage(); ?> )
	</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      $('.slider1').bxSlider({
        slideWidth: 120,
        minSlides: 10,
        maxSlides: 10,
        slideMargin: 10
      });
    });
</script>