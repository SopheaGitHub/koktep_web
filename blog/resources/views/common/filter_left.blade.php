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
    $array_view = ['posted'=>trans('text.posted'), 'people'=>trans('text.people')];
    $array_browse = [''=>'-- '.trans('text.all').' --', 'viewed'=>trans('text.viewed'), 'commented'=>trans('text.commented')];
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
<div class="" style="padding: 10px; background: #fbfcfc;">
    <form action="#" method="GET" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" id="category_id">
        <div class="row">
            <div class="col-md-12">
                <ul class="filter-left-display-menu">
                    <li><a href="#" role="button" data-toggle="view-grid-large"><i class="fa fa-btn fa-th-large"></i></a></li>
                    <li><a href="#" role="button" data-toggle="view-grid"><i class="fa fa-btn fa-th"></i></a></li>
                    <li><a href="#" role="button" data-toggle="view-list"><i class="fa fa-btn fa-list"></i></a></li>
                    <li><a href="#" role="button" data-toggle="view-people"><i class="fa fa-btn fa-users"></i></a></li>
                </ul>
                <input type="hidden" name="view" id="view" value="grid-large" />
            </div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="search" id="search" value="<?php echo $tag; ?>" placeholder="<?php echo trans('text.search'); ?> ..." class="form-control" />
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>

            <div class="table-responsive">
                <table class="table">
                <tbody>
                    <!-- <tr>
                        <td width="20%"><?php // echo trans('text.view'); ?></td>
                        <td>
                            <select name="view" id="view" class="form-control select-filter">
                                <?php
                                    /*foreach ($array_view as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }*/
                                ?>
                            </select>
                        </td>
                    </tr> -->
                    <tr>
                        <td><?php echo trans('text.feature'); ?></td>
                        <td>
                            <select name="browse" id="browse" class="form-control select-filter">
                                <?php
                                    foreach ($array_browse as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
                                <!-- <option>Most Like</option>
                                <option>Most Unlike</option> -->
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo trans('text.time'); ?></td>
                        <td>
                            <select name="time" id="time" class="form-control select-filter">
                                <?php
                                    foreach ($array_time as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo trans('text.alpha'); ?></td>
                        <td>
                            <select name="alpha" id="alpha" class="form-control select-filter">
                                <option value="">-- <?php echo trans('text.all'); ?> --</option>
                                <?php
                                    foreach ($array_alpha as $alpha) {
                                        echo '<option value="'.strtolower($alpha).'">'.$alpha.'</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo trans('text.location'); ?>
                            <select name="country_id" id="country" onchange="$('#zone').load('<?php echo $load_zone_action; ?>/' + this.value + '/0');" class="form-control select-filter">
                                <option value="0"><?php echo trans('text.select_country'); ?></option>
                                <?php foreach ($countries as $country_id => $country_name) { ?>
                                  <option value="<?php echo $country_id; ?>"><?php echo $country_name; ?></option>
                                <?php } ?>
                            </select>
                            <select name="zone_id" id="zone" class="form-control select-filter">
                            </select>
                        </td>
                    </tr>
                </tbody>
                
            </table>
        </div>
    </form>
    
</div>
<script type="text/javascript"><!--
$(document).delegate('a[data-toggle=\'view-grid-large\']', 'click', function() {
    $('#view').val('grid-large');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('a[data-toggle=\'view-grid\']', 'click', function() {
    $('#view').val('grid');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('a[data-toggle=\'view-list\']', 'click', function() {
    $('#view').val('list');
    var postDatas = $('#form-filter').serializeArray();
    var url = '<?php echo $action_list; ?>?filter=yes';
    $.each(postDatas, function(i, field) {
        url += '&'+field.name+'='+encodeURIComponent(field.value);
    });
    loadingList(url);
    return false;
});
$(document).delegate('a[data-toggle=\'view-people\']', 'click', function() {
    $('#view').val('people');
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
          url: "<?php echo url('/post-account/autocomplete');?>?filter_title=" +  encodeURIComponent(request) +"&filter_view="+encodeURIComponent($('#view').val()),
          dataType: 'json',
          success: function(json) {
            response($.map(json, function(item) {
              return {
                label: item['title'],
                value: item['title']
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