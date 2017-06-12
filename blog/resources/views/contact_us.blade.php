@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-12">
            <!-- HTML to write -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12"><h4><i class="fa fa-btn fa-phone"></i><?php echo $data->entry_title; ?></h4></div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-6">
                        <h4><i class="fa fa-btn fa-university"></i><?php echo $data->entry_our_location; ?></h4>
                        <hr />
                        <div class="row">
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_team; ?></strong>
                                <br />
                                KOKTEP
                                <br /><br />
                            </div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_telephone; ?></strong>
                                <br /> 123456789<br /><br /></div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_email; ?></strong>
                                <br />
                                koktepteam@gmail.com
                                <br /><br />
                            </div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_website; ?></strong>
                                <br />
                                koktep.com
                                <br /><br />
                            </div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_address; ?></strong>
                                <br />
                                #121, Bankor, Phnom Penh, Cambodia, Kampong Cham 
                                <br /><br />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4><i class="fa fa-btn fa-envelope"></i><?php echo $data->entry_contact_form; ?></h4>
                        <hr />
                        <p id="message"></p>
                        <div id="load-form">

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
    loadingForm("<?php echo $data->action_form; ?>");
    requestSubmitForm('submit-send-contact', 'form-send-contact', "<?php echo $data->action; ?>");
});
</script>
@endsection