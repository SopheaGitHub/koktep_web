<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>K Art, Design, Photo..., Develop... </title>
    <base href="<?php echo url('/').'/'; ?>" />
    <!-- <link href="<?php //echo url('/images/icon_koktep_v2.png'); ?>" rel="icon" /> -->
    <!-- main js -->
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/lplusin.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/jquery-2.1.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- Fonts -->
    <link type="text/css" href="<?php echo asset('/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link href="<?php echo asset('/javascript/bootstrap/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo asset('/css/app.css'); ?>" rel="stylesheet">

    <!-- Sommernote form -->
    <link href="<?php echo asset('/javascript/summernote/summernote.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo asset('/javascript/summernote/summernote.js'); ?>"></script>

    <!-- Bxslider -->
    <link href="<?php echo asset('/javascript/bxslider/jquery.bxslider.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo asset('/javascript/bxslider/jquery.bxslider.js'); ?>"></script>

    <!-- magnific popup -->
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/magnific/jquery.magnific-popup.min.js'); ?>"></script>
    <link href="<?php echo asset('/javascript/jquery/magnific/magnific-popup.css'); ?>" rel="stylesheet" />

    <style type="text/css">
        .btn-primary {
            color: #ffffff;
            /*background-color: #1bb794;*/
            border-color: #1bb793;
        }
        .btn-primary:hover {
            color: #e2e5d8;
            background-color: #6e8984;
            border-color: #6e8984;
        }
        a[data-toggle='image']:hover {
            background: #cccccc; 
            opacity: 0.9;
        }
    </style>

    @yield('stylesheet')

</head>
<body id="app-layout">
    <div id="block-loader">
        <div class="myloader"></div>
    </div>
    <header>
      <!-- include header -->
      @include('common.header')
    </header>
    
    <div class="padding-fixed-header"></div>

    <section>
      @yield('content')
    </section>

    <div class="padding-fixed-footer"></div>

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <section>
        <div class="container" style="text-align:right;">
            <div class="fb-like" data-href="https://web.facebook.com/Koktep-1459772587444683/" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
        </div>
    </section>
    
    <footer>
      <!-- include footer -->
      @include('common.footer')
    </footer>
    <!-- JavaScripts -->
    <script src="<?php echo asset('/common.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/cropit/dist/jquery.cropit.js'); ?>"></script>
    @yield('script')
</body>
</html>
