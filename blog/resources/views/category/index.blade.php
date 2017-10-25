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
    loadingList("<?php echo $data->action_list; ?>");
    paginateListAction('render-overview', "<?php echo $data->action_paginate_list; ?>");
});
</script>
@endsection