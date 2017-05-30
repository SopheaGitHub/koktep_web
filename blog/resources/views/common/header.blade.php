<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();

    // load image library
    if(Auth::check()) {
        if (Auth::user()->image && is_file($objConfig->dir_image . Auth::user()->image)) {
            $thumb_profile = $objFile->resize(Auth::user()->image, 100, 100);
        } else {
            $thumb_profile = $objFile->resize('no_image.png', 100, 100);
        }
    }else {
        $thumb_profile = $objFile->resize('no_image.png', 100, 100);
    }
    
?>
<nav class="navbar navbar-default navbar-static-top navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?php echo url('/'); ?>">
              <img src="<?php echo url('/images/logo_koktep.png'); ?>" width="90%" style="margin-top:-7px;">
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <?php
                $route_category_id = '0';
                $route_name = \Route::getCurrentRoute()->getPath();
                if(empty($route_name) || $route_name =='/' || \Request::get('category_id')=='0') {
                    $route_category_id = 'home';
                }else {
                    if(\Request::has('category_id')) {
                        $route_category_id = explode('-', \Request::get('category_id'))['0'];
                    }

                    if($route_name=='login') {
                        $route_category_id = 'login';
                    }

                    if($route_name=='register') {
                        $route_category_id = 'register';
                    }

                    $array_user_auth_menu = ['overview-account', 'posts', 'posts-groups', 'account', 'about-account', 'contact-account'];
                    if(in_array(explode('/', $route_name)['0'], $array_user_auth_menu)) {
                       $route_category_id = 'user_auth_menu';
                    }
                }

            ?>
            <ul class="nav navbar-nav">
                <li <?php echo (($route_category_id=='home')? 'class="active"':''); ?>><a href="<?php echo url('/'); ?>"><i class="fa fa-btn fa-home"></i> Home</a></li>
                <li class="dropdown <?php echo (($route_category_id=='1')? 'active':''); ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-diamond"></i> Art <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/category?category_id=1-art'); ?>"><i class="fa fa-btn fa-angle-double-right"></i>Drawing &amp; Painting</a></li>
                    <li style="border-top:1px solid #eee;"><a href="#">Other Art ...</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo (($route_category_id=='2')? 'active':''); ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-desktop"></i> Design <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/category?category_id=2-graphic-design'); ?>"><i class="fa fa-btn fa-angle-double-right"></i>Graphic Design</a></li>
                    <li><a href="#"><i class="fa fa-btn fa-angle-double-right"></i>Illustrator</a></li>
                    <li style="border-top:1px solid #eee;"><a href="#">Other Design ...</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo (($route_category_id=='3')? 'active':''); ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-building"></i> Architectural <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/category?category_id=3-architectural'); ?>"><i class="fa fa-btn fa-angle-double-right"></i>Interior Design</a></li>
                    <li><a href="#"><i class="fa fa-btn fa-angle-double-right"></i>Exterior Design</a></li>
                    <li style="border-top:1px solid #eee;"><a href="#">Other Architectural ...</a></li>
                  </ul>
                </li>
                <li class="dropdown <?php echo (($route_category_id=='4')? 'active':''); ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn fa-camera"></i> Photography <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/category?category_id=4-photography'); ?>"><i class="fa fa-btn fa-angle-double-right"></i>Outdoor</a></li>
                    <li><a href="#"><i class="fa fa-btn fa-angle-double-right"></i>Free Weeding</a></li>
                    <li><a href="<?php echo url('/category?category_id=4-photography'); ?>"><i class="fa fa-btn fa-angle-double-right"></i>Natural Image</a></li>
                    <li><a href="#"><i class="fa fa-btn fa-angle-double-right"></i>Funny Photo</a></li>
                    <li style="border-top:1px solid #eee;"><a href="#">Other Photography ...</a></li>
                  </ul>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li <?php echo (($route_category_id=='login')? 'class="active"':''); ?>><a href="<?php echo url('/login'); ?>"><i class="fa fa-btn fa-sign-in"></i>Login</a></li>
                    <li <?php echo (($route_category_id=='register')? 'class="active"':''); ?>><a href="<?php echo url('/register'); ?>"><i class="fa fa-btn fa-pencil-square-o"></i>Register</a></li>
                @else
                    <li class="dropdown <?php echo (($route_category_id=='user_auth_menu')? 'active':''); ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <i class="fa fa-btn fa-user"></i> <?php echo Auth::user()->name; ?> <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo url('/overview-account?account_id='.Auth::user()->id); ?>"><img src="<?php echo $thumb_profile; ?>" style="height:50px; width:50px;-webkit-border-radius: 50%;
-moz-border-radius: 50%;
border-radius: 50%;
border: 5px solid rgba(255,255,255,0.5);" alt="Avatar"> My Profile </a></li>
                            <li><a href="<?php echo url('/posts?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-tasks"></i>Posts Management</a></li>
                            <li><a href="<?php echo url('/posts-groups?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-object-group"></i>Posts Groups Management</a></li>
                            <li><a href="<?php echo url('/account/settings?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-cogs"></i>Account Settings</a></li>
                            <li><a href="<?php echo url('/account/change-password?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-exchange"></i>Account Change Password</a></li>
                            <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>