<?php
  if(count($data->posts_groups) > 0) {
    foreach ($data->posts_groups as $post_group) { ?>
      <div class="row">
        <div class="col-md-7"><h5><a href="#"><?php echo $post_group->name; ?></a></h5></div>
        <div class="col-md-3">
            <span class="pull-right">
              <a href="<?php echo $data->edit_post.'/'.$post_group->post_group_id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil-square"></i> <?php echo $data->button_edit; ?></a>
              <a href="#" class="btn btn-sm btn-danger" id="<?php echo $post_group->post_group_id; ?>" data-toggle="modal" data-target="#modal-delete-post-group"><i class="fa fa-btn fa-trash-o"></i> <?php echo $data->button_delete; ?></a>
            </span>
        </div>
        <div class="col-md-2">
            <span class="pull-right">
              <i class="fa fa-btn <?php echo (($post_group->status=='1')? 'fa-check':'fa-times') ?>"></i> <?php echo ((isset($data->status[$post_group->status]))? $data->status[$post_group->status]:$post_group->status) ?>
            </span>
        </div>
      </div>

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
  	<div class="col-sm-6 text-left" id="render-post-group"><?php echo $data->posts_groups->render(); ?></div>
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
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->posts_groups->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->posts_groups->currentPage(); ?>)
	</div>
</div>
<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" id="modal-delete-post-group" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><i class="fa fa-btn fa-trash"></i><?php echo $data->delete_confirmation; ?></h5>
      </div>
      <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data" id="form-delete-post-group" class="form-horizontal">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" value="" name="post_group_id" class="post_group_id" />
        </form>
        <?php echo $data->delete_confirmation_message; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i><?php echo $data->button_no; ?></button>
        <button type="botton" class="btn btn-primary btn-sm" data-dismiss="modal" id="submit-delete-post-group"><i class="fa fa-btn fa-check"></i><?php echo $data->button_yes; ?></button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    // get post id
    $('#modal-delete-post-group').on('show.bs.modal', function(e) {
      var $modal = $(this),
      esseyId = e.relatedTarget.id;
      $('.post_group_id').val(esseyId);
    });
</script>
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