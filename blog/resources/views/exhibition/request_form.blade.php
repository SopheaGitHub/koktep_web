@extends('layouts.app_exhibition')

@section('content')
<div class="container">
 <div style="height:40px;"></div>
    <div class="assessment-container container">
        <div class="row">
            <div class="col-md-6 form-box">
                <form role="form" class="registration-form" action="javascript:void(0);">
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>Step One</h3>
                                <p>Check Account Information</p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Firstname" id="fname">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Lastname" id="lname">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:3px;">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-3">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9 col-sm-9">
                                        <input type="text" class="form-control" placeholder="Contact Number" id="contact_number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email" class="form-email form-control" id="email" required>
                            </div>

                            <div class="form-group">
                                <select class="form-control">
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            
                            <button type="button" class="btn btn-next">Next</button>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>Step Two</h3>
                                <p>Upload to Request</p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="row">
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Firstname" id="fname">
                                </div>
                                <div class="form-group col-md-6 col-sm-6">
                                    <input type="text" class="form-control" placeholder="Lastname" id="lname">
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom:3px;">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-3">
                                        <select class="form-control">
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                            <option>00</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-9 col-sm-9">
                                        <input type="text" class="form-control" placeholder="Contact Number" id="contact_number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email" class="form-email form-control" id="email" required>
                            </div>

                            <div class="form-group">
                                <select class="form-control">
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="button" class="btn btn-next">Next</button>

                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span><i class="fa fa-calendar-check-o" aria-hidden="true"></i></span>Step Three</h3>
                                <p>Submit</p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group">
                                <select class="form-control">
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Locationa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="pref_date">
                            </div>
                            <div class="form-group">
                                <select class="form-control">
                                    <option>Preffered Time</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Location</option>
                                    <option>Locationa</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" class="btn">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function () {
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function () {
        $(this).removeClass('input-error');
    });

    // next step
    $('.registration-form .btn-next').on('click', function () {
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;

        parent_fieldset.find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                next_step = false;
            } else {
                $(this).removeClass('input-error');
            }
        });

        if (next_step) {
            parent_fieldset.fadeOut(400, function () {
                $(this).next().fadeIn();
            });
        }

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
        $(this).parents('fieldset').fadeOut(400, function () {
            $(this).prev().fadeIn();
        });
    });

    // submit
    $('.registration-form').on('submit', function (e) {
        $(this).find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });

   
});
</script>
@endsection