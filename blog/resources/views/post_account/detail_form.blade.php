<?php
    if($data->check_post) { ?>
        <div class="container">
            <div class="row profile">
                <div class="col-md-3">
                    <div style="padding:20px; background: #fff;">
                        <b><?php echo $data->title; ?></b>
                        <hr />
                        <div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="<?php echo ((isset($data->thumb_author))? $data->thumb_author:''); ?>"></span> &nbsp; <a href="<?php echo $data->overview_account.'?account_id='.$data->author_id; ?>"> <b><?php echo $data->author_name; ?></b></a></div>
                        <p></p>
                        <div>
                            <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $data->post_viewed; ?>
                        </div>
                        <div>
                            <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $data->post_commented; ?>
                        </div>
                        <div>
                            <i data-toggle="tooltip" title="<?php echo $data->icon_date; ?>" class="fa fa-btn fa-calendar"></i>on <?php echo date('M dS, Y', strtotime($data->post_created_at)); ?>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-tags" data-toggle="tab" aria-expanded="true"><i class="fa fa-btn fa-tags"></i><?php echo $data->tab_tags; ?></a></li>
                                    <li class=""><a href="#tab-categories" data-toggle="tab" aria-expanded="false"><i class="fa fa-btn fa-book"></i><?php echo $data->tab_categories; ?></a></li>
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
                        <hr />
                        <div>
                            <span class="pull-left">
                                <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_counter addthis_pill_style"></a></div>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                                <!-- AddThis Button END --> 
                            </span>
                        </div>
                        <br />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="profile-content">
                        <?php $post_image = explode('/', $data->post_image); ?>
                        <p class="thumbnailimage"><a class="thumbnailimage" href="<?php echo $data->image; ?>" title="<?php echo ((count($post_image)>0)? end($post_image):''); ?>"><img src="<?php echo $data->image; ?>" alt="" width="100%"></a></p>
                        <?php
                            if(count($data->post_images)) {
                                foreach ($data->post_images as $post_image) { $image = explode('/', $post_image['image']); ?>
                                    <p class="thumbnailimage"><a class="thumbnailimage" href="<?php echo $post_image['thumb']; ?>" title="<?php echo ((count($image)>0)? end($image):''); ?>"><img src="<?php echo $post_image['thumb']; ?>" alt="" width="100%"></a></p>
                            <?php   }
                            }
                        ?>
                        <p><?php echo htmlspecialchars_decode($data->description); ?></p>
                        <br /><br />
                        <div class="row">
                            <div class="col-md-12">
                                <form action="#" method="post" enctype="multipart/form-data" id="form-comment" class="form-horizontal">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="detailBox">
                                        <div class="titleBox">
                                          <label><h4><i class="fa fa-btn fa-comment"></i><?php echo $data->entry_comment; ?></h4></label>
                                            <!-- <button type="button" class="close" aria-hidden="true">&times;</button> -->
                                        </div>
                                        <?php
                                            if($data->authorized) { ?>
                                            <div id="load-form">

                                            </div>
                                        <?php } else { ?>
                                            <?php echo trans('auth.text_koktep_collections'); ?>
                                            <br />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span><a href="<?php echo url('/login'); ?>"><i class="fa fa-btn fa-sign-in"></i><?php echo trans('text.login'); ?></a></span> 
                                                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                                    <span><a href="<?php echo url('/register'); ?>"><i class="fa fa-btn fa-pencil-square-o"></i><?php echo trans('text.register'); ?></a></span>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>    
                                </form>
                            </div>
                        </div>
                        <hr >
                        <div><h4><i class="fa fa-btn fa-retweet"></i><?php echo $data->entry_related_post; ?></h4></div>
                        <div class="row">
                            <?php
                            if (count($data->post_relateds) > 0) {
                                    foreach ($data->post_relateds as $post) {
                                            $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
                                            $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
                                        ?>
                                        <div class="col-sm-4 col-md-4">
                                            <a href="<?php echo $view_detail; ?>"><img src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" alt="" style="width:100%"></a>
                                            <div><b><a href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a></b></div>
                                            <p><?php echo $post->description; ?></p>
                                            <div class="row">
                                                <div class="col-md-8"><div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$post->post_id]))? $data->thumb_user[$post->post_id]:''); ?>"></span> &nbsp; <a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"> <b><?php echo $post->author_name; ?></b></a></div></div>
                                                <div class="col-md-4">
                                                    <span class="pull-right" style="font-size:11px;">
                                                        <i class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?> &nbsp;
                                                        <a href="<?php echo $view_detail; ?>"><i class="fa fa-btn fa-picture-o"></i></a><?php echo ($post->total_post_image+1); ?>
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
                    </div>
                </div>
            </div>
        </div>

<?php    } else { ?>
        <em><?php echo $data->text_empty; ?></em>
<?php } ?>

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('submit', '#form-comment', function() {
        return false;
    });
    loadingForm("<?php echo $data->action_comment_form; ?>");
    requestSubmitForm('submit-comment', 'form-comment', "<?php echo $data->action; ?>");

    $('.thumbnailimage').magnificPopup({
        type:'image',
        delegate: 'a',
        gallery: {
            enabled:true
        }
    });
});
</script>