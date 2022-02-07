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
                        <h3 class="catalog-title">Manage Account</h3>
                        @if (Session::has('success-personal'))
                            <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span> {{ Session::get('success-personal') }}</div>
                        @endif

                        @if (Session::has('success-contact'))
                            <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"></span> {{ Session::get('success-contact') }}</div>
                        @endif

                        @if (Session::has('success-address'))
                            <div class="alert alert-success" role="alert"><span class="fa fa-info-circle"> Address Information has been updated</span>{{ Session::get('success-contact') }}</div>
                        @endif
                        <div class="tabs tabs-alt clearfix" id="tabs-profile">
                            <ul class="tab-nav clearfix">
                                <li><a href="#tab-personal"><i class="icon-user"></i> Personal Information</a></li>
                                <li><a href="#tab-contact"><i class="icon-pencil2"></i> Contact Information</a></li>
                                <li><a href="#tab-address"><i class="icon-reply"></i> Address</a></li>
                            </ul>

                            <div class="tab-container">
                                <div class="tab-content clearfix" id="tab-personal">
                                    <div class="gap-10"></div>
                                    <div class="form-style-alt">
                                        <form method="post" class="row" action="{{ route('my-account.update-personal-info') }}">
                                            @csrf
                                            <div class="col-lg-6">
                                                <label>First Name *</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" value="{{ old('firstname', $member->firstname) }}">
                                                    @error('firstname')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="col-lg-6">
                                                <label>Last Name *</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" value="{{ old('lastname', $member->lastname) }}">
                                                    @error('lastname')
                                                        <span class="text-danger">{{ $message }}</span>
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
                                    <div class="gap-10"></div>
                                    <div class="form-style-alt">
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
                                        <h4>Address Information</h4>

                                        <div class="gap-20"></div>
                                        <div class="address-card">
                                            <div class="form-style-alt">

                                                <div class="gap-10"></div>
                                                <div class="form-group form-wrap">
                                                    <label>Address Street *</label>
                                                    <input type="text" class="form-control @error('address_street') is-invalid @enderror" id="delivery_street" name="address_street" placeholder="Unit No./Building/House No./Street" value="{{ old('address_street', $member->address_street) }}"/>
                                                    @error('address_street')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>


                                                <div class="form-group form-wrap">
                                                    <label>Address Municipality *</label>
                                                    <input type="text" class="form-control @error('address_municipality') is-invalid @enderror" id="address_municipality" name="address_municipality" placeholder="Subd/Brgy/Municipality/City/Province" value="{{ old('address_municipality', $member->address_municipality) }}"/>

                                                    @error('address_municipality')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group form-wrap">
                                                    <label>City/Province *</label>
                                                    <input type="text" class="form-control @error('address_city') is-invalid @enderror" id="address_city" name="address_city" value="{{ old('address_city', $member->address_city) }}"/>

                                                    @error('address_city')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="form-group form-wrap">
                                                    <label>Zip </label>
                                                    <input type="text" class="form-control @error('address_zip') is-invalid @enderror" id="address_zip" name="address_zip" value="{{ old('address_zip', $member->address_zip) }}"/>
                                                    @error('address_zip')
                                                        <span class="text-danger">{{ $message }}</span>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
