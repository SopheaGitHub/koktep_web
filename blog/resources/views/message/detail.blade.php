@extends('layouts.app')

@section('content')
<div class="container">
    @include('common.account_header')
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content" style="overflow:hidden;">

                @include('message.message_header')

               <div style="text-align:center; background: #91beb1; color: #fff;">
                  <h3>Detail</h3>
               </div>
               <br />
               <div class="row">
                  <div class="col-md-6">
                     <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><i class="fa fa-btn fa-angle-double-left"></i>Back</button>
                  </div>
                  <div class="col-md-6">
                     <span class="pull-right">
                        <button type="button" id="popup-submit-post" data-toggle="tooltip" title="" class="btn btn-xs btn-primary button-submit-post" data-original-title=""><i class="fa fa-btn fa-reply"></i> Reply</button>
                     </span>
                  </div>
               </div>
               <br />
               <div>

                  <div>
                     <img style="width:30px; margin-top:5px; border-radius:50%;" src="http://localhost/development/koktep_storage//images/cache/catalog/1/profile/profile_chansophea1-100x100.jpg"> &nbsp; <span style="font-size: 12px;">Chan Sophea</span>
                  </div>
                  <div><b>New subscribers!</b></div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nihil eveniet ipsum nisi? Eaque odio quae debitis saepe explicabo alias sit tenetur animi...</p>

               </div>
            </div>
        </div>
    </div>
</div>
@endsection