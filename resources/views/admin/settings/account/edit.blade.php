@extends('admin.layouts.app')

@section('pagetitle')
    Account Settings
@endsection

@section('pagecss')
    <link rel="stylesheet" href="{{ asset('css/dashforge.profile.css') }}">

    <style>
        .pass_show{ position: relative }
        .pass_show .ptxt:hover{ color: #333333; }
        .pass_show .ptxt {  position: absolute; top: 50%; right: 10px; z-index: 1; color: #f36c01; margin-top: -10px; cursor: pointer; transition: .3s ease all;
        }
    </style>
@endsection

@php
    $showTab2 = ($errors->has('email') || $errors->has('current_password') ||$errors->has('new_password') ||$errors->has('confirm_password')) ? true : false;
    $showPassword = ($errors->has('current_password') ||$errors->has('new_password') ||$errors->has('confirm_password')) ? true : false;
@endphp
@section('content')
    <div class="container pd-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item" aria-current="page"><a href="{{route('dashboard')}}">CMS</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Account Settings</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Account Settings</h4>
            </div>
        </div>

        <div class="alert alert-danger print-error-msg" style="display:none" role="alert">
            <ul></ul>
        </div>

        <div class="row row-sm">
            <div class="col-lg-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link @if(!$showTab2) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if($showTab2) active @endif " id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Account</a>
                    </li>
                </ul>
                <div class="tab-content rounded bd bd-gray-300 bd-t-0 pd-20" id="myTabContent">
                    <div class="tab-pane fade @if(!$showTab2) show active @endif" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form class="col-md-6" method="POST" action="{{ route('account.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="media mg-b-30 mg-t-20">
                                @if(Auth::user()->avatar == '')
                                    <img src="{{ asset('images/user.png') }}" id="userLogo" class="wd-100 rounded-circle mg-r-20" alt="">
                                @else
                                    <img src="{{ $user->avatar }}" id="userLogo" class="wd-100 rounded-circle mg-r-20" alt="">
                                @endif
                                <div class="media-body pd-t-30">
                                    <h5 class="mg-b-0 tx-inverse tx-bold">{{ $user->fullname }}</h5>
                                    <p>{{ User::userRole($user->role_id) }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Avatar</label>
                                <div class="custom-file">
                                    <input name="avatar" type="file" class="custom-file-input" id="user_image">
                                    <label class="custom-file-label" for="customFile" id="img_name">@if(Auth::user()->avatar == '') Choose file @else {{ $user->get_image_file_name() }} @endif</label>
                                </div>
                                <p class="tx-10">
                                    Required image dimension: {{ env('USER_LOGO_WIDTH') }}px by {{ env('USER_LOGO_HEIGHT') }}px <br /> Maximum file size: 1MB <br /> Required file type: .jpeg .png
                                </p>
                            </div>
                            <div class="form-group">
                                <label class="d-block">First Name <span class="tx-danger">*</span></label>
                                <input type="text" name="firstname" class="form-control" required value="{{ old('firstname', $user->firstname) }}">
                                @error('firstname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="d-block">Last Name <span class="tx-danger">*</span></label>
                                <input type="text" name="lastname" class="form-control" required value="{{ old('lastname', $user->lastname) }}">
                                @error('lastname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-row">
                                <div class="col-lg-12 mg-t-10">
                                    <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade @if($showTab2) show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form class="col-md-6" method="post" action="{{route('account.update-email')}}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="d-block">Email <i class="tx-danger">*</i></label>
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="email" name="email" class="form-control" required value="{{ $user->email }}" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm btn-uppercase" type="submit">Change Email</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-6">
                            <div class="form-group">
                                <a class="btn btn-white tx-primary mg-t-20" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                    <i data-feather="alert-circle"></i> Change Password
                                </a>

                                <div class="collapse mg-t-15 @if ($showPassword) show @endif" id="collapseExample">
                                    <form method="post" action="{{ route('account.update-password') }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label class="d-block">Old Password *</label>
                                            <input type="password" name="current_password" class="form-control" required>
                                            @error('current_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">New Password * <span class="tx-color-03">(Min. 8, alphanumeric, at least 1 upper case, 1 number and 1 special character)</span></label>
                                            <input type="password" name="new_password" class="form-control" required>
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Confirm Password *</label>
                                            <input type="password" class="form-control" name="confirm_password" required>
                                            @error('confirm_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-sm btn-uppercase">Save Password</button>
                                                </div>
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

    <div class="pos-fixed b-10 r-10">
        <div id="toast_successs" class="toast bg-success bd-0 wd-350" data-delay="3000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body pd-6 tx-white">
                <button type="button" class="ml-2 mb-1 close tx-normal tx-shadow-none" data-dismiss="toast" aria-label="Close">
                    <span class="tx-white" aria-hidden="true">&times;</span>
                </button>
                <h6 class="mg-b-15 mg-t-15 tx-white"><i data-feather="alert-circle"></i> SUCCESS!</h6>
                <p id="a_msg"></p>
            </div>
        </div>
    </div>

@endsection

@section('pagejs')
    <script src="{{ asset('scripts/account/update.js') }}"></script>

    {{--    Image validation--}}
    <script>
        let BANNER_WIDTH = "{{ env('USER_LOGO_WIDTH') }}";
        let BANNER_HEIGHT =  "{{ env('USER_LOGO_HEIGHT') }}";
    </script>
    <script src="{{ asset('js/image-upload-validation.js') }}"></script>
    {{--    End Image validation--}}
@endsection

@section('customjs')
    <script>
        function readURL(file) {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('#userLogo').attr('src', e.target.result);
                $('#img_name').html(file.name);
            }

            reader.readAsDataURL(file);
        }

        $("#user_image").change(function(evt) {
            validate_images(evt, readURL);
        });
    </script>
@endsection

