<nav class="navbar navbar-default navbar-static-top navbar-fixed-top" style="background: teal;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo url('/exhibition'); ?>" style="color:#fff;"><i class="fa fa-btn fa-map"></i> Exhibitions</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="<?php echo url('/exhibition/request'); ?>" style="color:#fff;"><i class="fa fa-btn fa-pencil-square-o"></i> Request To Upload Exhibition</a></li>
    </ul>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:#fff;"><i class="fa fa-th" aria-hidden="true"></i></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo url('/'); ?>" style="color:teal;"><i class="fa fa-btn fa-tasks"></i> Show Cases</a></li>
            <li><a href="<?php echo url('/exhibition'); ?>" style="color:teal;"><i class="fa fa-btn fa-map"></i> Exhibitions</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>