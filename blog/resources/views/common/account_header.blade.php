<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objUser = new App\User();
    $objFavorite = new App\Models\Favorite();

    $author_id = ((\Request::has('account_id'))? \Request::get('account_id'):'0');
    $author_logged_id = ((\Auth::check())? \Auth::user()->id:'0');
    $user_info = $objUser->getUser($author_id);
    $user_technical_info = $objUser->getTechnicalByUserId($author_id);
    $check_is_user_exit_favorite = $objFavorite->checkIfAlreadyFavoriteProfile($author_logged_id, $author_id, '2');

    if($user_info) {
        $user_info_id = $user_info->id;
        $user_info_name = $user_info->name;
        if ($user_info->image && is_file($objConfig->dir_image . $user_info->image)) {
            $thumb_profile = $objFile->resize($user_info->image, 100, 100);
        } else {
            $thumb_profile = $objFile->resize('no_image.png', 100, 100);
        }
        if ($user_info->first_cover && is_file($objConfig->dir_image . $user_info->first_cover)) {
            $thumb_cover = $objFile->resize($user_info->first_cover, 850, 280);
        } else {
            $thumb_cover = $objFile->resize('no_image.png', 850, 280);
        }
    }else {
        $user_info_id = '0';
        $user_info_name = '';
        $thumb_profile = $objFile->resize('no_image.png', 100, 100);
        $thumb_cover = $objFile->resize('no_image.png', 850, 280);
    }
    
?>
<div class="row" style="background: #fbfcfc; margin:15px; margin-bottom:25px;">
    <div class="col-md-3" style="padding-top:10px;">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <div class="profile-pic">
                    <a href="#" role="button" data-trigger="view-original-profile" style="cursor: zoom-in;"><img style="background: #fff;" alt="" src="<?php echo $thumb_profile; ?>"></a>
                    <?php
                        if($author_id==$author_logged_id) { ?>
                            <div class="edit"><a href="#" role="button" data-toggle="select-profile" data-id="<?php echo $author_id; ?>"><i class="fa fa-photo fa-lg"></i> <?php echo trans('text.update_profile'); ?> </a></div>
                    <?php } ?>
                </div>
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="<?php echo url('/overview-account?account_id='.$user_info_id); ?>"><?php echo $user_info_name; ?></a>
                </div>
                <?php
                    if(count($user_technical_info) > 0) {
                        foreach ($user_technical_info as $technical) {
                            echo '<div class="desc">'.$technical->skill.'</div>';
                        }
                    }else {
                        echo '<div class="desc">...</div>';
                    }
                ?>
                <div style="padding:10px;"><button type="button" data-trigger="message" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-envelope"></i> <?php echo trans('text.message'); ?></button></div>
                <?php
                  if($check_is_user_exit_favorite->total_favorited > 0) { ?>
                    <!-- Single button -->
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #91beb1;">
                        <i class="fa fa-btn fa-heart"></i> <?php echo trans('text.favorited'); ?> <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo url('/account/unfavorite?favorite_of_id='.$author_id); ?>"><?php echo trans('text.unfavorite_this_profile'); ?></a></li>
                      </ul>
                    </div>
                  <?php }else { ?>
                    <div id="show-button-favorite"><a href="<?php echo url('/account/favorite?favorite_of_id='.$author_id); ?>" type="button" data-trigger="favorite" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-heart"></i> <?php echo trans('text.favorite'); ?>&nbsp;</a></div>
                <?php  } ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row" style="padding:10px;">
            <div class="cover-userpic">
                <div class="profile-pic">
                    <div style="background: #fff; border: 5px solid #91beb1;">
                      <a href="#" role="button" data-trigger="view-original-cover" style="cursor: zoom-in;"><img width="100%" src="<?php echo $thumb_cover; ?>"></a>
                    </div>
                    <?php
                        if($author_id==$author_logged_id) { ?>
                            <div class="edit"><a href="#" role="button" data-toggle="select-cover" data-id="<?php echo $author_id; ?>"><i class="fa fa-photo fa-lg"></i> <?php echo trans('text.update_cover'); ?> </a></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Image Manager
        $(document).delegate('a[data-toggle=\'select-profile\']', 'click', function() {
            $('#modal-image').remove();
            $.ajax({
                type: "GET",
                url: 'filemanager?target=select-profile',
                dataType: 'html',
                beforeSend: function() {
                    $('#block-loader').show();
                },
                complete: function() {
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });
            return false;
        });
        $(document).delegate('a[data-toggle=\'select-cover\']', 'click', function() {
            $('#modal-image').remove();
            $.ajax({
                type: "GET",
                url: 'filemanager?target=select-cover',
                dataType: 'html',
                beforeSend: function() {
                    $('#block-loader').show();
                },
                complete: function() {
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });
            return false;
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
    // Load profile
    $(document).delegate('a[data-toggle=\'choose-profile\']', 'click', function() {
      
      $('#modal-image').remove();
      var image = $(this).data("image");
      $.ajax({
          type: "GET",
          url: 'account/crop-profile?image='+encodeURIComponent(image),
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
              $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

              $('#modal-image').modal('show');
          }
      });
      return false;
    });
    $(document).delegate('a[data-toggle=\'choose-cover\']', 'click', function() {
      
      $('#modal-image').remove();
      var image = $(this).data("image");
      $.ajax({
          type: "GET",
          url: 'account/crop-cover?image='+encodeURIComponent(image),
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
              $('body').append('<div id="modal-image" class="modal">' + html + '</div>');

              $('#modal-image').modal('show');
          }
      });
      return false;
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function() {
        // Load Image Manager
        $(document).delegate('a[data-toggle=\'reselect-profile\']', 'click', function() {
              $('#modal-image').remove();
              $.ajax({
                type: "GET",
                url: 'filemanager?target=select-profile',
                dataType: 'html',
                beforeSend: function() {
                    $('#block-loader').show();
                },
                complete: function() {
                    $('#block-loader').hide();
                },
                success: function(html) {
                    $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                    $('#modal-image').modal('show');
                }
            });
            return false;
        });

        $(document).delegate('a[data-toggle=\'reselect-cover\']', 'click', function() {
            $('#modal-image').remove();
                $.ajax({
                    type: "GET",
                    url: 'filemanager?target=select-cover',
                    dataType: 'html',
                    beforeSend: function() {
                        $('#block-loader').show();
                    },
                    complete: function() {
                        $('#block-loader').hide();
                    },
                    success: function(html) {
                        $('body').append('<div id="modal-image" class="modal in">' + html + '</div>');

                        $('#modal-image').modal('show');
                    }
              });
              return false;
        });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).delegate('button[data-trigger=\'message\']', 'click', function() {
      $('#modal-message-form').remove();
      var information_id = $(this).data("id");
      var language_id = $(this).data("languageid");
      $.ajax({
        type: "GET",
        url: 'message/load-message-form/<?php echo $author_id; ?>',
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
          $('body').append('<div id="modal-message-form" class="modal">' + html + '</div>');

          $('#modal-message-form').modal('show');
        }
      });
      return false;
    });

    $(document).delegate('a[data-trigger=\'view-original-profile\']', 'click', function() {
      $('#modal-view-original-profile').remove();
      $.ajax({
          type: "GET",
          url: "account/view-original-profile?account_id=<?php echo $author_id; ?>",
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
              $('body').append('<div id="modal-view-original-profile" class="modal">' + html + '</div>');

              $('#modal-view-original-profile').modal('show');
          },
          error:function(request, status, error) {
              // $('#load-total-favorite').html('').show();
          }
      });
      return false;
    });

    $(document).delegate('a[data-trigger=\'view-original-cover\']', 'click', function() {
      $('#modal-view-original-cover').remove();
      $.ajax({
          type: "GET",
          url: "account/view-original-cover?account_id=<?php echo $author_id; ?>",
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
              $('body').append('<div id="modal-view-original-cover" class="modal">' + html + '</div>');

              $('#modal-view-original-cover').modal('show');
          },
          error:function(request, status, error) {
              // $('#load-total-favorite').html('').show();
          }
      });
      return false;
    });

  });
</script>