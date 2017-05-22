@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row profile">
        <div class="col-md-3">
            @include('common.filter_left') 
        </div>
        <div class="col-md-9">
            <div class="profile-content">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/lights.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/mountains.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/nature.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p1.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p2.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/p3.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                        <div class="w3-container w3-white">
                            <p><b>Lorem Ipsum</b></p>
                            <p>Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        </div>
                    </div>
                </div>
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