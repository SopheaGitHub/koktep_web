@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <hr />
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label"><?php echo trans('auth.name'); ?></label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" placeholder="<?php echo trans('auth.name'); ?>" value="{{ old('name') }}">

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label"><?php echo trans('auth.email'); ?></label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" placeholder="<?php echo trans('auth.email'); ?>" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label"><?php echo trans('auth.password'); ?></label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" placeholder="<?php echo trans('auth.password'); ?>">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="col-md-4 control-label"><?php echo trans('auth.confirm_password'); ?></label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo trans('auth.confirm_password'); ?>">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
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
