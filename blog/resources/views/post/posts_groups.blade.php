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
                        <a href="<?php echo url('/posts/create'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-plus"></i> Add New Post Group</a>
                        </span>
                    </div>
                </div>
                <hr />

                <div id="main" role="main">
                  <section class="slider">
                    <div class="flexslider carousel">
                      <ul class="slides">
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg'); ?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                      </ul>
                    </div>
                  </section>
                </div>

                <div id="main" role="main">
                  <section class="slider">
                    <div class="flexslider carousel">
                      <ul class="slides">
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg'); ?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_cheesecake_brownie.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_lemon.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_donut.jpg');?>" />
                        </li>
                        <li>
                          <img src="<?php echo url('/images/cache/catalog/kitchen_adventurer_caramel.jpg');?>" />
                        </li>
                      </ul>
                    </div>
                  </section>
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
        itemWidth: 210,
        itemMargin: 5,
        pausePlay: true,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>
@endsection