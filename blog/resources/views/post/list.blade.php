<?php
  if(count($data->posts) > 0) {
    foreach ($data->posts as $post) { 
        $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
        $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
      ?>
      <div class="row">
      <div class="col-sm-6 col-md-6">
          <a href="<?php echo $view_detail; ?>"><img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%"></a>
      </div>
      <div class="col-sm-6 col-md-6">
          <div class="w3-container w3-white">
              <p><b><?php echo $post->title; ?></b></p>
              <p><?php echo $post->description; ?></p>
          </div>
          <hr />
            <!-- <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212 -->
            <div>
              <i data-toggle="tooltip" title="View" class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?>
            </div>
            <div>
              <i data-toggle="tooltip" title="Comment" class="fa fa-btn fa-comment"></i><?php echo $post->commented; ?>
            </div>
            <div>
              <i data-toggle="tooltip" title="Date" class="fa fa-btn fa-calendar"></i>on <?php echo date('M dS, Y', strtotime($post->created_at)); ?>
            </div>
          <hr />
          <div class="row">
            <div class="col-md-6">
              <a href="<?php echo $data->edit_post.'/'.$post->post_id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> <?php echo trans('button.edit'); ?></a>
              <a href="#" class="btn btn-sm btn-danger" id="<?php echo $post->post_id; ?>" data-toggle="modal" data-target="#modal-delete-post"><i class="fa fa-btn fa-trash-o"></i> <?php echo trans('button.delete'); ?></a>
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
<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" id="modal-delete-post" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><i class="fa fa-btn fa-trash"></i>Delete Confirmation</h5>
      </div>
      <div class="modal-body">
        <form action="#" method="post" enctype="multipart/form-data" id="form-delete-post" class="form-horizontal">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" value="" name="post_id" class="post_id" />
        </form>
        Are you sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-btn fa-close"></i>No</button>
        <button type="botton" class="btn btn-primary btn-sm" data-dismiss="modal" id="submit-delete-post"><i class="fa fa-btn fa-check"></i>Yes</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    // get post id
    $('#modal-delete-post').on('show.bs.modal', function(e) {
      var $modal = $(this),
      esseyId = e.relatedTarget.id;
      $('.post_id').val(esseyId);
    });
</script>