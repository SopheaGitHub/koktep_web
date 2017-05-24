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
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-object-group"></i>Posts Groups Management</h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                        <a href="<?php echo $data->add_post_group; ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-plus"></i> Add New Post Group</a>
                        </span>
                    </div>
                </div>
                <hr />
                <div id="display-list">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingList("<?php echo $data->action_list; ?>");
    paginateListAction('render-post-group', "<?php echo $data->action_list; ?>");
});
</script>
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