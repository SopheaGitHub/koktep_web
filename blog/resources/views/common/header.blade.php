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
                if(empty($route_name) || $route_name =='/') {
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
                <li <?php echo (($route_category_id=='1')? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id=1-art'); ?>"><i class="fa fa-btn fa-diamond"></i> Art</a></li>
                <li <?php echo (($route_category_id=='2')? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id=2-graphic-design'); ?>"><i class="fa fa-btn fa-desktop"></i> Graphic Design</a></li>
                <li <?php echo (($route_category_id=='3')? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id=3-architectural'); ?>"><i class="fa fa-btn fa-building"></i> Architectural</a></li>
                <li <?php echo (($route_category_id=='4')? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id=4-photography'); ?>"><i class="fa fa-btn fa-camera"></i> Photography</a></li>
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
                            <li><a href="<?php echo url('/overview-account?account_id='.Auth::user()->id); ?>"><img src="data:image/png;base64,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" class="w3-circle" style="height:50px; width:50px;-webkit-border-radius: 50%;
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