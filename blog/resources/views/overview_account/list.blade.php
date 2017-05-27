<div class="row">
    <?php
    if (count($data->posts) > 0) {
            foreach ($data->posts as $post) { ?>
                <div class="col-sm-6 col-md-6">
                    <img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%">
                    <div><b><a href="<?php echo $data->post_detail.'?post_id='.$post->post_id; ?>"><?php echo $post->title; ?></a></b></div>
                    <p><?php echo $post->description; ?></p>
                    <div class="row">
                        <div class="col-md-8"><b><a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"><?php echo $post->author_name; ?></a></b></div>
                        <div class="col-md-4">
                            <span class="pull-right" style="font-size:11px;">
                                <i class="fa fa-btn fa-eye"></i> 0121 &nbsp;&nbsp;&nbsp;
                                <a href="<?php echo $data->post_detail.'?post_id='.$post->post_id; ?>"><i class="fa fa-btn fa-picture-o"></i></a> 2
                            </span>
                        </div>
                    </div>
                    <hr />
                </div>
        <?php   }
        }
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
      Showing <?php echo $start; ?> to <?php echo $stop; ?> of <?php echo $data->posts->total(); ?> &nbsp;&nbsp; (<?php echo $data->posts->currentPage(); ?> Pages)
    </div>
</div>