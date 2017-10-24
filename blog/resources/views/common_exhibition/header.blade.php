<?php
  $objFile = new App\Http\Controllers\Common\FilemanagerController();
  $objConfig = new App\Http\Controllers\ConfigController();

  $auth_id = ((Auth::check())? Auth::user()->id:'0');

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
<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" style="background: teal;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar" style="background: #969696;"></span>
        <span class="icon-bar" style="background: #969696;"></span>
        <span class="icon-bar" style="background: #969696;"></span>
      </button>
      <a class="navbar-brand" href="<?php echo url('/exhibition'); ?>"><i class="fa fa-btn fa-map"></i> Exhibitions</a>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo url('/exhibition/request'); ?>"><i class="fa fa-btn fa-pencil-square-o"></i> Request To Exhibition</a></li>
        <li><a href="<?php echo url('/exhibition/list'); ?>"><i class="fa fa-btn fa-list-alt"></i> List Requested</a></li>
        <li><a href="<?php echo url('/'); ?>"><i class="fa fa-btn fa-tasks"></i> Show Cases</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-th" aria-hidden="true"></i> Our Service</a>
          <ul class="dropdown-menu">
            <li><a href="<?php //echo url('/'); ?>"><i class="fa fa-btn fa-tasks"></i> Show Cases</a></li>
            <li><a href="<?php //echo url('/exhibition'); ?>"><i class="fa fa-btn fa-map"></i> Exhibitions</a></li>
          </ul>
        </li> -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              <span class="thumb-sm avatar pull-left img-circle"><img class="img-circle" width="30px" src="<?php echo $thumb_profile; ?>" alt="..."></span> &nbsp;&nbsp; <?php echo Auth::user()->name; ?>
          </a>

          <ul class="dropdown-menu" role="menu">
              <li><a href="<?php echo url('/overview-account?account_id='.Auth::user()->id); ?>"><i class="fa fa-btn fa-user-o"></i> <?php echo trans('text.profile'); ?> </a></li>
              <li><a href="<?php echo url('/logout'); ?>"><i class="fa fa-btn fa-sign-out"></i> <?php echo trans('text.logout'); ?></a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>