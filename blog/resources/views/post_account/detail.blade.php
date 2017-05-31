@extends('layouts.app')

@section('content')
<div id="display-list">

</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingList("<?php echo $data->action_detail_form; ?>");
});
</script>
@endsection