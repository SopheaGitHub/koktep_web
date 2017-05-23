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
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-cogs"></i>Account Settings</h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                        <a href="<?php echo url('/posts/create'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-check"></i> Save Change</a>
                        </span>
                    </div>
                </div>
                <hr />
                <p id="message"></p>
                <div class="row">


                    <div class="container-fluid">
                      <div class="panel panel-default">
                          <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-cog"></i> <b>Setting Form</b></h3>
                          </div>
                          <div class="panel-body">

                            <form action="#" method="post" enctype="multipart/form-data" id="form-post" class="form-horizontal">
                              <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                              <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                                <li><a href="#tab-image" data-toggle="tab">Images</a></li>
                                <li><a href="#tab-skills-charge" data-toggle="tab">Skills &amp; Charge </a></li>
                                <li><a href="#tab-contact" data-toggle="tab">Contacts</a></li>
                                <li><a href="#tab-change-password" data-toggle="tab">Change Password</a></li>
                              </ul>
                              <div class="tab-content">
                                <div class="tab-pane active" id="tab-general">
                                  <div class="form-group required">
                                    <label class="col-sm-2 control-label">User Name</label>
                                    <div class="col-sm-10">
                                      <input type="text" name="username" value="" class="form-control" id="input-image" />
                                    </div>
                                  </div>
                                  <div class="form-group required">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                      <input type="text" name="email" value="" class="form-control" id="input-image" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-10">
                                      <textarea class="form-control" style="max-width:100%;min-width:100%;min-height:200px;max-height:200px;"></textarea>
                                    </div>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-image">
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Profile</label>
                                    <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="" alt="" title="" data-placeholder="" /></a>
                                      <input type="hidden" name="image" value="" id="input-image" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">First Cover</label>
                                    <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="" alt="" title="" data-placeholder="" /></a>
                                      <input type="hidden" name="image" value="" id="input-image" />
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-sm-2 control-label">Second Cover</label>
                                    <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="" alt="" title="" data-placeholder="" /></a>
                                      <input type="hidden" name="image" value="" id="input-image" />
                                    </div>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-skills-charge">
                                  <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <td class="text-left">Skill</td>
                                          <td class="text-right">Skill Percent</td>
                                          <td class="text-right">Min Charge</td>
                                          <td class="text-right">Max Charge</td>
                                          <td class="text-right">Sort Order</td>
                                          <td></td>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr id="image-row">
                                          <td class="text-left"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-right"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-right"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-right"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-right"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-left"><button type="button" onclick="$('#image-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="5"></td>
                                          <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add Skill" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-contact">
                                  <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                      <thead>
                                        <tr>
                                          <td class="text-left">Detail</td>
                                          <td class="text-left">Type</td>
                                          <td class="text-right">Sort Order</td>
                                          <td></td>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr id="image-row">
                                          <td class="text-left">
                                            <textarea placeholder="Address" class="form-control"></textarea>
                                            <br />
                                            <select class="form-control">
                                              <option>Khan</option>
                                            </select>
                                            <br />
                                            <select class="form-control">
                                              <option>Country</option>
                                            </select>
                                            <br />
                                            <select class="form-control">
                                              <option>City</option>
                                            </select>
                                            <br />
                                            <input type="text" class="form-control" placeholder="Fax" />
                                            <br />
                                            <input type="text" class="form-control" placeholder="Phone" />
                                            <br />
                                            <input type="text" class="form-control" placeholder="Website" />
                                            <br />
                                          </td>
                                          <td class="text-left">
                                            <select class="form-control">
                                              <option>Company</option>
                                              <option>Home</option>
                                              <option>Organization</option>
                                              <option>Institue</option>
                                              <option>Center</option>
                                              <option>University</option>
                                              <option>School</option>
                                            </select>
                                          </td>
                                          <td class="text-right"><input type="text" name="post_image" value="" placeholder="" class="form-control" /></td>
                                          <td class="text-left"><button type="button" onclick="$('#image-row').remove();" data-toggle="tooltip" title="" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                      </tbody>
                                      <tfoot>
                                        <tr>
                                          <td colspan="3"></td>
                                          <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="Add Contact" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>

                                <div class="tab-pane" id="tab-change-password">
                                  Change Password
                                </div>
                                
                              </div>
                            </form>

                          </div>
                        </div>
                      </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection