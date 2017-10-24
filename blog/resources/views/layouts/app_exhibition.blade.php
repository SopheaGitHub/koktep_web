<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>K Exhibition </title>
    <base href="<?php echo url('/').'/'; ?>" />
    <!-- <link href="<?php //echo url('/images/icon_koktep_v2.png'); ?>" rel="icon" /> -->
    <!-- main js -->
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/jquery-2.1.1.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- main js -->
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/highcharts/highcharts.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/highcharts/highcharts-more.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/highcharts/modules/exporting.js'); ?>"></script>

    <!-- Fonts -->
    <link type="text/css" href="<?php echo asset('/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">

    <!-- Styles -->
    <link href="<?php echo asset('/javascript/bootstrap/css/bootstrap.min.css'); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo asset('/css/app_exhibition.css'); ?>" rel="stylesheet">

    <!-- Sommernote form -->
    <link href="<?php echo asset('/javascript/summernote/summernote.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo asset('/javascript/summernote/summernote.js'); ?>"></script>

    <!-- magnific popup -->
    <script type="text/javascript" src="<?php echo asset('/javascript/jquery/magnific/jquery.magnific-popup.min.js'); ?>"></script>
    <link href="<?php echo asset('/javascript/jquery/magnific/magnific-popup.css'); ?>" rel="stylesheet" />

    <style type="text/css">
        .navbar-default {
            background-color: #ffffff;
            border-color: #ffffff; 
        }
        .row {
             margin-right: 0px; 
             margin-left: 0px; 
        }
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            margin: 0px;
            padding: 0px;
        }
        a.btn{
            border: none;
        }
        a.btn:hover{
            opacity: 0.8;
        }
        .modal-content {
            position: relative;
            background-color: #f1f1f1; 
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 1px solid #999;
            border: 1px solid rgba(0,0,0,.2);
            border-radius: 6px;
            outline: 0;
            -webkit-box-shadow: 0 3px 9px rgba(0,0,0,.5);
            box-shadow: 0 1px 9px rgba(0,0,0,.5);
        }
    </style>
    @yield('stylesheet')

</head>
<body id="app-layout">
    <div id="block-loader">
        <div class="myloader"></div>
    </div>
    <div id="blank">&nbsp;</div>
    <header>
      <!-- include header -->
      @include('common_exhibition.header')
    </header>

    <section>
      @yield('content')
    </section>
    
    <footer>
      <!-- include footer -->
      @include('common_exhibition.footer')
    </footer>
    <!-- JavaScripts -->
    <script src="<?php echo asset('/common_exhibition.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo asset('/javascript/cropit/dist/jquery.cropit.js'); ?>"></script>
    @yield('script')
    <script type="text/javascript">$('#block-loader').hide();</script>
</body>
</html>