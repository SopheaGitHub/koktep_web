@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            @include('common.account_left')
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-object-group"></i>Posts Groups</h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                            <a href="<?php echo url('/posts?account_id=1'); ?>" class="btn btn-sm btn-default"><i class="fa fa-btn fa-undo"></i> Cancel</a>
                            <button type="button" id="submit-post" data-toggle="tooltip" title="" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> Save</button>
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <div class="row">


                    <div class="container-fluid">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title"><b><i class="fa fa-btn fa-plus"></i>Add New Post Group</b></h3>
                          </div>
                          <div class="panel-body">

                            

                          </div>
                        </div>
                      </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection