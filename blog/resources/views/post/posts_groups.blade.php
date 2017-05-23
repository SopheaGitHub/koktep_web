@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-object-group"></i>Posts Groups</h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                        <a href="<?php echo url('/posts/posts-groups-create'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-plus"></i> Add New Post Group</a>
                        </span>
                    </div>
                </div>
                <hr />

                <div class="row">
                    <div class="col-md-9"><h5><a hre="#">Passionate designer</a></h5></div>
                    <div class="col-md-3">
                        <span class="pull-right">
                          <a href="<?php echo url('/posts/edit/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                          <a href="<?php echo url('/posts/delete/1'); ?>" class="btn btn-sm btn-danger"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </span>
                    </div>
                </div>
                <div style="border:1px solid #ddd;">
                  <div id="main" role="main">
                    <section class="slider">
                      <div class="flexslider carousel">
                        <ul class="slides">
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                        </ul>
                      </div>
                    </section>
                  </div>
                </div>
                
                <br />

                <div class="row">
                    <div class="col-md-9"><h5><a hre="#">Passionate designer</a></h5></div>
                    <div class="col-md-3">
                        <span class="pull-right">
                          <a href="<?php echo url('/posts/edit/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                          <a href="<?php echo url('/posts/delete/1'); ?>" class="btn btn-sm btn-danger"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </span>
                    </div>
                </div>
                <div style="border:1px solid #ddd;">
                  <div id="main" role="main">
                    <section class="slider">
                      <div class="flexslider carousel">
                        <ul class="slides">
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                          <li>
                            <img src="<?php echo url('/images/cache/catalog/lights-120x80.jpg'); ?>" />
                          </li>
                        </ul>
                      </div>
                    </section>
                  </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 130,
        itemMargin: 5,
        pausePlay: false,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
@endsection