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
    <div class="profilemenu">
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
                <i class="fa fa-btn fa-address-book"></i><?php echo trans('text.contact'); ?> </a>
            </li>
            <li <?php echo (($route_name=='favorite-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/favorite-account?account_id='.$user_id); ?>">
                <i class="fa fa-btn fa-heart"></i><?php echo trans('text.favorited'); ?> </a>
            </li>
        </ul>
    </div>
</div>