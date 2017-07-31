<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objLanguage = new App\Models\Language();
    $objCategory = new App\Models\Category();

    if(\Session::has('locale')) {
        $locale = \Session::get('locale');
    }else {
        $locale = 'en';
    }

    $language = $objLanguage->getLanguageByCode( $locale );
    $categories = [];
    if($language) {
        $categories = $objCategory->getCategoriesByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>'0', 'language_id'=>$language->language_id])->get();
    }

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
            <a class="navbar-brand" href="<?php echo url('/'); ?>" style="color:#EFD518;">
              <!-- <img src="<?php // echo url('/images/logo_koktep.png'); ?>" width="75%" style="margin-top:-8px;"> -->
              <i class="fa fa-btn fa-twitter"></i> KOKTEP
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

                    $array_user_auth_menu = ['overview-account', 'posts', 'posts-groups-account', 'posts-groups', 'account', 'about-account', 'contact-account'];
                    if(in_array(explode('/', $route_name)['0'], $array_user_auth_menu)) {
                       $route_category_id = 'user_auth_menu';
                    }
                }

            ?>
            <ul class="nav navbar-nav">
                <li <?php echo (($route_category_id=='home')? 'class="active"':''); ?>><a href="<?php echo url('/'); ?>"><i class="fa fa-btn fa-home"></i> <?php echo trans('text.home'); ?></a></li>
                <?php
                    if(count($categories) > 0) {
                        foreach ($categories as $category) { 
                            $category_id = (($category->category_id)? $category->category_id.'-'.str_replace(' ', '-', strtolower(htmlspecialchars($category->name))):'0');
                            $categories1 = $objCategory->getCategoriesByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$category->category_id, 'language_id'=>$language->language_id])->get();

                            if(count($categories1) > 0) { 
                                foreach ($categories1 as $key => $value) {
                                    $sub_categories[$value->parent_id][$value->category_id] = $value->name;
                                }
                            ?>
                                <li class="dropdown <?php echo ((isset($sub_categories[$category->category_id][$route_category_id]))? 'active':''); ?>">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-btn <?php echo $category->icon; ?>"></i> <?php echo $category->name; ?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <?php
                                            foreach ($categories1 as $category1) { 
                                                $category_id1 = (($category1->category_id)? $category1->category_id.'-'.str_replace(' ', '-', strtolower(htmlspecialchars($category1->name))):'0');
                                             ?>
                                                <li <?php echo (($route_category_id==$category1->category_id)? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id='.$category_id1); ?>"><i class="fa fa-btn <?php echo $category1->icon; ?>"></i><?php echo $category1->name; ?></a></li>
                                        <?php    }
                                        ?>
                                        <li style="border-top:1px solid #eee;"><a href="<?php echo url('/category?category_id='.$category_id); ?>"><?php echo (($locale=='en') ? trans('text.other').' '.$category->name:$category->name.''.trans('text.other')); ?> ...</a></li>
                                    </ul>
                                </li>
                            <?php } else { ?>
                                <li <?php echo (($route_category_id==$category->category_id)? 'class="active"':''); ?>><a href="<?php echo url('/category?category_id='.$category_id); ?>"><i class="fa fa-btn <?php echo $category->icon; ?>"></i> <?php echo $category->name; ?></a></li>
                            <?php }    
                        }
                    }
                ?>
            </ul>

            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="<?php echo url('/posts/create'); ?>" class="btn btn-primary navbar-btn btn-xs"><i class="fa fa-btn fa-upload"></i> <?php echo trans('button.upload'); ?> </a>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li <?php echo (($route_category_id=='login')? 'class="active"':''); ?>><a href="<?php echo url('/login'); ?>"><i class="fa fa-btn fa-sign-in"></i><?php echo trans('text.login'); ?></a></li>
                    <li <?php echo (($route_category_id=='register')? 'class="active"':''); ?>><a href="<?php echo url('/register'); ?>"><i class="fa fa-btn fa-pencil-square-o"></i><?php echo trans('text.register'); ?></a></li>
                @else
                    <li class="dropdown <?php echo (($route_category_id=='user_auth_menu')? 'active':''); ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="thumb-sm avatar pull-left"><img class="img-circle" width="30px" style="margin-top:-5px;" src="<?php echo $thumb_profile; ?>" alt="..."></span> &nbsp;&nbsp; <?php echo Auth::user()->name; ?>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo url('/overview-account?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-user-o"></i> <?php echo trans('text.profile'); ?> </a></li>
                            <li><a href="<?php echo url('/posts?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-tasks"></i><?php echo trans('text.posts_management'); ?></a></li>
                            <li><a href="<?php echo url('/posts-groups?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-object-group"></i><?php echo trans('text.posted_groups_management'); ?></a></li>
                            <li><a href="#" role="button" data-toggle="menufilemanager"><i class="fa fa-btn fa-image"></i><?php echo trans('filemanager.title'); ?></a></li>
                            <li><a href="<?php echo url('/account/settings?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-cogs"></i><?php echo trans('text.account_settings'); ?></a></li>
                            <li><a href="<?php echo url('/account/change-password?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-exchange"></i><?php echo trans('text.account_change_password'); ?></a></li>
                            <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-btn fa-sign-out"></i><?php echo trans('text.logout'); ?></a></li>
                        </ul>
                    </li>
                @endif
            </ul>
            
        </div>
    </div>
</nav>