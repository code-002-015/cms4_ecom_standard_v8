@extends('theme.ecommerce.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    </div>
    <span onclick="closeNav()" class="dark-curtain"></span>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="desk-cat d-none d-lg-block">
                        <div class="quick-nav">
                            <h3 class="catalog-title">My Account</h3>
                            <ul>
                                <li><a href="{{ route('my-account.manage-account')}}">Manage Account</a></li>
                                <li class="active"><a href="{{ route('my-account.update-password') }}">Change Password</a></li>
                                <li><a href="{{ route('profile.sales') }}">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <span onclick="openNav()" class="filter-btn d-block d-lg-none pb-3"><i class="fa fa-list"></i> Options</span>
                    <h4>Change Password</h4>
                    <form class="form message-form" role="form" autocomplete="off" action="{{ route('my-account.update-password') }}" method="post">
                        @csrf
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="inputPasswordOld">Current Password</label>
                            <input type="password" class="form-control col-md-6 @error('current_password') is-invalid @enderror" name="current_password" required id="inputPasswordOld">
                            @error(['inputName' => 'current_password'])
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordNew">New Password</label>
                            <input type="password" class="form-control col-md-6 @error('password') is-invalid @enderror" name="password" required id="inputPasswordNew">
                            <span class="form-text small text-muted">
                                    Minimum of 8 characters
                                </span>
                            @error(['inputName' => 'password'])
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="inputPasswordNewVerify">Verify Password</label>
                            <input type="password" class="form-control col-md-6 @error('confirm_password') is-invalid @enderror" name="confirm_password" required id="inputPasswordNewVerify">
                            <span class="form-text small text-muted">
                                    To confirm, type the new password again.
                                </span>
                            @error(['inputName' => 'confirm_password'])
                            @enderror

                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn primary-btn more2">Save</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>


@endsection

@section('jsscript')

@endsection
