@extends('layouts.app')

@section('content')
<button class="load_image">Load Image</button>
<div id="form-cropit">

</div>
@endsection
@section('script')
<script type="text/javascript">
loadingFormToID("<?php echo $data->action_form; ?>", "form-cropit");
</script>
<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '.load_image', function() {
        loadingFormToID("<?php echo $data->action_form; ?>", "form-cropit");
    });
});
</script>
<script type="text/javascript" src="<?php echo asset('/javascript/cropit/dist/jquery.cropit.js'); ?>"></script>
@endsection