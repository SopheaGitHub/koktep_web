<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objUser = new App\User();

    $author_id = ((\Request::has('account_id'))? \Request::get('account_id'):'0');
    $author_logged_id = ((\Auth::check())? \Auth::user()->id:'0');
    $user_info = $objUser->getUser($author_id);
    $user_technical_info = $objUser->getTechnicalByUserId($author_id);

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
<div class="row profile" style="background: #fbfcfc; margin:15px;">
    <div class="col-md-3" style="padding-top:10px;">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <div class="profile-pic">
                    <img alt="" src="<?php echo $thumb_profile; ?>">
                    <?php
                        if($author_id==$author_logged_id) { ?>
                            <div class="edit"><a href="#" role="button" data-toggle="select-profile" data-id="<?php echo $author_id; ?>"><i class="fa fa-pencil fa-lg"></i></a></div>
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
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row" style="padding:10px;">
            <div class="cover-userpic">
                <div class="profile-pic">
                    <div>
                        <img width="100%" src="<?php echo $thumb_cover; ?>">
                    </div>
                    <?php
                        if($author_id==$author_logged_id) { ?>
                            <div class="edit"><a href="#" role="button" data-toggle="select-cover" data-id="<?php echo $author_id; ?>"><i class="fa fa-pencil fa-lg"></i></a></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row overview">
            <!-- <div class="col-md-4 user-pad text-center">
                <h5>FOLLOWERS</h5>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-envelope"></i> Follower</button></div>
                <h4>2,784</h4>
            </div> -->
            <!-- <div class="col-md-4 user-pad text-center">
                <h5>APPRECIATIONS</h5>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-star"></i> Stars</button></div>
                <h4>4,901</h4>
            </div> -->
            <!-- <div class="col-md-4 user-pad text-center">
                <h5>APPRECIATIONS</h5>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-heart"></i> Favorites</button></div>
                <h4>4,901</h4>
            </div> -->
            <!-- <div class="col-md-4 user-pad text-center">
                <h5>FOLLOWING</h5>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-user"></i> Following</button></div>
                <h4>456</h4>
            </div> -->
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Load Image Manager
        $(document).delegate('a[data-toggle=\'select-profile\']', 'click', function() {
            $('#modal-image').remove();
            $.ajax({
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
  });
</script>