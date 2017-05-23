<?php
    $route_name = \Route::getCurrentRoute()->getPath();
?>
<div class="profile-sidebar">
    <!-- SIDEBAR USERPIC -->
    <div class="profile-userpic">
        <img alt="" src="http://lorempixel.com/100/100/people/9/">
    </div>
    <!-- END SIDEBAR USERPIC -->
    <!-- SIDEBAR USER TITLE -->
    <div class="profile-usertitle">
        <div class="profile-usertitle-name">
            <a target="_blank" href="http://scripteden.com/">Script Eden</a>
        </div>
        <div class="desc">Passionate designer</div>
        <div class="desc">Curious developer</div>
        <div class="desc">Tech geek</div>
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
                <a href="<?php echo url('/overview-account?account_id=1'); ?>">
                <i class="fa fa-btn fa-home"></i>Overview </a>
            </li>
            <li <?php echo (($route_name=='about-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/about-account?account_id=1'); ?>">
                <i class="fa fa-btn fa-user"></i>About </a>
            </li>
            <li <?php echo (($route_name=='contact-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/contact-account?account_id=1'); ?>">
                <i class="fa fa-btn fa-phone"></i>Contact </a>
            </li>
            <li <?php echo (($route_name=='posts-groups-account')? 'class="active"':''); ?> >
                <a href="<?php echo url('/posts-groups?account_id=1'); ?>" onclick="return false;" target="_blank">
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