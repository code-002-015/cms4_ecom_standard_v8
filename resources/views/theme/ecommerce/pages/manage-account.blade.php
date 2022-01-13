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
                                <li class="active"><a href="{{ route('my-account.manage-account')}}">Manage Account</a></li>
                                <li><a href="{{ route('my-account.update-password') }}">Change Password</a></li>
                                <li><a href="{{ route('profile.sales') }}">My Orders</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <span onclick="openNav()" class="filter-btn d-block d-lg-none pb-3"><i class="fa fa-list"></i> Options</span>
                    <div class="tabs tabs-alt clearfix" id="tabs-profile">

                        <ul class="tab-nav clearfix">
                            <li><a href="#tab-personal"> Personal Info</a></li>
                            <li><a href="#tab-contact"> Contact Info</a></li>
                            <li><a href="#tab-address"> Address</a></li>
                        </ul>

{{--                        <nav>--}}
{{--                            <div class="nav nav-tabs account-tabs" id="nav-tab" role="tablist">--}}
{{--                                --}}
{{--                                <a href="#tab-1" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" role="tab" aria-controls="nav-home" aria-selected="true">Personal Info</a>--}}
{{--                                <a href="#tab-2" class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" role="tab" aria-controls="nav-profile" aria-selected="false">Contact Info</a>--}}
{{--                                <a href="#tab-3" class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" role="tab" aria-controls="nav-contact" aria-selected="false">Address</a>--}}
{{--                            </div>--}}
{{--                        </nav>--}}
                        <div class="tab-container">

                            <div class="tab-content clearfix" id="tab-personal">
                                <h4>Personal Information</h4>
                                <hr>
                                <div class="gap-10"></div>
                                <div class="form-style-alt">
                                    @if (Session::has('success-personal'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success-personal') }}</div>
                                    @endif
                                    <form method="post" class="row" action="{{ route('my-account.update-personal-info') }}">
                                        @csrf
                                        <div class="col-lg-6">
                                            <label>First Name *</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $member->firstname) }}">
                                                @error(['inputName' => 'firstname'])
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <label>Last Name *</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $member->lastname) }}">
                                                @error(['inputName' => 'lastname'])
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-md btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-content clearfix" id="tab-contact">
                                <h4>Contact Information</h4>
                                <hr>
                                <div class="gap-10"></div>
                                <div class="form-style-alt">
                                    @if (Session::has('success-contact'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span>{{ Session::get('success-contact') }}</div>
                                    @endif
                                    <form method="post" class="row" action="{{ route('my-account.update-contact-info') }}">
                                        @csrf

                                        <div class="col-lg-6">
                                            <label>Mobile Number *</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile', $member->mobile) }}">
                                                @error(['inputName' => 'mobile'])
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <label>Telephone Number </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
                                                @error(['inputName' => 'phone'])
                                                @enderror
                                            </div>
                                            <div class="gap-20"></div>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-md btn-success">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-content clearfix" id="tab-address">
                                <form method="post" action="{{ route('my-account.update-address-info') }}">
                                    @csrf
                                    @if (Session::has('success-address'))
                                        <div class="alert alert-success" role="alert"><span class="fa fa-info-circle">Personal information has been updated</span>{{ Session::get('success-contact') }}</div>
                                    @endif
                                    <h4>Delivery Address</h4>

                                    <div class="gap-20"></div>
                                    <div class="address-card">
                                        <div class="form-style-alt">

                                            <div class="gap-10"></div>
                                            <div class="form-group form-wrap">
                                                <label>Address Line 1 *</label>
                                                <input type="text" class="form-control @error('address_street') is-invalid @enderror" id="delivery_street" name="address_street" placeholder="Unit No./Building/House No./Street" value="{{ old('address_street', $member->address_street) }}"/>
                                                @error(['inputName' => 'address_street'])
                                                @enderror
                                            </div>


                                            <div class="form-group form-wrap">
                                                <label>Address Line 2 *</label>
                                                <input type="text" class="form-control @error('address_municipality') is-invalid @enderror" id="delivery_zip" name="address_municipality" placeholder="Subd/Brgy/Municipality/City/Province" value="{{ old('address_municipality', $member->address_municipality) }}"/>

                                                @error(['inputName' => 'address_municipality'])
                                                @enderror
                                            </div>

                                            <div class="form-group form-wrap">
                                                <label>City/Province *</label>
                                                <input type="text" class="form-control @error('address_city') is-invalid @enderror" id="delivery_zip" name="address_city" value="{{ old('address_city', $member->address_city) }}"/>

                                                @error(['inputName' => 'address_city'])
                                                @enderror
                                            </div>

                                            <div class="form-group form-wrap">
                                                <label>Zip </label>
                                                <input type="text" class="form-control @error('address_zip') is-invalid @enderror" id="delivery_zip" name="address_zip" value="{{ old('address_zip', $member->address_zip) }}"/>
                                                @error(['inputName' => 'address_zip'])
                                                @enderror
                                            </div>

                                            <div class="gap-10"></div>

                                        </div>
                                    </div>
                                    <div class="gap-10"></div>
                                    <button type="submit" class="btn btn-md btn-success">Save</button>
                                </form>
                            </div>
                        </div>
                        <div class="gap-20"></div>
                    </div>


                </div>
            </div>
        </div>
    </section>



@endsection

@section('jsscript')
    <script src="{{ asset('theme/lydias/plugins/responsive-tabs/js/jquery.responsiveTabs.js') }}"></script>
    <script>
        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt){
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        jQuery( "#tabs-profile" ).on( "tabsactivate", function( event, ui ) {
            jQuery( '.flexslider .slide' ).resize();
        });
    </script>
@endsection
