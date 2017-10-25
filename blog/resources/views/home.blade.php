@extends('layouts.app')

@section('content')
<?php
if(\Session::has('locale')) {
    $locale = \Session::get('locale');
}else {
    $locale = 'en';
}
?>
@include('jumbotron_'.$locale)
<div style="background: teal; color: #fff; padding: 0px 20px;">
    @include('common.filter_top')
</div>
<div style="padding: 20px;">
    <div id="display-list">
        
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