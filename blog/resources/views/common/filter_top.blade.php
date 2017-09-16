<?php
    $route_name = \Route::getCurrentRoute()->getPath();
    $action_list = url('/post-account/list');
    $action_paginate_list = url('/post-account/list');

    // get category
    $request_category = explode('-', \Request::get('category_id'));
    $category_id = $request_category['0'];

    $objCountry = new App\Models\Country();
    $load_zone_action = url('geo-zones/zone');

    // defind array
    // $array_view = ['posted'=>'Posted', 'people'=>'People', 'teams'=>'Teams', 'collection'=>'Collection'];
    $array_view = ['posted'=>trans('text.uploaded'), 'people'=>trans('text.uploader')];
    $array_browse = [''=>'-- '.trans('text.browse').' --', 'viewed'=>trans('text.viewed'), 'commented'=>trans('text.commented')];
    $array_time = [''=>'-- '.trans('text.recent').' --', 'today'=>trans('text.today'), 'this_week'=>trans('text.this_week'), 'this_month'=>trans('text.this_month'), 'this_year'=>trans('text.this_year')];
    $array_alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

    $countries = $objCountry->getCountries(['sort'=>'name','order'=>'asc'])->lists('name', 'country_id');

    // define tag
    if(\Request::has('tag')) {
        $tag = htmlspecialchars(\Request::get('tag'));
    }else {
        $tag = '';
    }
?>
<br />
<style type="text/css">
.form-control {
    display: block;
    width: 100%;
    height: 34px;
    padding: 2px 5px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
</style>
<form action="#" method="GET" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
    <div class="row" style="padding: 0px 5px;">
        <div>
            <input type="hidden" name="category_id" id="category-id" value="<?php echo $category_id; ?>" id="category_id">
        </div>
        <div class="col-md-2">
            <select name="view_option" id="view-option" class="form-control select-filter">
                <?php
                    foreach ($array_view as $key => $value) {
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="browse" id="browse" class="form-control select-filter">
                <?php
                    foreach ($array_browse as $key => $value) {
                        echo '<option value="'.$key.'">'.$value.'</option>';
                    }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="country_id" id="country" onchange="$('#zone').load('<?php echo $load_zone_action; ?>/' + this.value + '/0');" class="form-control select-filter">
                <option value="0"><?php echo trans('text.select_country'); ?></option>
                <?php foreach ($countries as $country_id => $country_name) { ?>
                  <option value="<?php echo $country_id; ?>"><?php echo $country_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="zone_id" id="zone" class="form-control select-filter">
                <option value=""><?php echo trans('text.select_zone'); ?></option>
            </select>
        </div>
        <div class="col-md-4">
            <div id="imaginary_container"> 
                <div class="input-group stylish-input-group">
                    <input type="text" name="search" id="search" value="<?php echo $tag; ?>" class="form-control"  placeholder="Search" >
                    <span class="input-group-addon">
                        <button type="button" id="button-search">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>  
                    </span>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div style="border:1px solid #fff; margin-top:-35px; background: #fbfcfc; width:auto; padding-left: 5px; float: right;">
        <ul class="filter-left-display-menu">
            <li><a href="#" role="button" data-trigger="view-grid-large"><i data-toggle="tooltip" title="<?php echo trans('text.grid_large'); ?>" class="fa fa-btn fa-th-large"></i></a></li>
            <li><a href="#" role="button" data-trigger="view-grid"><i data-toggle="tooltip" title="<?php echo trans('text.grid'); ?>" class="fa fa-btn fa-th"></i></a></li>
            <li><a href="#" role="button" data-trigger="view-list"><i data-toggle="tooltip" title="<?php echo trans('text.list'); ?>" class="fa fa-btn fa-list"></i></a></li>
        </ul>
        <input type="hidden" name="view" id="view" value="grid-large" />
    </div>
</form>
<script type="text/javascript"><!--
$(document).delegate('a[data-trigger=\'view-grid-large\']', 'click', function() {
    $('#view').val('grid-large');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('a[data-trigger=\'view-grid\']', 'click', function() {
    $('#view').val('grid');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('a[data-trigger=\'view-list\']', 'click', function() {
    $('#view').val('list');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('button[id=\'button-search\']', 'click', function() {
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).on('submit', '#form-filter', function() {
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).on('change', '.select-filter', function() {
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).ready(function() {
    // Related
    $('input[name=\'search\']').autocomplete({
      'source': function(request, response) {
        $.ajax({
          url: "<?php echo url('/post-account/autocomplete');?>?filter_title=" +  encodeURIComponent(request) +"&filter_view="+encodeURIComponent($('#view-option').val())+"&category_id="+encodeURIComponent($('#category-id').val())+"&country_id="+encodeURIComponent($('#country').val())+"&zone_id="+encodeURIComponent($('#zone').val()),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item['title'],
                value: item['title_text']
              }
            }));
          }
        });
      },
      'select': function(item) {
        $('input[name=\'search\']').val(item['value']);
        var postDatas = $('#form-filter').serializeArray();
        var url = '<?php echo $action_list; ?>?filter=yes';
        $.each(postDatas, function(i, field) {
            url += '&'+field.name+'='+encodeURIComponent(field.value);
        });
        loadingList(url);
        return false;
      }
    });
});
//--></script>