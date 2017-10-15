@extends('layouts.app')

@section('stylesheet')
    <link href="<?php echo asset('/javascript/jquery/rating/star-rating.css'); ?>" rel="stylesheet" />
    <style type="text/css">
        .btn-primary-favorite {
            color: #e2e5d8;
            background-color: #91beb1;
            border-color: #91beb1;
        }
        .btn-primary-favorite:hover {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-default-favorite {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }
        .btn-default-favorite:hover {
            color: #e2e5d8;
            background-color: #91beb1;
            border-color: #91beb1;
        }
    </style>
@endsection

@section('content')
<?php
    if($data->check_post) { ?>
        <div class="container">
            <div class="row profile">
                <div class="col-md-9">
                    <div class="profile-content">
                        <div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="<?php echo ((isset($data->thumb_author))? $data->thumb_author:''); ?>"></span> &nbsp; <a href="<?php echo $data->overview_account.'?account_id='.$data->author_id; ?>"> <b><?php echo $data->author_name; ?></b></a></div>
                        <div style="padding: 10px 0px; font-size: 11px; color: #cccccc;">
                            <i data-toggle="tooltip" title="<?php echo $data->icon_date; ?>" class="fa fa-btn fa-calendar"></i>on <?php echo date('M dS, Y H:i', strtotime($data->post_created_at)); ?>  &nbsp;&nbsp;
                            <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $data->post_viewed; ?> &nbsp;&nbsp;
                        </div>
                        <b><?php echo $data->title; ?></b>
                        <p><?php echo mb_substr(strip_tags(html_entity_decode($data->description, ENT_QUOTES, 'UTF-8')), 0, mb_strlen($data->description)); ?></p>
                        <?php $post_image = explode('/', $data->post_image); ?>
                        <p class="thumbnailimage"><a class="thumbnailimage" style="cursor: zoom-in;" href="<?php echo $data->image; ?>" title="<?php echo ((count($post_image)>0)? end($post_image):''); ?>"><img src="<?php echo $data->image; ?>" alt="" width="100%"></a></p>
                        <?php
                            if(count($data->post_images)) {
                                foreach ($data->post_images as $post_image) { $image = explode('/', $post_image['image']); ?>
                                    <p class="thumbnailimage"><a class="thumbnailimage" style="cursor: zoom-in;" href="<?php echo $post_image['thumb']; ?>" title="<?php echo ((count($image)>0)? end($image):''); ?>"><img src="<?php echo $post_image['thumb']; ?>" alt="" width="100%"></a></p>
                            <?php   }
                            }
                        ?>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="font-size: 12px;">
                                        <label><a href="#" role="button" data-trigger="show-rating">Rating <span id="load-total-rating" style="padding: 5px; border-radius: 50%;"><?php echo $data->count_rating->average_rating; ?></span></a></label>
                                        <input type="text" class="kv-gly-star rating-loading" value="<?php echo (($data->check_is_user_exit_raing)? $data->check_is_user_exit_raing->star:'0'); ?>" data-size="xs" title="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="font-size: 12px;">
                                        <label><a href="#" role="button" data-trigger="show-favorite">Favorite <span id="load-total-favorite" style="padding: 5px; border-radius: 50%;"><?php echo $data->count_favorite->total_favorite; ?></span></a></label><br />
                                        <div id="show-total-favorite"><i data-class="<?php echo (($data->check_is_user_exit_favorite)? 'primary':'default'); ?>" class="btn btn-<?php echo (($data->check_is_user_exit_favorite)? 'primary':'default'); ?>-favorite fa fa-btn fa-heart load-favorite"></i></div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <div>
                                    <span class="pull-left">
                                        <!-- AddThis Button BEGIN -->
                                            <div class="addthis_toolbox addthis_default_style">
                                                <!-- <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>  -->
                                                <a class="addthis_counter addthis_pill_style"></a>
                                            </div>
                                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
                                        <!-- AddThis Button END --> 
                                    </span>
                                </div>
                                <br />
                                <form action="#" method="post" enctype="multipart/form-data" id="form-comment" class="form-horizontal">
                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                    <div class="detailBox">
                                        <h4><i class="fa fa-btn fa-comment"></i><?php echo $data->entry_comment; ?> <span id="load-comment" style="padding: 5px; border-radius: 50%;"></span></h4>
                                        <p id="message"></p>
                                        <?php
                                            if($data->authorized) { ?>
                                            <div><span><img style="width:40px; 5px solid rgba(255,255,255,0.5); border-radius:50%;" src="<?php echo ((isset($data->auth_image))? $data->auth_image:''); ?>"></span> &nbsp; <a href="<?php echo $data->overview_account.'?account_id='.$data->auth_id; ?>"> <b><?php echo $data->auth_name; ?></b></a></div>
                                            <div id="load-form">

                                            </div>
                                        <?php } else { ?>
                                            <br />
                                            <div class="form-group required">
                                                <input type="hidden" name="post_id" value="<?php echo $data->post_id; ?>" />
                                                <div class="col-sm-12">
                                                    <label class="control-label" for="input-review"><?php echo $data->your_text; ?></label>
                                                    <textarea name="comment" rows="3" id="input-review" class="form-control" readonly="readonly" placeholder="<?php echo $data->text_comment; ?>"></textarea>
                                                </div>
                                            </div>
                                            <div class="alert alert-success" id="success">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <i class="fa fa-info-circle fa-btn"></i><?php echo trans('auth.point_comment_post'); ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><?php echo trans('auth.point_user_login'); ?></p>
                                                    <a class="btn btn-sm btn-primary" href="<?php echo url('/login'); ?>"><i class="fa fa-btn fa-sign-in"></i> <?php echo trans('auth.login'); ?>​​</a>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><?php echo trans('auth.point_user_register'); ?></p>
                                                    <a class="btn btn-sm btn-primary" href="<?php echo url('/register'); ?>"><i class="fa fa-btn fa-user"></i> <?php echo trans('auth.register'); ?>​​</a>
                                                </div>
                                            </div>

                                        <?php } ?>
                                    </div>    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div style="padding:15px; background: #fff;">
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
                        <div><h4><i class="fa fa-btn fa-retweet"></i><?php echo $data->entry_other_post; ?></h4></div>
                        <div class="row">
                        <?php
                            if(count($data->posts) > 0) {
                              foreach ($data->posts as $post) { 
                                  $post_category = (($post->category_id)? $post->category_id.'-'.str_replace(' ', '-', strtolower($post->category_name)):'0');
                                  $view_detail = $data->post_detail.'?account_id='.$post->author_id.'&post_id='.$post->post_id.'&category_id='.$post_category;
                                  $description = mb_substr(strip_tags(html_entity_decode($post->description, ENT_QUOTES, 'UTF-8')), 0, 150).((mb_strlen($post->description)>150)? '...':'');
                                ?>
                              <div class="col-md-12" style="margin-bottom: 10px;">
                                <div>
                                  <a href="<?php echo $data->overview_account.'?account_id='.$post->author_id; ?>"><img style="width:25px; margin-top:5px; border-radius:50%;" src="<?php echo ((isset($data->thumb_user[$post->post_id]))? $data->thumb_user[$post->post_id]:''); ?>"> &nbsp; <span style="font-size: 10px;"><?php echo $post->author_name; ?></span></a>
                                </div>

                                <div style="background:#fff; padding:5px; padding-bottom:0px;">

                                  <div class="image-container">
                                    <a href="<?php echo $view_detail; ?>"><img class="image" src="<?php echo ((isset($data->thumb[$post->post_id]))? $data->thumb[$post->post_id]:''); ?>" style="width:100%;"></a>
                                    <a href="<?php echo $view_detail; ?>" class="overlaylogo">
                                      <div class="text">
                                        <span style="color: #91beb1;"><?php echo $post->title; ?></span>
                                        <div><i class="fa fa-btn fa-calendar"></i><?php echo date('M dS, Y H:i', strtotime($post->created_at)); ?></div>
                                        <p><?php echo $description; ?></p>
                                      </div>
                                    </a>
                                    <div class="overlay">
                                      <div class="text"><a href="<?php echo $view_detail; ?>"><?php echo $post->title; ?></a></div>
                                    </div>
                                  </div>

                                  <div style="text-align:right; font-size:10px; color: #ccc;">
                                    <i data-toggle="tooltip" title="<?php echo $data->icon_view; ?>" class="fa fa-btn fa-eye"></i><?php echo $post->viewed; ?> &nbsp;
                                    <i data-toggle="tooltip" title="<?php echo $data->icon_rating; ?>" class="fa fa-btn fa-star"></i><?php echo (($post->average_rating!='')? $post->average_rating:'0'); ?> &nbsp;
                                    <i data-toggle="tooltip" title="<?php echo $data->icon_favorite; ?>" class="fa fa-btn fa-heart"></i><?php echo $post->total_favorite; ?> &nbsp;
                                    <i data-toggle="tooltip" title="<?php echo $data->icon_comment; ?>" class="fa fa-btn fa-comment"></i><?php echo $post->commented; ?> &nbsp;
                                    <a href="<?php echo $view_detail; ?>"><i data-toggle="tooltip" title="<?php echo $data->icon_image; ?>" class="fa fa-btn fa-picture-o"></i></a><?php echo ($post->total_post_image+1); ?>
                                  </div>
                                </div>
                                <hr />
                              </div>
                              <?php }
                            } else { ?>
                            <em><?php // echo $data->text_empty; ?></em>
                          <?php }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php    } else { ?>
        <em><?php echo $data->text_empty; ?></em>
<?php } ?>
<div id="load-unauthorized"></div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    $(document).on('submit', '#form-comment', function() {
        return false;
    });
    loadingFormToID("<?php echo $data->action_load_comment; ?>", "load-comment");
    loadingForm("<?php echo $data->action_comment_form; ?>");
    requestSubmitForm2('submit-comment', 'form-comment', "<?php echo $data->action; ?>");

    $('.thumbnailimage').magnificPopup({
        type:'image',
        delegate: 'a',
        gallery: {
            enabled:true
        }
    });
});
</script>
<script type="text/javascript" src="<?php echo asset('/javascript/jquery/rating/star-rating.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.kv-gly-star').rating({
            starCaptions: {
                0.5: "<?php echo trans('text.half_star'); ?>",
                1: "<?php echo trans('text.one_star'); ?>",
                1.5: "<?php echo trans('text.one_and_half_star'); ?>",
                2: "<?php echo trans('text.two_stars'); ?>",
                2.5: "<?php echo trans('text.two_and_half_stars'); ?>",
                3: "<?php echo trans('text.three_stars'); ?>",
                3.5: "<?php echo trans('text.three_and_half_stars'); ?>",
                4: "<?php echo trans('text.four_stars'); ?>",
                4.5: "<?php echo trans('text.four_and_half_stars'); ?>",
                5: "<?php echo trans('text.five_stars'); ?>"
            },
            filledStar: '<i class="fa fa-star"></i>',
            emptyStar: '<i class="fa fa-star-o"></i>',
            clearButtonTitle: "<?php echo trans('text.clear'); ?>",
            clearCaption: "<?php echo trans('text.not_rated'); ?>"
        });

        $(document).on('ready', function () {
            $('.kv-gly-star').on('change', function () {
                // alert($(this).val());
                $.ajax({
                    type: "GET",
                    url: "<?php echo $data->action_rating; ?>&post_id=<?php echo $data->post_id;?>&star="+encodeURIComponent($(this).val()),
                    beforeSend:function() {
                        $('#block-loader').show();
                    },
                    complete:function() {
                        $('#block-loader').hide();
                    },
                    success:function(html) {
                        var leng = html.length;
                        if(leng < 15) {
                            $('#load-total-rating').html(html).show();
                        }else {
                            $('#load-unauthorized').html(html).show();
                        }
                    },
                    error:function(request, status, error) {
                        $('#load-total-rating').html('').show();
                    }
                });
                return false;
            });
        });

        $(document).on('click', '.load-favorite', function() {
            var class_id = '';
            if($(this).data('class')=='default') {
                class_id = 'primary';
            }else{
                class_id = 'default';
            }
            
            $.ajax({
                type: "GET",
                url: "<?php echo $data->action_favorite; ?>&post_id=<?php echo $data->post_id;?>",
                beforeSend:function() {
                    $('#block-loader').show();
                },
                complete:function() {
                    $('#block-loader').hide();
                },
                success:function(html) {
                    var leng = html.length;
                    if(leng < 15) {
                        $('#show-total-favorite i').replaceWith('<i data-class="'+class_id+'" class="btn btn-'+class_id+'-favorite fa fa-btn fa-heart load-favorite"></i>');
                        $('#load-total-favorite').html(html).show();
                    }else {
                        $('#load-unauthorized').html(html).show();
                    }
                },
                error:function(request, status, error) {
                    $('#load-total-favorite').html('').show();
                }
            });
            return false;
        });

        $(document).delegate('a[data-trigger=\'show-rating\']', 'click', function() {
            $('#modal-show-rating').remove();
            $.ajax({
                type: "GET",
                url: '<?php echo $data->action_show_rating; ?>',
                dataType: 'html',
                beforeSend: function() {
                    // before send
                    $('#block-loader').show();
                },
                complete: function() {
                    // completed
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-show-rating" class="modal">' + html + '</div>');

                    $('#modal-show-rating').modal('show');
                },
                error:function(request, status, error) {
                    // $('#load-total-favorite').html('').show();
                }
            });
            return false;
        });

        $(document).delegate('a[data-trigger=\'show-favorite\']', 'click', function() {
            $('#modal-show-favorite').remove();
            $.ajax({
                type: "GET",
                url: '<?php echo $data->action_show_favorite; ?>',
                dataType: 'html',
                beforeSend: function() {
                    // before send
                    $('#block-loader').show();
                },
                complete: function() {
                    // completed
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-show-favorite" class="modal">' + html + '</div>');

                    $('#modal-show-favorite').modal('show');
                },
                error:function(request, status, error) {
                    // $('#load-total-favorite').html('').show();
                }
            });
            return false;
        });

    });
</script>
@endsection