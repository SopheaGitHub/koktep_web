<?php
    $objFile = new App\Http\Controllers\Common\FilemanagerController();
    $objConfig = new App\Http\Controllers\ConfigController();
    $objLanguage = new App\Models\Language();
    $objCategory = new App\Models\Category();
    $objMessage = new App\Models\Message();
    $objNotification = new App\Models\Notification();

    if(\Session::has('locale')) {
        $locale = \Session::get('locale');
    }else {
        $locale = 'en';
    }

    $auth_id = ((Auth::check())? Auth::user()->id:'0');

    $language = $objLanguage->getLanguageByCode( $locale );
    $language_id = '1';
    
    if($language) {
        $language_id = $language->language_id;
    }
    
    $categories = [];
    $categories = $objCategory->getCategoriesByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>'0', 'language_id'=>$language_id])->get();

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

    $total_message = $objMessage->getTotalInboxByAutorId($auth_id);
    $messages = $objMessage->getMessagesInboxByAutorId($auth_id)->get();
    if(count($messages) > 0) {
        foreach ($messages as $message) {
            if (!empty($message->user_profile) && is_file($objConfig->dir_image . $message->user_profile)) {
                $message_thumb_user[$message->message_id] = $objFile->resize($message->user_profile, 100, 100);
            } else {
                $message_thumb_user[$message->message_id] = $objFile->resize('no_image.png', 100, 100);
            }
        }
    }

    $notifications = $objNotification->getNotificationByUserId($auth_id, $language_id);
    if(count($notifications['datas']) > 0) {
        foreach ($notifications['datas'] as $notification) {
            if (!empty($notification->user_profile) && is_file($objConfig->dir_image . $notification->user_profile)) {
                $notification_thumb_user[$notification->id] = $objFile->resize($notification->user_profile, 100, 100);
            } else {
                $notification_thumb_user[$notification->id] = $objFile->resize('no_image.png', 100, 100);
            }
        }
    }
