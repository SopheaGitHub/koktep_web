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
                    <div class="col-md-6"><h4><i class="fa fa-btn fa-tasks"></i>Posts Management</h4></div>
                    <div class="col-md-6">
                        <span class="pull-right">
                        <a href="<?php echo url('/posts/create'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-plus"></i> Add New Post</a>
                        </span>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/lights.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="<?php echo url('/posts/edit/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="<?php echo url('/posts/delete/1'); ?>" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/mountains.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/nature.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p1.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p2.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p3.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                        <hr />
                            <i class="fa fa-btn fa-eye"></i> View : 0121 | <i class="fa fa-btn fa-hand-peace-o"></i> Like : 23 | <i class="fa fa-btn fa-hand-rock-o"></i> Unlike : 212
                        <hr />
                        <div>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-pencil"></i> Edit</a>
                            <a href="#" class="btn btn-sm btn-primary"><i class="fa fa-btn fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="blog-pagination">
                    <nav aria-label="Page navigation">
                      <ul class="pagination">
                        <li>
                          <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                          </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                          <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection