@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <hr />
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

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
                                <input id="password" type="password" class="form-control" placeholder="<?php echo trans('auth.password'); ?>" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> <?php echo trans('auth.remember_me'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> <?php echo trans('auth.login'); ?>
                                </button>

                                <a class="btn btn-sm btn-link" href="{{ url('/password/reset') }}"><?php echo trans('auth.forgot_password'); ?></a>
                            </div>
                        </div>
                    </form>
            <hr />
        </div>
    </div>
</div>
@endsection
