@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <hr />
            <?php
                if(count($errors->all()) > 0) { ?>
                    <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b><i class="fa fa-info-circle"></i> <?php echo trans('auth.error'); ?> : <?php echo trans('auth.register_unsuccessful'); ?> </b><br />

                    <?php foreach ($errors->all() as $key => $value) {
                        echo '- '.$value.'<br />';
                    }?>
                    </div>
            <?php   } ?>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name" class="col-md-4 control-label"><?php echo trans('auth.name'); ?></label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" placeholder="<?php echo trans('auth.name'); ?>" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-md-4 control-label"><?php echo trans('auth.email'); ?></label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" placeholder="<?php echo trans('auth.email'); ?>" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-md-4 control-label"><?php echo trans('auth.password'); ?></label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" placeholder="<?php echo trans('auth.password'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 control-label"><?php echo trans('auth.confirm_password'); ?></label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo trans('auth.confirm_password'); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fa fa-btn fa-user"></i> <?php echo trans('auth.register'); ?>
                        </button>
                    </div>
                </div>
            </form>
            <hr />
        </div>
    </div>
</div>
@endsection
