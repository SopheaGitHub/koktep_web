<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objUser = new App\User();

    $author_id = ((Auth::check())? Auth::user()->id:'0');
    $user_info = $objUser->getUser($author_id);

    if($user_info) {
        if ($user_info->image && is_file($objConfig->dir_image . $user_info->image)) {
            $thumb_profile = $objFile->resize($user_info->image, 100, 100);
        } else {
            $thumb_profile = $objFile->resize('no_image.png', 100, 100);
        }
    }else {
        $thumb_profile = $objFile->resize('no_image.png', 100, 100);
    }
    
?>
<div class="row profile" style="background: #fff; margin:15px;">
    <div class="col-md-3">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <div class="profile-pic">
                    <img alt="" src="<?php echo $thumb_profile; ?>">
                    <?php
                        if($author_id==\Request::get('account_id')) { ?>
                            <div class="edit"><a href="#" role="button" data-toggle="select-profile" data-id="<?php echo $author_id; ?>"><i class="fa fa-pencil fa-lg"></i></a></div>
                    <?php } ?>
                </div>
            </div>
            <!-- END SIDEBAR USERPIC -->
            <!-- SIDEBAR USER TITLE -->
            <div class="profile-usertitle">
                <div class="profile-usertitle-name">
                    <a href="http://localhost/development/koktep_web/blog/public/about-account?account_id=1">Chan Sophea</a>
                </div>
                <div class="desc">Passionate Designer</div>
                <div class="desc">Curious Developer</div>
                <div class="desc">Tech Geek</div>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-envelope"></i> Message</button></div>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div>
                <img width="100%" src="<?php echo url('images/5.jpg'); ?>">
            </div>
        </div>
        <div class="row overview">
            <!-- <div class="col-md-4 user-pad text-center">
                <h5>FOLLOWERS</h5>
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-envelope"></i> Follower</button></div>
                <h4>2,784</h4>
            </div> -->
            <div class="col-md-4 user-pad text-center">
                <!-- <h5>APPRECIATIONS</h5> -->
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-star"></i> Stars</button></div>
                <h4>4,901</h4>
            </div>
            <div class="col-md-4 user-pad text-center">
                <!-- <h5>APPRECIATIONS</h5> -->
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-heart"></i> Favorites</button></div>
                <h4>4,901</h4>
            </div>
            <div class="col-md-4 user-pad text-center">
                <!-- <h5>FOLLOWING</h5> -->
                <div style="padding:10px;"><button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-original-title=""><i class="fa fa-btn fa-user"></i> Following</button></div>
                <h4>456</h4>
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

    });
</script>