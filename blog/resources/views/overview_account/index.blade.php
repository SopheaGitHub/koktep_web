@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_header')

    <div>
        @include('common.show_setting_message')
        <div class="col-md-3" style="padding: 0 15px;">
            @include('common.account_left')
        </div>
        <div class="col-md-9" style="padding: 0 15px;">
            <div class="profile-content" id="display-list" style="overflow:hidden;">
                
            </div>
        </div>
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