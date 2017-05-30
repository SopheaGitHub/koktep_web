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
    $array_view = ['posted'=>'Posted', 'people'=>'People', 'teams'=>'Teams', 'collection'=>'Collection'];
    $array_browse = ['feature'=>'Feature', 'most_viewed'=>'Most Viewed', 'most_comment'=>'Most Comment'];
    $array_time = ['recent'=>'Recent', 'today'=>'Today', 'this_week'=>'This Week', 'this_month'=>'This Month', 'this_year'=>'This Year'];
    $array_alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

    $countries = $objCountry->getCountries(['sort'=>'name','order'=>'asc'])->lists('name', 'country_id');

    // define tag
    if(\Request::has('tag')) {
        $tag = \Request::get('tag');
    }else {
        $tag = '';
    }
?>
<div class="" style="padding: 10px; background: #fff;">
    <form action="#" method="GET" enctype="multipart/form-data" id="form-filter" class="form-horizontal">
        <input type="hidden" name="category_id" value="<?php echo $category_id; ?>" id="category_id">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="margin:0px; padding:0px 0px 10px 0px;"><h4><i class="fa fa-btn fa-search"></i>Search ...</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="search" id="search" value="<?php echo $tag; ?>" placeholder="Search ..." class="form-control" />
                        </td>
                    </tr>
                </tbody>
                
            </table>
            </div>

            <div class="table-responsive">
                <table class="table">
                <thead>
                    <tr>
                        <th colspan="2" style="margin:0px; padding:0px 0px 10px 0px;"><h4><i class="fa fa-btn fa-search-plus"></i>Filter Options</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td width="20%">VIEW</td>
                    <td>
                        <select name="view" id="view" class="form-control select-filter">
                            <?php
                                foreach ($array_view as $key => $value) {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>BROWSE</td>
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
                    <td>TIME</td>
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
                    <td>ALPHA</td>
                    <td>
                        <select name="alpha" id="alpha" class="form-control select-filter">
                            <option value="">All Alpha</option>
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
                        LOCATION
                        <select name="country_id" id="country" onchange="$('#zone').load('<?php echo $load_zone_action; ?>/' + this.value + '/0');" class="form-control select-filter">
                            <option value="">-- Select Country --</option>
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
          url: "<?php echo url('/posts/autocomplete');?>?filter_title=" +  encodeURIComponent(request),
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