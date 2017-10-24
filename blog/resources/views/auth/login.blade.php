@extends('layouts.app')

@section('content')
<div class="padding-fixed-header"></div>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <hr />
                    @include('auth.auth_left')
                    <br />
                    <p><?php echo trans('auth.point_user_register'); ?></p>
                    <a class="btn btn-sm btn-primary" href="{{ url('/register') }}"><i class="fa fa-btn fa-user"></i> <?php echo trans('auth.register'); ?>​​</a>
                </div>
                <div class="col-md-6">
                    <hr />
                    <?php
                        if(count($errors->all()) > 0) { ?>
                            <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <b><i class="fa fa-info-circle"></i> <?php echo trans('auth.login_unsuccessful'); ?> </b><br />

                            <?php foreach ($errors->all() as $key => $value) {
                                $search  = ['The email field is required.', 'The password field is required.'];
                                $replace = [trans('auth.email_required'), trans('auth.password_required')];
                                echo '- '.str_replace($search, $replace, $value).'<br />';
                            }?>
                            </div>
                    <?php   } ?>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group required">
                            <label for="email" class="col-md-4 control-label"><?php echo trans('auth.email'); ?></label>

                            <div class="col-md-8">
                                <input id="email" type="text" class="form-control" name="email" placeholder="<?php echo trans('auth.email'); ?>" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group required">
                            <label for="password" class="col-md-4 control-label"><?php echo trans('auth.password'); ?></label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" placeholder="<?php echo trans('auth.password'); ?>" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> <?php echo trans('auth.remember_me'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-primary" id="login">
                                    <i class="fa fa-btn fa-sign-in"></i> <?php echo trans('auth.login'); ?>
                                </button>

                                <a class="btn btn-sm" href="{{ url('/password/reset') }}"><?php echo trans('auth.forgot_password'); ?></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr />
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$(document).ready(function() {
    // $(document).on('click', '#login', function() {
    //     $('#login').prop('disabled', true);
    // });
});
</script>
@endsection