?>   
<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" style="background: teal;">
    <div class="container-fluid" style="padding-right: 0px; padding:0px;">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="<?php echo url('/'); ?>">KOKTEP.COM</a>
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
            <!-- <a href="<?php //echo url('/posts/create'); ?>" class="btn btn-primary navbar-btn btn-xs"><i class="fa fa-btn fa-upload"></i> <?php //echo trans('button.upload'); ?> </a> -->
            <!-- <span class="abutton"><a href="#" role="button" data-toggle="load-upload-form" class="btn btn-primary navbar-btn btn-xs"><i class="fa fa-btn fa-upload"></i> <?php // echo trans('button.upload'); ?> </a></span> -->

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li <?php echo (($route_category_id=='login')? 'class="active"':''); ?>><a href="<?php echo url('/login'); ?>"><i class="fa fa-btn fa-sign-in"></i><?php echo trans('text.login'); ?></a></li>
                    <li <?php echo (($route_category_id=='register')? 'class="active"':''); ?>><a href="<?php echo url('/register'); ?>"><i class="fa fa-btn fa-pencil-square-o"></i><?php echo trans('text.register'); ?></a></li>
                @else
                    <li class="dropdown <?php echo (($route_category_id=='user_auth_menu')? 'active':''); ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="thumb-sm avatar pull-left img-circle" style="background: #ffffff;"><img class="img-circle" width="30px" src="<?php echo $thumb_profile; ?>" alt="..."></span> &nbsp;&nbsp; <?php echo Auth::user()->name; ?>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="<?php echo url('/overview-account?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-user-o"></i> <?php echo trans('text.profile'); ?> </a></li>
                            <li><a href="<?php echo url('/posts?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-tasks"></i><?php echo trans('text.posts_management'); ?></a></li>
                            <li><a href="<?php echo url('/posts-groups?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-object-group"></i><?php echo trans('text.posted_groups'); ?></a></li>
                            <li><a href="#" role="button" data-toggle="menufilemanager"><i class="fa fa-btn fa-image"></i><?php echo trans('filemanager.title'); ?></a></li>
                            <li><a href="<?php echo url('/account/settings?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-cogs"></i><?php echo trans('text.account_settings'); ?></a></li>
                            <li><a href="<?php echo url('/account/change-password?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-exchange"></i><?php echo trans('text.account_change_password'); ?></a></li>
                            <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-btn fa-sign-out"></i><?php echo trans('text.logout'); ?></a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-envelope" aria-hidden="true"></i><span style="color: red; position: absolute; top:4px; left: 28px;"><?php echo (($total_message->total>0)? $total_message->total:''); ?></span></a>
                        <ul class="dropdown-menu">
                            <li><span style="padding:20px; color: #cccccc;">Messages</span></li>
                            <li role="separator" class="divider"></li>
                            <?php
                                if(count($messages) > 0) {?>
                                    <li class="message-noti-li">
                                <?php  foreach ($messages as $message) { ?>
                                        <div>
                                            <a href="<?php echo url('/message/detail?account_id='.$auth_id.'&load=inbox&message_id='.(($message->parent_id!='0')? $message->parent_id:$message->message_id) ).'&viewed_id='.$message->message_id; ?>">
                                                <div class="<?php echo (($message->viewed == 0)? 'message-box-active':'message-box'); ?>">
                                                    <img class="message-author-image" src="<?php echo ((isset($message_thumb_user[$message->message_id]))? $message_thumb_user[$message->message_id]:''); ?>"> &nbsp; 
                                                    <span class="message-author-name"><?php echo $message->user_name; ?> <?php echo (($message->sender_id==$auth_id)? '('.trans('message.you').')':''); ?></span>, 
                                                    <span class="message-date"><?php echo date('M dS, Y H:i', strtotime($message->message_date)); ?></span><br />
                                                    <span class="message-text"><?php echo (($message->parent_id=='0')? trans('button.send').' Messages':trans('button.reply').' To Messages ') ?> : <?php echo mb_substr(strip_tags(html_entity_decode($message->subject, ENT_QUOTES, 'UTF-8')), 0, 100).'...'; ?></span>
                                                </div>
                                            </a>
                                        </div>
                                <?php } ?> 
                                    </li>
                            <?php }
                            ?>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo url('/message?account_id='.Auth::user()->id); ?>&amp;load=inbox">Show All Messages</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-trigger="notification-viewed" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-bell" aria-hidden="true"></i><span id="load-notification" style="color: red; position: absolute; top:4px; left: 28px;"><?php echo (($notifications['total']>0)? $notifications['total']:'') ?></span></a>
                        <ul class="dropdown-menu">
                            <li><span style="padding:20px; color: #cccccc;">Notifications</span></li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <?php
                                    if(count($notifications['datas']) > 0) {?>
                                        <li class="message-noti-li">
                                    <?php  foreach ($notifications['datas'] as $notification) { ?>
                                            <div>
                                                <a href="<?php echo url('/'.str_replace(['@author_id@', '@post_id@', '@category_id@'], [$notification->author_id, $notification->post_id, (( empty($notification->category_id) )? '0':strtolower($notification->category_id))  ], $notification->link) ); ?>">
                                                    <div class="<?php echo (($notification->viewed_status=='new')? 'message-box-active':'message-box'); ?>">
                                                        <img class="message-author-image" src="<?php echo ((isset($notification_thumb_user[$notification->id]))? $notification_thumb_user[$notification->id]:''); ?>"> &nbsp; 
                                                        <span class="message-author-name"><?php echo $notification->user_name; ?> <?php echo (($notification->user_id==$auth_id)? '('.trans('message.you').')':''); ?></span>, 
                                                        <span class="message-date"><?php echo date('M dS, Y H:i', strtotime($notification->notification_date)); ?></span><br />
                                                        <span class="message-text"><?php echo str_replace(['@profile@ ', '@upload_title@'], ['', '"'.$notification->post_title.'"'], $notification->text); ?></span>
                                                    </div>
                                                </a>
                                            </div>
                                    <?php } ?> 
                                        </li>
                                <?php }
                                ?>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo url('/notification?account_id='.$auth_id); ?>">Show All Notifications</a></li>
                        </ul>
                    </li>
                    
                @endif
            </ul>
            
        </div>
    </div>
</nav>
<div id="load-unauthorized-notification"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $(document).delegate('a[data-trigger=\'notification-viewed\']', 'click', function() {
            $.ajax({
                type: "GET",
                url: "<?php echo url('/notification/clear-viewed?account_id='.$auth_id); ?>",
                beforeSend:function() {
                    // $('#block-loader').show();
                },
                complete:function() {
                    // $('#block-loader').hide();
                },
                success:function(html) {
                    var leng = html.length;
                    if(leng < 15) {
                        $('#load-notification').html('').show();
                    }else {
                        $('#load-unauthorized-notification').html(html).show();
                    }
                },
                error:function(request, status, error) {
                    $('#load-unauthorized-notification').html('').show();
                }
            });
            return false;
        });
    });
</script>