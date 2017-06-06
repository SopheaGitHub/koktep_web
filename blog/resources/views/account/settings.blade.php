@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-cogs"></i><?php echo $data->text_title; ?></h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            <a href="<?php echo $data->go_back; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-undo"></i> <?php echo $data->button_cancel; ?></a>
                            <button type="button" id="submit-account-setting" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
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
loadingForm("<?php echo $data->action_form; ?>");
</script>
@endsection