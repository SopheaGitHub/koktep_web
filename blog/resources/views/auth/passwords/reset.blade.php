@extends('layouts.app')

@section('content')
<div class="padding-fixed-header"></div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <hr />
            <h4><?php echo trans('auth.reset_password'); ?></h4>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                {{ csrf_field() }}

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} required">
                    <label for="email" class="col-md-4 control-label"><?php echo trans('auth.email'); ?></label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} required">
                    <label for="password" class="col-md-4 control-label"><?php echo trans('auth.password'); ?></label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} required">
                    <label for="password-confirm" class="col-md-4 control-label"><?php echo trans('auth.confirm_password'); ?></label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-btn fa-refresh"></i> <?php echo trans('button.yes'); ?>
                        </button>
                    </div>
                </div>
            </form>
            <hr />
        </div>
    </div>
</div>
@endsection
