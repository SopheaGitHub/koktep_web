@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row profile">
        <div class="col-md-3">
            @include('common.filter_left') 
        </div>
        <div class="col-md-9">
            <!-- HTML to write -->
            <div class="profile-content" id="display-list">
                
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