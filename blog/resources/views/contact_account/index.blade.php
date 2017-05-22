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
                    <div class="col-sm-12 col-md-12">
                      <h3 style="margin:0px; padding:0px;">Smile Company</h3>
                      <hr />
                      <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <th>Detail</th>
                                <th>Type</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>
                                  <p>#199, </p>
                                  <p>St Mao Tse Toung, </p>
                                  <p>Sangkat Toul Svay Prey 2, </p>
                                  <p>Khan Chamkarmorn, </p>
                                  <p>Phnom Penh </p>
                                  <p>Phone: 012 345 343 | 034 3453 34 </p>
                                  <p>Fax: ssd</p>
                                  <p>Email: company@gmail.com </p>
                                  <p>Website: <a href="#">www.company.com</a> </p>
                                </td>
                                <td>Company, Home, Organization</td>
                              </tr>
                            </tbody>
                        </table>
                      </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection