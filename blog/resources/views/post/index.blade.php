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
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-tasks"></i><?php echo $data->text_title; ?></h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                        <a href="<?php echo $data->add_post; ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-upload"></i> <?php echo $data->button_upload; ?> </a>
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <?php
                    if (\Session::has('message')) {
                        echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-check-circle"></i> '.\Session::get('message').'</b></div>';
                    }
                ?>
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
    paginateListAction('render-post', "<?php echo $data->action_list; ?>");
    requestSubmitDeleteForm('submit-delete-post', 'form-delete-post', "<?php echo $data->action_delete; ?>");
});
</script>
@endsection