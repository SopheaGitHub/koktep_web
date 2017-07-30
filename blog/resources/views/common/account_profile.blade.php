<?php
    $author_id = ((Auth::check())? Auth::user()->id:'0');
?>
<div class="row profile" style="background: #fff; margin:15px;">
    <div class="col-md-3">
        <div class="profile-sidebar">
            <!-- SIDEBAR USERPIC -->
            <div class="profile-userpic">
                <div class="profile-pic">
                    <img alt="" src="http://localhost/development/koktep_storage//images/cache/catalog/profile/avatar_g2-100x100.jpg">
                    <?php
                        if($author_id==\Request::get('account_id')) { ?>
                            <!-- <div class="edit"><a href="<?php // echo url('/account/settings?account_id='.((Auth::check())? Auth::user()->id:'0').'&tabpanel=image'); ?>"><i class="fa fa-pencil fa-lg"></i></a></div> -->
                            <div class="edit"><a href="#" role="button" data-toggle="crop-profile" data-id="<?php echo $author_id; ?>"><i class="fa fa-pencil fa-lg"></i></a></div>
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
        // Load profile
        $(document).delegate('a[data-toggle=\'crop-profile\']', 'click', function() {
            $('#modal-profile').remove();
            var account_id = $(this).data("id");
            $.ajax({
                url: 'account/crop-profile?account_id='+encodeURIComponent(account_id),
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
                    $('body').append('<div id="modal-profile" class="modal">' + html + '</div>');

                    $('#modal-profile').modal('show');
                }
            });
            return false;
        });
    });
</script>