@extends('layouts.app_exhibition')

@section('content')
<link href="<?php echo asset('/javascript/jquery/rating/exhibition-star-rating.css'); ?>" rel="stylesheet" />
<style type="text/css">
.row-thumbnail {
    display: block;
    padding: 4px;
    /* margin-bottom: 20px; */
    line-height: 1.42857143;
    background-color: #fff;
    border: 1px solid #ddd;
    /* border-radius: 4px; */
    -webkit-transition: border .2s ease-in-out;
    -o-transition: border .2s ease-in-out;
    transition: border .2s ease-in-out;
}
</style>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <div class="row thumbnail" style="margin-top: 20px; padding: 5px;">
      <div class="col-md-12" style="font-size: 24px; text-align: center;">
        <marquee behavior="scroll" scrolldelay="100" direction="left"><a href="#"><b>Art's Exhibitions</b></a></marquee>
      </div>
    </div>

    <?php
      if(count($data->approval_to_request_data) > 0) {

        foreach ($data->approval_to_request_data as $key => $value) { ?>
          <div class="row" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
            <div class="col-md-12">
              <a href="<?php echo $value['category_url']; ?>" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;"><?php echo $key; ?></a>
            </div>
            <div class="row row-thumbnail" style="background: #eeeeee;">
              <div class="col-md-6">
                <p class="thumbnailimage" style="margin:0px; padding:0px;"><a href="<?php echo $value['thumb']; ?>" class="thumbnailimage" title="<?php echo $value['title']; ?>"><img src="<?php echo $value['thumb']; ?>" style="width:100%; cursor: zoom-in;" alt="Canoeing again"></a></p>
              </div>
              <div class="col-md-6" style="text-align: center;">
                <div>
                  <a href="<?php echo $value['user_url']; ?>"><img style="width:70px; margin-top:5px; border-radius:50%;" src="<?php echo $value['user_profile']; ?>"></a>
                </div>
                <div><span><a href="<?php echo $value['user_url']; ?>"><?php echo $value['user_name']; ?></a></span></div>
                <div>
                  <div style="color:#fff; font-size: 24px; background: teal; padding: 5px; border-radius:4px; margin: 0px 20px;"><i class="fa fa-btn fa-star"></i> <span id="total-rating<?php echo $value['request_id']; ?>"><?php echo (($value['total_rating']=='')? '0':$value['total_rating']); ?></span></div>
                  <h4><?php echo $value['title']; ?></h4>
                  <p class="well-description"><?php echo $value['description']; ?></p>
                </div>
                <div class="row">
                  <div class="col-md-2" style="text-align:right;"><img src="<?php echo url('/images/head_pointer_teal.gif'); ?>" width="30px;" alt="" /></div>
                  <span class="col-md-8"><input type="text" class="kv-gly-star rating-loading" data-type="<?php echo $data->type; ?>" data-id="<?php echo $value['request_id']; ?>" value="<?php echo $value['auth_star']; ?>" data-size="xs" title=""></span>
                  <div class="col-md-2"></div>
                </div>
                <div id="message-rating<?php echo $value['request_id']; ?>"></div>
              </div>
            </div>
          </div>
      <?php } 
      } 
    ?>

    <hr />
    <div class="row">
      <div class="col-md-12" style="background: teal; margin:0px; padding: 0px 10px; color: #fff;">
        <h3><i class="fa fa-commenting" aria-hidden="true"></i> Comment</h3>
        <form>
          <div class="form-group">
              <textarea class="form-control" style="min-width: 100%; max-width: 100%; min-height: 50px; max-height: 50px;" placeholder="Descripton To Your Image"></textarea>
          </div>
        </form>
      </div>
      <div class="col-md-12" style="background: #cccccc; padding: 20px; height: 500px; overflow-y: scroll;">
        
        <div>
          <section class="comments">
            <article class="comment">
              <a class="comment-img" href="#non">
                <img src="http://localhost/development/koktep_storage//images/cache/catalog/1/profile/profile_chansophea1-100x100.jpg" alt="" width="50" height="50">
              </a>
              <div class="comment-body">
                <div class="text">
                  <p>Hello, this is an example from me</p>
                </div>
                <p class="attribution">by <a href="#non">Besnik Hetemi</a> at 14:23pm, 4 Dec 2015</p>
              </div>
            </article>
              <article class="comment">
              <a class="comment-img" href="#non">
                <img src="http://localhost/development/koktep_storage//images/cache/catalog/1/profile/profile_chansophea1-100x100.jpg" alt="" width="50" height="50">
              </a>
              <div class="comment-body">
                <div class="text">
                  <p>if you are interested for  more about me visited my profile on social page</p>
                  <p>To visit me you can click my name  <a target="_blank" href="http://www.facebook.com/besnik.hetemii">Besnik Hetemi</a> and send me frends request or send me a message in inbox</p>
                </div>
                <p class="attribution">by <a href="#non">Besnik Hetemi</a> at 14:23pm, 4 Dec 2015</p>
              </div>
            </article>
          </section>
        </div>
      </div>
    </div>
    
  </div>
  <div class="col-md-3"></div>
</div>
<meta name="csrf-token" content="<?php echo csrf_token(); ?>" />
<div id="load-unauthorized"></div>
@endsection
@section('script')
<script type="text/javascript" src="<?php echo asset('/javascript/jquery/rating/exhibition-star-rating.js'); ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $('.thumbnailimage').magnificPopup({
      type:'image',
      delegate: 'a',
      gallery: {
          enabled:true
      }
    });

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $('.kv-gly-star').rating({
      filledStar: '<i class="fa fa-star"></i>',
      emptyStar: '<i class="fa fa-star-o"></i>'
    });

    $('.kv-gly-star').on('change', function (e) {
      var value = $(this).val();
      var id = $(this).data("id");
      var type = $(this).data("type");

      e.preventDefault();
      if (typeof timer != 'undefined') {
          clearInterval(timer);
      }

      timer = setInterval(function() {
          clearInterval(timer);
          $.ajax({
              url: "<?php echo $data->action_rating; ?>?_token="+CSRF_TOKEN+"&id="+id+"&type="+type+"&star="+value,
              type: "POST",
              data: {},
              dataType: "json",
              async: true,
              beforeSend: function() {
                  // console.log('beforeSend');
                  $('#block-loader').show();
              },
              complete: function() {
                  // console.log('completed');
                  $('#block-loader').hide();
              },
              success: function(data) {
                  var msg = '';
                  // if vaildate error
                  if(data.error==1) {
                      msg += '<div class="alert alert-danger" id="danger">';
                      msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                      msg += '<b><i class="fa fa-info-circle"></i> '+data.msg+' </b><br />';
                      if(data.validatormsg) {
                          $.each(data.validatormsg, function(index, value) {
                              // msg += '- '+value+'<br />';
                              $('#alert-'+index).html('<div class="text-danger">'+value+'</div>');
                          });
                      }
                      msg += '</div>';
                  }

                  // if success
                  if(data.success==1) {
                      msg += '<div class="alert alert-success" id="success">';
                      msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                      msg += '<b><i class="fa fa-check-circle"></i> '+data.msg+'</b><br />';
                      msg += '</div>';
                  }

                  $('#message-rating'+id).html(msg).show();
                  $('#total-rating'+id).html(data.total_rating).show();
              },
              error: function(request, status, error) {
                  $('#message-rating'+id).html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
                  // $('#message').html('').show();
              },
              cache: false,
              contentType: false,
              processData: false
          });
      }, 10);

    });

  });
</script>
@endsection