@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_profile')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-exchange"></i><?php echo $data->titlelist; ?></h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            <a href="<?php echo $data->go_back; ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-undo"></i> <?php echo $data->button_cancel; ?></a>
                            <button type="button" id="submit-user-password" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> <?php echo $data->button_save_change; ?></button>
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <div class="row" id="load-form">

                  <div class="container-fluid">
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h3 class="panel-title"><b><i class="fa fa-btn fa-pencil"></i><?php echo $data->entry_title_form; ?></b></h3>
                      </div>
                      <div class="panel-body">

                        <form action="#" method="POST" enctype="multipart/form-data" id="form-user-password" class="form-horizontal">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                          <div class="form-group required">
                            <label class="col-sm-4 control-label"><?php echo $data->entry_current_password; ?></label>
                            <div class="col-sm-6">
                              <input type="password" placeholder="<?php echo $data->entry_current_password; ?>" class="form-control" name="current_password">
                            </div>
                          </div>

                          <div class="form-group required">
                            <label class="col-sm-4 control-label"><span data-toggle="tooltip" title="<?php echo $data->title_password; ?>"><?php echo $data->entry_new_password; ?></span></label>
                            <div class="col-sm-6">
                              <input type="password" placeholder="<?php echo $data->entry_new_password; ?>" class="form-control" name="new_password">
                            </div>
                          </div>

                          <div class="form-group required">
                            <label class="col-sm-4 control-label"><?php echo $data->entry_confirm_new_password; ?></label>
                            <div class="col-sm-6">
                              <input type="password" placeholder="<?php echo $data->entry_confirm_new_password; ?>" class="form-control" name="new_password_confirmation">
                            </div>
                          </div>

                        </form>

                      </div>
                    </div>
                  </div>

                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
  requestSubmitForm('submit-user-password', 'form-user-password', "<?php echo $data->action; ?>");
});
</script>
@endsection