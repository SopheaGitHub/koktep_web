@extends('layouts.app')

@section('content')
<?php
$objLanguage = new App\Models\Language();
if(\Session::has('locale')) {
    $locale = \Session::get('locale');
}else {
    $locale = 'en';
}
$language = $objLanguage->getLanguageByCode( $locale );
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <hr />
                    @include('auth.auth_left')
                </div>
                <div class="col-md-6">
                    <hr />
                    <?php
                        if(count($errors->all()) > 0) { ?>
                            <div class="alert alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <b><i class="fa fa-info-circle"></i> <?php echo trans('auth.register_unsuccessful'); ?> </b><br />

                            <?php foreach ($errors->all() as $key => $value) {
                                echo '- '.$value.'<br />';
                            }?>
                            </div>
                    <?php   } ?>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-4 control-label"><?php echo trans('auth.name'); ?></label>

                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control" name="name" placeholder="<?php echo trans('auth.name'); ?>" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label"><?php echo trans('auth.email'); ?></label>

                            <div class="col-md-8">
                                <input id="email" type="text" class="form-control" name="email" placeholder="<?php echo trans('auth.email'); ?>" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label"><?php echo trans('auth.password'); ?></label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control" name="password" placeholder="<?php echo trans('auth.password'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label"><?php echo trans('auth.confirm_password'); ?></label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="<?php echo trans('auth.confirm_password'); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="checkbox" style="font-size: 10px;">
                                    <em> <?php echo trans('auth.text_agree'); ?> <a href="#" role="button" data-toggle="information" data-id="3" data-languageid="<?php echo ((isset($language->language_id))? $language->language_id:'1'); ?>"> <?php echo trans('auth.privacy_policy'); ?> </a> <?php echo trans('auth.text_and'); ?> <a href="#" role="button" data-toggle="information" data-id="4" data-languageid="<?php echo ((isset($language->language_id))? $language->language_id:'1'); ?>"> <?php echo trans('auth.terms_conditions'); ?> </a> .</em>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-sm btn-primary" id="register">
                                    <i class="fa fa-btn fa-user"></i> <?php echo trans('auth.register'); ?>​​
                                </button>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;| <a class="btn btn-sm" href="{{ url('/login') }}"><i class="fa fa-btn fa-sign-in"></i><?php echo trans('text.login'); ?></a>
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
// $(document).ready(function() {
//     $(document).on('click', '#register', function() {
//         $('#register').prop('disabled', true);
//     });
// });
</script>
@endsection
