@extends('layouts.app')

@section('content')
<div class="jumbotron my-4">
    <h1 class="display-3">A Warm Welcome!</h1>
    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam repellat.</p>
    <a href="#" class="btn btn-primary btn-lg">Contact Us!</a>
</div>
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