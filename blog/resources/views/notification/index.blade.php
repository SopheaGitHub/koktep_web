@extends('layouts.app')
@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12"><h4><i class="fa fa-btn fa fa-bell"></i><?php echo $data->text_title; ?></h4></div>
                </div>
                <hr />
                <p id="message"></p>
                <div id="display-list">

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingList("<?php echo $data->action_list; ?>");
    paginateListAction('render-list-notification', "<?php echo $data->action_list; ?>");
});
</script>
@endsection