@extends('layouts.app')

@section('content')
<div class="padding-fixed-header"></div>
<div class="container">
    <div class="row" id="load-form">

    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingForm("<?php echo $data->action_form; ?>");
});
</script>
@endsection