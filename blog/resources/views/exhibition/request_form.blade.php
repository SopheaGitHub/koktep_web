@extends('layouts.app_exhibition')

@section('content')
<?php
    if(count($data->categories) > 0) { ?>
        <div class="container">
            <div class="row" style="margin-top: 30px; font-size: 14px;">
                <div class="col-md-3"></div>
                <div class="col-md-6 form-box">

                    <div class="modal-content">
                        <div class="modal-header" style="background: teal; border-radius: 4px 4px 0px 0px;">
                          <div class="row">
                            <div class="col-md-12"><h4 style="margin:0px; padding:0px; color: #fff;"><b><i class="fa fa-btn fa-pencil-square-o"></i> Request's Form</b></h4></div>
                          </div>
                        </div>
                        <div class="modal-body">
                            <form action="#" method="post" enctype="multipart/form-data" id="form-request-exhibition">
                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                <h4 style="margin:0px; padding:0px; color:teal;"><i class="fa fa-btn fa-check-square-o"></i> Information</h4>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control input-alert" id="name" value="<?php echo $data->name; ?>" name="name" placeholder="Enter Your Name">
                                    <div id="alert-name"></div>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" value="<?php echo $data->phone; ?>" name="phone" placeholder="Enter Your Phone">
                                    <div id="alert-phone"></div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Your Email">
                                    <div id="alert-email"></div>
                                </div> -->
                                <br />
                                <h4 style="margin:0px; padding:0px; color:teal;"><i class="fa fa-btn fa-check-square-o"></i> Upload Detail</h4>
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="">-- Please Select Category --</option>
                                        <?php
                                            foreach ($data->categories as $key => $value) {
                                                echo '<option value="'.$key.'">'.$value.'</option>';
                                            }
                                        ?>
                                    </select>
                                    <?php
                                        if(count($data->user_request) > 0) { ?>
                                            <div class="alert alert-success" id="success">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                <i class="fa fa-btn fa-info-circle"></i> <?php echo $data->categories_msg.'.'; ?>
                                            </div>
                                    <?php } ?>
                                    <div id="alert-category_id"></div>
                                </div>
                                <div class="form-group">
                                    <label for="file">Upload Image/Photo </label>
                                    <input type="file" name="file" id="file">
                                    <em style="font-size: Times New Roman;">(Recomment Size: w=121px, h=21px)</em>
                                    <div id="alert-file"></div>
                                    <div id="alert-error_file"></div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Your Image Title">
                                    <div id="alert-title"></div>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" style="min-width: 100%; max-width: 100%; min-height: 120px; max-height: 120px;" placeholder="Descripton To Your Image/Photo"></textarea>
                                    <div id="alert-description"></div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <div style="text-align: left;"><div id="message"></div></div>
                            <button type="button" class="btn btn-primary" id="submit-request-exhibition" style="width: 100%;"><img src="<?php echo url('/images/head_pointer.gif'); ?>" width="30px;" alt="" /> Submit</button>
                        </div>
                    </div>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
<?php   } else { ?>
    <div class="container">
        <div class="alert alert-success" id="success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <i class="fa fa-btn fa-info-circle"></i> <?php echo $data->categories_msg.'.'; ?>
        </div>
    </div>
<?php } ?>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function () {
    $(document).on('click', '#submit-request-exhibition', function(e) {
        e.preventDefault();
        if (typeof timer != 'undefined') {
            clearInterval(timer);
        }

        timer = setInterval(function() {
            clearInterval(timer);
            var postDatas = new FormData($("form#form-request-exhibition")[0]);
            $.ajax({
                url: "<?php echo $data->action_request_exhibition; ?>",
                type: "POST",
                data: postDatas,
                dataType: "json",
                async: true,
                beforeSend: function() {
                    console.log('beforeSend');
                    $('#submit-request-exhibition').prop('disabled', true);
                    $('#alert-name').html('');
                    $('#alert-phone').html('');
                    // $('#alert-email').html('');
                    $('#alert-category_id').html('');
                    $('#alert-file').html('');
                    $('#alert-error_file').html('');
                    $('#alert-title').html('');
                    $('#alert-description').html('');
                    $('#block-loader').show();
                },
                complete: function() {
                    console.log('completed');
                    $('#submit-request-exhibition').prop('disabled', false);
                    $('#block-loader').hide();
                },
                success: function(data) {
                    var msg = '';
                    // if vaildate error
                    if(data.error==1) {
                        msg += '<div class="alert alert-danger" id="danger">';
                        msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        msg += '<b><i class="fa fa-info-circle"></i> '+data.msg+' </b><br />';
                        if(data.validatormsg) {
                            $.each(data.validatormsg, function(index, value) {
                                // msg += '- '+value+'<br />';
                                $('#alert-'+index).html('<div class="text-danger">'+value+'</div>');
                            });
                        }
                        msg += '</div>';
                    }

                    // if success
                    if(data.success==1) {
                        msg += '<div class="alert alert-success" id="success">';
                        msg += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        msg += '<b><i class="fa fa-check-circle"></i> '+data.msg+'</b><br />';
                        msg += '</div>';
                        // loading list
                        if(data.reload_page) {
                            window.location = data.reload_page;
                        }
                    }

                    $('#message').html(msg).show();
                },
                error: function(request, status, error) {
                    $('#message').html('<div class="alert alert-danger" id="error"><button type="button" class="close" data-dismiss="alert">&times;</button><b><i class="fa fa-times"></i> Something wrong, Please alert to developer.</b></div>').show();
                    // $('#message').html('').show();
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }, 10);
    });   
});
</script>
@endsection