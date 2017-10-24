@extends('layouts.app_exhibition')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h4 style="background:teal; padding: 10px; color:#fff;">All Exhibitions's Requested</h4>
    </div>
  </div>
  <div class="row_grid_large">

    <?php
      if(count($data->exhibition_requests) > 0) {
        foreach ($data->exhibition_requests as $request) { ?>
          <div class="item_grid_large well">
            <div class="image-container">
                <p class="thumbnailimage" style="margin:0px; padding:0px;"><a href="<?php echo ((isset($data->thumb[$request->request_id]))? $data->thumb[$request->request_id]:''); ?>" class="thumbnailimage" title="<?php echo $request->file_title; ?>"><img class="image" src="<?php echo ((isset($data->thumb[$request->request_id]))? $data->thumb[$request->request_id]:''); ?>" style="width:100%; cursor: zoom-in;"></a></p>
                <div class="overlaylogo" style="color: teal;">Request: <?php echo ((strlen($request->request_id) > 1)? $request->request_id:'0'.$request->request_id); ?>, <?php echo $request->category_name; ?></div>
            </div>
          </div>
      <?php  }
      }
    ?>

  </div>

  <div class="row">
    <div class="col-sm-6 text-left" id="render-overview"><?php echo $data->exhibition_requests->render(); ?></div>
    <div class="col-sm-6 text-right">
        <?php
        $start = ($data->exhibition_requests->currentPage() * $data->exhibition_requests->perPage()) - $data->exhibition_requests->perPage() + 1;
        $stop = $data->exhibition_requests->currentPage() * $data->exhibition_requests->perPage();
        if($stop > $data->exhibition_requests->total()){
          $stop = ( $start + $data->exhibition_requests->count()) - 1;
        }
        if($stop == 0){
          $start = 0;
        }
      ?>
      <?php echo $data->show; ?> <?php echo $start; ?> <?php echo $data->to; ?> <?php echo $stop; ?> <?php echo $data->of; ?> <?php echo $data->exhibition_requests->total(); ?> &nbsp;&nbsp; (<?php echo $data->page; ?> <?php echo $data->exhibition_requests->currentPage(); ?> )
    </div>
  </div>

</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
  $('.thumbnailimage').magnificPopup({
    type:'image',
    delegate: 'a',
    gallery: {
        enabled:true
    }
  });
});
</script>
@endsection