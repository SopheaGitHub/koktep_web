@extends('layouts.app')

@section('content')
<div class="padding-fixed-header"></div>
<div class="container">
    <div class="row" id="load-form">

    </div>
</div>
@endsection
@section('script')
<!-- tags input -->
<script type="text/javascript">
$(document).ready(function() {
    loadingForm("<?php echo $data->action_form; ?>");
    requestSubmitForm4('submit-post', 'form-post', "<?php echo $data->action; ?>", "message");
});
</script>
@endsection