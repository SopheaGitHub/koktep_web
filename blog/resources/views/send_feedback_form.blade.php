<form action="#" method="post" enctype="multipart/form-data" id="form-send-contact" class="form-horizontal">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <fieldset>
        <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-name"><?php echo $data->entry_your_name; ?></label>
            <div class="col-sm-9">
                <input type="text" name="name" value="" id="input-name" placeholder="<?php echo $data->entry_your_name; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-email"><?php echo $data->entry_email; ?></label>
            <div class="col-sm-9">
                <input type="text" name="email" value="" id="input-email" placeholder="<?php echo $data->entry_email; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group required">
            <label class="col-sm-3 control-label" for="input-message"><?php echo $data->entry_message; ?></label>
            <div class="col-sm-9">
                <textarea name="message" rows="10" id="input-message" placeholder="<?php echo $data->entry_message; ?>" class="form-control"></textarea>
            </div>
        </div>
    </fieldset>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <button type="button" id="submit-send-contact" class="btn btn-primary btn-sm"><i class="fa fa-btn fa-send"></i><?php echo $data->button_send; ?></button>
            </div>
        </div>
    </div>
</form>