<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KOKTEP</title>
    <base href="<?php echo url('/').'/'; ?>" />

    <!-- main js -->
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

    @yield('stylesheet')

</head>
<body id="app-layout">
    <header>
      <!-- include header -->
      @include('common.header')
    </header>
    
    <div class="padding-fixed-header"></div>

    <section>
      @yield('content')
    </section>

    <div class="padding-fixed-footer"></div>
    <footer>
      <!-- include footer -->
      @include('common.footer')
    </footer>
    <!-- JavaScripts -->
    <script src="<?php echo asset('/common.js'); ?>" type="text/javascript"></script>
    @yield('script')
</body>
</html>
