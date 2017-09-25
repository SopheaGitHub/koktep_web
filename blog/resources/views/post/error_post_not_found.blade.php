@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <?php echo $data->error_post_not_found; ?>
            </div>
        </div>
    </div>
</div>
@endsection