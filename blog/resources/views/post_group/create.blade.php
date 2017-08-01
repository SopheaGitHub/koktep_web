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
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-object-group"></i><?php echo $data->text_title; ?></h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            <button type="button" id="submit-post-group" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save; ?></button>
                            <a href="<?php echo $data->go_back.'?account_id='.$data->auth_id; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-close"></i> <?php echo $data->button_cancel; ?></a>                            
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <div class="row" id="load-form">



                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    loadingForm("<?php echo $data->action_form; ?>");
    requestSubmitForm('submit-post-group', 'form-post-group', "<?php echo $data->action; ?>");
});
</script>
@endsection