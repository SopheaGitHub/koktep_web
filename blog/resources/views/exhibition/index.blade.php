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
  <div class="col-md-6" style="background-color:teal; text-align:center;">

      <h3 style="margin:0px; padding:5px; color:#fff;"><i class="fa fa-btn fa-calendar"></i> Exhibition Date: 02 December 2017 - 05 December 2017</h3>

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
          <div class="item active">
            <img src="<?php echo url('/images/slider/download.svg'); ?>" alt="...">
            <div class="carousel-caption">
              <a href="#">Art</a>
            </div>
          </div>
          <div class="item">
            <img src="<?php echo url('/images/slider/download (1).svg'); ?>" alt="...">
            <div class="carousel-caption">
              <a href="#">Design</a>
            </div>
          </div>
          <div class="item">
            <img src="<?php echo url('/images/slider/download (2).svg'); ?>" alt="...">
            <div class="carousel-caption">
              <a href="#">Photography</a>
            </div>
          </div>
          <div class="item">
            <img src="<?php echo url('/images/slider/download (1).svg'); ?>" alt="...">
            <div class="carousel-caption">
              <a href="#">Development</a>
            </div>
          </div>
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
    <div class="row" id="exhibition-art" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
      <div class="col-md-12">
        <a href="#" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;">View Art's Exhibition</a>
      </div>
      <div class="col-md-6">
        <img src="<?php echo url('/images/photo/girl.jpg'); ?>" style="width:100%" alt="Canoeing again">
      </div>
      <div class="col-md-6">
        <div id="container-art"></div>
      </div>
    </div>
    <div class="row" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
      <div class="col-md-12">
        <a href="#" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;">View Design's Exhibition</a>
      </div>
      <div class="col-md-6">
        <img src="<?php echo url('/images/photo/girl_train.jpg'); ?>" style="width:100%" alt="Canoeing again">
      </div>
      <div class="col-md-6">
        <div id="container-design"></div>
      </div>
    </div>
    <div class="row" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
      <div class="col-md-12">
        <a href="#" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;">View Photography's Exhibition</a>
      </div>
      <div class="col-md-6">
        <img src="<?php echo url('/images/photo/girl_mountain.jpg'); ?>" style="width:100%" alt="Canoeing again">
      </div>
      <div class="col-md-6">
        <div id="container-photography"></div>
      </div>
    </div>
    <div class="row" style="background: #ffffff; border-bottom:1px solid #f1f1f1;">
      <div class="col-md-12">
        <a href="#" class="btn btn-primary btn-sm" style="width:100%; background: teal; border-radius:0px; font-size: 16px;">View Development's Exhibition</a>
      </div>
      <div class="col-md-6">
        <img src="<?php echo url('/images/photo/boy.jpg'); ?>" style="width:100%" alt="Canoeing again">
      </div>
      <div class="col-md-6">
        <div id="container-development"></div>
      </div>
    </div>
  </div>
  <div class="col-md-3"></div>
</div>
@endsection
@section('script')
  <script type="text/javascript">
    var chart1 = Highcharts.chart('container-art', {

      title: {
          text: 'Art\'s Ratting'
      },

      subtitle: {
          text: ''
      },

      xAxis: {
          categories: ['ART01', 'ART02', 'ART03', 'ART04', 'ART05', 'ART06', 'ART07', 'ART08', 'ART09', 'ART10']
      },

      series: [{
          type: 'column',
          colorByPoint: true,
          data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1],
          showInLegend: false
      }],

    });

    var chart2 = Highcharts.chart('container-design', {

      title: {
          text: 'Design\'s Ratting'
      },

      subtitle: {
          text: ''
      },

      xAxis: {
          categories: ['DES01', 'DES02', 'DES03', 'DES04', 'DES05', 'DES06', 'DES07', 'DES08', 'DES09', 'DES10']
      },

      series: [{
          type: 'column',
          colorByPoint: true,
          data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1],
          showInLegend: false
      }]

    });

    var chart3 = Highcharts.chart('container-photography', {

      title: {
          text: 'Photography\'s Ratting'
      },

      subtitle: {
          text: ''
      },

      xAxis: {
          categories: ['PHO01', 'PHO02', 'PHO03', 'PHO04', 'PHO05', 'PHO06', 'PHO07', 'PHO08', 'PHO09', 'PHO10']
      },

      series: [{
          type: 'column',
          colorByPoint: true,
          data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1],
          showInLegend: false
      }]

    });

    var chart4 = Highcharts.chart('container-development', {

      title: {
          text: 'Development\'s Ratting'
      },

      subtitle: {
          text: ''
      },

      xAxis: {
          categories: ['DEV01', 'DEV02', 'DEV03', 'DEV04', 'DEV05', 'DEV06', 'DEV07', 'DEV08', 'DEV09', 'DEV10']
      },

      series: [{
          type: 'column',
          colorByPoint: true,
          data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1],
          showInLegend: false
      }]

    });

  </script>
@endsection