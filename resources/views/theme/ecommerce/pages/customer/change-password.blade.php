@extends('theme.ecommerce.main')

@section('pagecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
@endsection

@section('content')
    <div class="content-wrap">
    <div class="container clearfix">
        <div class="row clearfix">
            @include('theme.ecommerce.layouts.sidebar-menu')

            <div class="col-md-9">
                <div class="clear"></div>
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <h3 class="catalog-title">{{$page->name}}</h3>
                        <form class="form message-form" role="form" autocomplete="off" action="{{ route('my-account.update-password') }}" method="post">
                            @csrf
                            @if (Session::has('success'))
                                <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success') }}</div>
                            @endif
                            <div class="form-group">
                                <label for="inputPasswordOld">Current Password *</label>
                                <input type="password" class="form-control col-md-6 @error('current_password') is-invalid @enderror" name="current_password" required id="inputPasswordOld">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputPasswordNew">New Password *</label>
                                <input type="password" class="form-control col-md-6 @error('password') is-invalid @enderror" name="password" required id="inputPasswordNew">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <p class="form-text small text-muted"> Minimum of eight (8) alphanumeric characters (combination of letters and numbers) with at least one (1) upper case and one (1) special character.</p>
                            </div>
                            <div class="form-group">
                                <label for="inputPasswordNewVerify">Confirm Password *</label>
                                <input type="password" class="form-control col-md-6 @error('confirm_password') is-invalid @enderror" name="confirm_password" required id="inputPasswordNewVerify">
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jsscript')
@endsection
