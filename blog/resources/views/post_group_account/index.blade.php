@extends('layouts.app')
@section('bxslider')
    <link href="<?php echo asset('/javascript/bxslider/jquery.bxslider.css'); ?>" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo asset('/javascript/bxslider/jquery.bxslider.js'); ?>"></script>
@endsection
@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content" id="display-list">

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingList("<?php echo $data->action_list; ?>");
    paginateListAction('render-post-group-account', "<?php echo $data->action_list; ?>");
});
</script>
@endsection