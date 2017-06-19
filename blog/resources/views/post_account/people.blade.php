<style type="text/css">
    .bx-wrapper {
        margin-bottom: 10px;
        margin-left: 10px;
    }
    .bx-wrapper .bx-pager {
        display: none;
    }

</style>
<?php
if (count($data->users) > 0) {
        foreach ($data->users as $user) { ?>
            <div class="media">
                <div class="media-left">
                
                    <div class="profile-sidebar">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            <a href="<?php echo $data->overview_account.'?account_id='.$user->people_id; ?>"><img alt="" src="<?php echo ((isset($data->thumb_user[$user->people_id]))? $data->thumb_user[$user->people_id]:''); ?>"></a>
                        </div>
                    </div>


                </div>
              
              <div class="media-body">
                <div class="media-heading">
                    <div class="col-md-8">
                        <a href="<?php echo $data->overview_account.'?account_id='.$user->people_id; ?>"><?php echo $user->people_name; ?></a> &nbsp;&nbsp;&nbsp;
                        <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $user->viewed; ?> &nbsp;
                        <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $user->commented; ?> &nbsp;
                    </div>
                    <div class="col-md-4">
                        <span class="pull-right">
                            <a href="<?php echo $data->overview_account.'?account_id='.$user->people_id; ?>"><i data-toggle="tooltip" title="Image" class="fa fa-btn fa-arrow-circle-right"></i><?php echo $data->text_view_profile; ?></a>
                        </span>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if(isset($data->post_group_items[$user->people_id])) { ?>
                              <div class="slider1">
                            <?php  foreach ($data->post_group_items[$user->people_id] as $post_group_items) { 
                                $post_category = (($post_group_items['category_id'])? $post_group_items['category_id'].'-'.str_replace(' ', '-', strtolower($post_group_items['category_name'])):'0');
                                $view_detail = $data->post_detail.'?account_id='.$post_group_items['author_id'].'&post_id='.$post_group_items['post_id'].'&category_id='.$post_category;
                              ?>
                                <div class="slide"><a href="<?php echo $view_detail; ?>"><img src="<?php echo $post_group_items['thumb_post']; ?>" alt=""></a></div>
                          <?php } ?>
                              </div>
                          <?php  }
                        ?>
                    </div>
                </div>
                </div>
            </div>
    <?php   }
    } else { ?>
    <em><?php echo $data->text_empty; ?></em>
<?php    }
?>
<div class="row">
    <div class="col-sm-6 text-left" id="render-overview"><?php echo $data->users->render(); ?></div>
    <div class="col-sm-6 text-right">
        <?php
        $start = ($data->users->currentPage() * $data->users->perPage()) - $data->users->perPage() + 1;
        $stop = $data->users->currentPage() * $data->users->perPage();
        if($stop > $data->users->total()){
          $stop = ( $start + $data->users->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      Showing <?php echo $start; ?> to <?php echo $stop; ?> of <?php echo $data->users->total(); ?> &nbsp;&nbsp; (<?php echo $data->users->currentPage(); ?> Pages)
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
      $('.slider1').bxSlider({
        slideWidth: 120,
        minSlides: 10,
        maxSlides: 10,
        slideMargin: 5
      });
    });
</script>