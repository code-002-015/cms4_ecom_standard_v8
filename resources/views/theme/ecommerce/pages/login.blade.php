@extends('theme.ecommerce.main')

@section('content')
<div class="content-wrap">
	<div class="container clearfix">

		<div class="accordion accordion-lg mx-auto mb-0 clearfix" style="max-width: 550px;">

			<div class="accordion-header">
				<div class="accordion-icon">
					<i class="accordion-closed icon-lock3"></i>
					<i class="accordion-open icon-unlock"></i>
				</div>
				<div class="accordion-title">
					Login to your Account
				</div>
			</div>
			<div class="accordion-content clearfix">
				@if($message = Session::get('error'))
					<div class="alert alert-danger d-flex align-items-center" role="alert">
	                    <i data-feather="alert-circle" class="mg-r-10"></i> {{ $message }}
	                </div>
	            @endif
	            
				<form autocomplete="off" class="row mb-0" action="{{ route('customer-front.customer_login') }}" method="post">
					@csrf
					<div class="col-12 form-group">
						<label for="login-form-username">Email:</label>
						<input type="email" id="email" name="email" value="" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" />
					</div>

					<div class="col-12 form-group">
						<label for="login-form-password">Password:</label>
						<input type="password" id="password" name="password" value="" class="form-control" />
					</div>

					<div class="col-12 form-group">
						<button type="submit" class="button button-3d button-black m-0">Login</button>
						<a href="{{ route('ecommerce.forgot_password') }}" class="float-end">Forgot Password?</a>
					</div>
				</form>
			</div>

			<div class="accordion-header">
				<div class="accordion-icon">
					<i class="accordion-closed icon-user4"></i>
					<i class="accordion-open icon-ok-sign"></i>
				</div>
				<div class="accordion-title">
					New Signup? Register for an Account
				</div>
			</div>
			<div class="accordion-content clearfix">
				<form id="signUpForm" autocomplete="off" action="{{ route('customer-front.customer-sign-up') }}" method="post" class="row mb-0">
					@csrf
					<div class="col-12 form-group">
						<label for="register-form-name">Firstname:</label>
						<input type="text" id="fname" name="fname" value="{{ old('fname') }}" class="form-control @error('fname') is-invalid @enderror" />
						@error('fname')
							<span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>

					<div class="col-12 form-group">
						<label for="register-form-name">Lastname:</label>
						<input type="text" id="lname" name="lname" value="{{ old('lname') }}" class="form-control @error('lname') is-invalid @enderror" />
						@error('lname')
							<span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>

					<div class="col-12 form-group">
						<label for="register-form-email">Email Address:</label>
						<input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"/>
						@error('email')
							<span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>

					<div class="col-12 form-group">
						<label for="register-form-password">Password:</label>
						<input type="password" id="password" name="password" class="form-control @error('email') is-invalid @enderror" />
						@error('password')
							<span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>

					<div class="col-12 form-group">
						<label for="register-form-repassword">Re-enter Password:</label>
						<input type="password" id="password_confirmation" name="password_confirmation" value="" class="form-control @error('password_confirmation') is-invalid @enderror" />
						@error('password_confirmation')
							<span class="text-danger">{{ $message }}</span>
                        @enderror
					</div>

					<div class="form-group">
                        <script src="https://www.google.com/recaptcha/api.js?hl=en" async="" defer="" ></script>
                        <div class="g-recaptcha" data-sitekey="{{ Setting::info()->google_recaptcha_sitekey }}"></div>
                        <label class="control-label text-danger" for="g-recaptcha-response" id="catpchaError" style="display:none;font-size: 14px;"><i class="fa fa-times-circle-o"></i>The Captcha field is required.</label></br>
                        @if($errors->has('g-recaptcha-response'))
                            @foreach($errors->get('g-recaptcha-response') as $message)
                                <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                            @endforeach
                        @endif
                    </div>

					<div class="col-12 form-group">
						<button class="button button-3d button-black m-0" id="register-form-submit" name="register-form-submit" value="register">Register Now</button>
					</div>
				</form>
			</div>

		</div>

	</div>
</div>
@endsection

@section('pagejs')
	<script>
		$('#signUpForm').submit(function (evt) {
            let recaptcha = $("#g-recaptcha-response").val();
            if (recaptcha === "") {
                evt.preventDefault();
                $('#catpchaError').show();
                return false;
            }
        });
	</script>
@endsection