@extends('layouts.app')

@section('content')
<div style="margin-top:-9px; height:30px; background: #91beb1; color: #fff; text-align:center;">
    <h5 style="margin:0px; padding-top:7px;"><?php echo trans('text.show_cash_your_work'); ?></h5>
</div>
<div>
    <div class="container" style="padding-right: 5px; padding-left: 5px;">
        @include('common.filter_top')
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="display-list">
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    var url = '';
    if($('#search').val()!='') {
        var postDatas = $('#form-filter').serializeArray();
        url = "?filter=yes";
        $.each(postDatas, function(i, field) {
            url += '&'+field.name+'='+encodeURIComponent(field.value);
        });
    }
    loadingList("<?php echo $data->action_list; ?>"+url+" ");
    paginateListAction('render-overview', "<?php echo $data->action_list; ?>");
});
</script>

@endsection