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
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/profile/avatar_g.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <img src="<?php echo url('/images/catalog/profile/me2.jpg'); ?>" alt="Norway" style="width:100%" class="w3-hover-opacity">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <h4><b>About</b></h4>
                        <p>Just me, myself and I, exploring the universe of unknownment. I have a heart of love and an interest of lorem ipsum and mauris neque quam blog. I want to share my world with you. Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla. Praesent tincidunt sed tellus ut rutrum. Sed vitae justo condimentum, porta lectus vitae, ultricies congue gravida diam non fringilla.</p>
                        <hr>
                        
                        <h4>Technical Skills</h4>
                        <!-- Progress bars / Skills -->
                        <p>Photography</p>
                        <div class="progress">
                            <div class="progress-bar" style="width: 95%;">
                                95%
                            </div>
                        </div>
                        <p>Web Design</p>
                        <div class="progress">
                            <div class="progress-bar" style="width: 85%;">
                                85%
                            </div>
                        </div>
                        <p>Photoshop</p>
                        <div class="progress">
                            <div class="progress-bar" style="width: 80%;">
                                80%
                            </div>
                        </div>
                        <hr>
                        
                        <h4>How much I charge</h4>
                        <!-- Pricing Tables -->
                        <div class="w3-row-padding" style="margin:0 -16px">
                          <div class="w3-third w3-margin-bottom">
                            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                              <li class="w3-black w3-xlarge w3-padding-32">Basic</li>
                              <li class="w3-padding-16">Web Design</li>
                              <li class="w3-padding-16">Photography</li>
                              <li class="w3-padding-16">1GB Storage</li>
                              <li class="w3-padding-16">Mail Support</li>
                              <li class="w3-padding-16">
                                <h2>$ 10</h2>
                                <span class="w3-opacity">per month</span>
                              </li>
                              <li class="w3-light-grey w3-padding-24">
                                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Sign Up</button>
                              </li>
                            </ul>
                          </div>
                          
                          <div class="w3-third w3-margin-bottom">
                            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                              <li class="w3-teal w3-xlarge w3-padding-32">Pro</li>
                              <li class="w3-padding-16">Web Design</li>
                              <li class="w3-padding-16">Photography</li>
                              <li class="w3-padding-16">50GB Storage</li>
                              <li class="w3-padding-16">Endless Support</li>
                              <li class="w3-padding-16">
                                <h2>$ 25</h2>
                                <span class="w3-opacity">per month</span>
                              </li>
                              <li class="w3-light-grey w3-padding-24">
                                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Sign Up</button>
                              </li>
                            </ul>
                          </div>
                          
                          <div class="w3-third">
                            <ul class="w3-ul w3-border w3-white w3-center w3-opacity w3-hover-opacity-off">
                              <li class="w3-black w3-xlarge w3-padding-32">Premium</li>
                              <li class="w3-padding-16">Web Design</li>
                              <li class="w3-padding-16">Photography</li>
                              <li class="w3-padding-16">Unlimited Storage</li>
                              <li class="w3-padding-16">Endless Support</li>
                              <li class="w3-padding-16">
                                <h2>$ 25</h2>
                                <span class="w3-opacity">per month</span>
                              </li>
                              <li class="w3-light-grey w3-padding-24">
                                <button class="w3-button w3-teal w3-padding-large w3-hover-black">Sign Up</button>
                              </li>
                            </ul>
                          </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection