<?php
    $route_name = \Route::getCurrentRoute()->getPath();
    $user_id = ((\Request::has('account_id'))? \Request::get('account_id'):((Auth::check())? Auth::user()->id:'0'));

    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objUser = new App\User();

    $user_info = $objUser->getUser($user_id);
    $user_technical_info = $objUser->getTechnicalByUserId($user_id);

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
                <i class="fa fa-btn fa-home"></i>Overview </a>
            </li>
            <li <?php echo (($route_name=='about-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/about-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-user"></i>About </a>
            </li>
            <li <?php echo (($route_name=='contact-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/contact-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-phone"></i>Contact </a>
            </li>
            <li <?php echo (($route_name=='posts-groups-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/posts-groups?account_id='.$user_id); ?>" onclick="return false;" target="_blank">
                <i class="fa fa-btn fa-object-group"></i>Posts Groups </a>
            </li>
        </ul>
    </div>
    <!-- END MENU -->
    <div class="social">
        <div class="bottom">
            <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/webmaniac">
                <i class="fa fa-twitter"></i>
            </a>
            <a class="btn btn-danger btn-sm" rel="publisher"
               href="https://plus.google.com/+ahmshahnuralam">
                <i class="fa fa-google-plus"></i>
            </a>
            <a class="btn btn-primary btn-sm" rel="publisher"
               href="https://plus.google.com/shahnuralam">
                <i class="fa fa-facebook"></i>
            </a>
            <a class="btn btn-warning btn-sm" rel="publisher" href="https://plus.google.com/shahnuralam">
                <i class="fa fa-behance"></i>
            </a>
        </div>
    </div>
    
</div>