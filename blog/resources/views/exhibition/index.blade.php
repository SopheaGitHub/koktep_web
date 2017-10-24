@extends('layouts.app_exhibition')

@section('content')
  <style type="text/css">
  #container-art, #container-design, #container-photography, #container-development {
    width: 100%;
    margin: 0 auto;
  }
  </style>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6" style="background-color:teal; text-align:center; line-height: 0px;">

      <marquee behavior="scroll" scrolldelay="100" direction="left"><h3 style="margin:0px; padding:5px; color:#fff;"><i class="fa fa-btn fa-calendar-check-o"></i> <?php echo $data->exhibition_title; ?> ( Date: <?php echo $data->exhibition_open_date; ?> - <?php echo $data->exhibition_close_date; ?> )</h3></marquee>

  </div>
  <div class="col-md-3"></div>
</div>
<div class="row" id="slid-show">
  <div class="col-md-3"></div>
  <div class="col-md-6" style="background: #ccc;">

      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
          <li data-target="#carousel-example-generic" data-slide-to="1"></li>
          <li data-target="#carousel-example-generic" data-slide-to="2"></li>
          <li data-target="#carousel-example-generic" data-slide-to="3"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">

          <?php
            if(count($data->thumb_slide) > 0) {
              $i=1;
              foreach ($data->thumb_slide as $key => $value) { ?>
                <div class="item <?php echo (($i==1)? 'active':'') ?> ">
                  <a href="<?php echo url('/exhibition/view-exhibition?category='.$key); ?>"><img src="<?php echo $value; ?>" alt="..."></a>
                  <div class="carousel-caption">
                    <a href="<?php echo url('/exhibition/view-exhibition?category='.$key); ?>"><?php echo ((isset($data->category_name[$key]))? $data->category_name[$key]:''); ?></a>
                  </div>
                </div>
            <?php $i++; }
            }
          ?>

          <!-- <div class="item">
            <img src="<?php // echo url('/images/slider/banner.jpg'); ?>" alt="...">
            <div class="carousel-caption">
              <a href="<?php ///echo url('/exhibition/view-exhibition?category=2-design'); ?>">Design</a>
            </div>
          </div> -->
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

  </div>
  <div class="col-md-3"></div>
</div>
<div class="row">
  <div class="col-md-3"></div>
  <div class="col-md-6">
    <?php
      if(count($data->data_categories) > 0) {
        foreach ($data->data_categories as $key => $value) { ?>
          <div class="row" id="exhibition-<?php echo $key; ?>" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
            <div class="col-md-12">
              <a href="<?php echo url('/exhibition/view-exhibition?category='.$key); ?>" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;"><img src="<?php echo url('/images/head_pointer.gif'); ?>" width="30px;" alt="" /> <?php echo $value['category_name']; ?></a>
            </div>
            <div class="col-md-6">
              <a href="<?php echo url('/exhibition/view-exhibition?category='.$key); ?>"><img src="<?php echo $value['thumb_image']; ?>" style="width:100%" alt="Canoeing again"></a>
            </div>
            <div class="col-md-6">
              <div id="container-<?php echo $key; ?>"></div>
            </div>
          </div>
      <?php  }
      }
    ?>
    

    <!-- <div class="row" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
      <div class="col-md-12">
        <a href="<?php // echo url('/exhibition/view-exhibition?category=2-design'); ?>" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;"><img src="<?php // echo url('/images/head_pointer.gif'); ?>" width="30px;" alt="" /> View Design's Exhibition</a>
      </div>
      <div class="col-md-6">
        <a href="<?php // echo url('/exhibition/view-exhibition?category=2-design'); ?>"><img src="<?php // echo url('/images/all_sample_design.jpg'); ?>" style="width:100%" alt="Canoeing again"></a>
      </div>
      <div class="col-md-6">
        <div id="container-design"></div>
      </div>
    </div> -->

  </div>
  <div class="col-md-3"></div>
</div>
@endsection
@section('script')
  <script type="text/javascript"><!--
  <?php
    if(count($data->data_categories) > 0) {
      foreach ($data->data_categories as $key => $value) { ?>
        var chart = Highcharts.chart('container-<?php echo $key; ?>', {
          title: {
            text: "<?php echo $value['chart_title']; ?>",
            style: {
              color: "#969696"
            }
          },
          subtitle: {
              text: ''
          },
          xAxis: {
            categories: [<?php echo '"'.implode('","', $value['name_charts']).'"'; ?>]
          },
          series: [{
              type: 'column',
              colorByPoint: true,
              data: [<?php echo implode(',', $value['data_charts']); ?>],
              showInLegend: false
          }],
          chart: {
            backgroundColor: "#313131",
          }
        });
    <?php  }
    }
  ?>
  //--></script>

  <script type="text/javascript">

    

    // var chart = Highcharts.chart('container-development', {

    //   title: {
    //       text: 'Development\'s Ratting'
    //   },

    //   subtitle: {
    //       text: ''
    //   },

    //   xAxis: {
    //       categories: ['DEV01', 'DEV02', 'DEV03', 'DEV04', 'DEV05', 'DEV06', 'DEV07', 'DEV08', 'DEV09']
    //   },

    //   series: [{
    //       type: 'column',
    //       colorByPoint: true,
    //       data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4],
    //       showInLegend: false
    //   }]

    // });

  </script>
@endsection