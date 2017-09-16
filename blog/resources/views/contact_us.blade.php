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
                <br />
                <p><?php echo $data->text_contact_us; ?></p>
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
                                <br /> 086 908 456<br /><br /></div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_email; ?></strong>
                                <br />
                                teamkoktep@gmail.com
                                <br /><br />
                            </div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_website; ?></strong>
                                <br />
                                www.koktep.com
                                <br /><br />
                            </div>
                            <div class="col-sm-12">
                                <strong><?php echo $data->entry_address ; ?></strong>
                                <br />
                                No 92 AB, Sangkat Boeung Kark 2, Khan Toul Kork, Phnom Penh City, Cambodia (hereinafter refer to as the "Building")
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