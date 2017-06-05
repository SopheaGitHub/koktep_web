<?php
    $route_name = \Route::getCurrentRoute()->getPath();
    $user_id = ((\Request::has('account_id'))? \Request::get('account_id'):((Auth::check())? Auth::user()->id:'0'));

    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objUser = new App\User();

    $user_info = $objUser->getUser($user_id);
    $user_technical_info = $objUser->getTechnicalByUserId($user_id);
    $user_to_social_media = $objUser->getSocialMediaByUserId($user_id);

    // load image library
    if($user_info) {
        $user_info_id = $user_info->id;
        $user_info_name = $user_info->name;
        if ($user_info->image && is_file($objConfig->dir_image . $user_info->image)) {
            $thumb_profile = $objFile->resize($user_info->image, 100, 100);
        } else {
            $thumb_profile = $objFile->resize('no_image.png', 100, 100);
        }
    }else {
        $user_info_id = '0';
        $user_info_name = '';
        $thumb_profile = $objFile->resize('no_image.png', 100, 100);
    }
?>
<div class="profile-sidebar">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic">
        <a href="<?php echo url('/about-account?account_id='.$user_info_id); ?>"><img alt="" src="<?php echo $thumb_profile; ?>"></a>
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">
            <a href="<?php echo url('/about-account?account_id='.$user_info_id); ?>"><?php echo $user_info_name; ?></a>
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
    </div>
    <!-- END SIDEBAR USER TITLE -->
    <!-- SIDEBAR BUTTONS -->
    <!-- <div class="profile-userbuttons">
        <button type="button" class="btn btn-success btn-sm">Follow</button>
        <button type="button" class="btn btn-danger btn-sm">Message</button>
    </div> -->
    <!-- END SIDEBAR BUTTONS -->
    <!-- SIDEBAR MENU -->
    <div class="profile-usermenu">
        <ul class="nav">
            <li <?php echo (($route_name=='overview-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/overview-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-home"></i><?php echo trans('text.overview'); ?> </a>
            </li>
            <li <?php echo (($route_name=='posts-groups-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/posts-groups-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-object-group"></i><?php echo trans('text.posted_groups'); ?> </a>
            </li>
            <li <?php echo (($route_name=='about-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/about-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-user"></i><?php echo trans('text.about'); ?> </a>
            </li>
            <li <?php echo (($route_name=='contact-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/contact-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-phone"></i><?php echo trans('text.contact'); ?> </a>
            </li>
        </ul>
    </div>
    <!-- END MENU -->
    <div class="social">
        <div class="bottom">
            <?php
                if(count($user_to_social_media) > 0) {
                    foreach ($user_to_social_media as $social_media) { ?>
                        <a class="btn btn-default btn-twitter btn-sm" href="<?php echo $social_media->link; ?>" target="_blank">
                            <i data-toggle="tooltip" title="<?php echo $social_media->social_media_name; ?>" class="fa <?php echo $social_media->social_media_icon; ?>"></i>
                        </a>
                <?php    }
                }else {
                    echo '...';
                }
            ?>
        </div>
    </div>
    
</div>