@extends('theme.'.env('FRONTEND_TEMPLATE').'.main')

@section('pagecss')
@endsection

@section('content')
<section id="section-content">
    <canvas id="canvas"></canvas>
    <div class="content-wrap">

        <div class="container clearfix">
        
            <div class="row">
                <div class="col-lg-8 mb-5">
                    {!! $page->contents !!}
                </div>
                <div class="col-lg-4">
                    <h3>Leave Us a Message</h3>
                    <p><strong>Note:</strong> Please do not leave required fields (*) empty.</p>

                    @if(session()->has('success'))
                        <div class="style-msg successmsg">
                            <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('success') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                    @endif
                    
                    @if(session()->has('error'))
                        <div class="style-msg successmsg">
                            <div class="sb-msg"><i class="icon-thumbs-up"></i><strong>Success!</strong> {{ session()->get('error') }}</div>
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        </div>
                    @endif

                    <div class="form-style fs-sm">
                        <form action="{{ route('contact-us') }}" method="POST">
                        @method('POST')
                        @csrf
                            <div class="form-group mb-3">
                                <label for="fullName">Full Name *</label>
                                <input type="text" id="fullName" class="form-control form-input" name="name" placeholder="First and Last Name" required/>
                            </div>
                            
                            <div class="form-group mb-3">
                                <label for="emailAddress">E-mail Address *</label>
                                <input type="email" id="emailAddress" class="form-control form-input" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="hello@email.com" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="contactNumber">Contact Number *</label>
                                <input type="number" id="contactNumber" class="form-control form-input" name="contact" placeholder="Landline or Mobile" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="subject">Subject *</label>
                                <input type="text" id="subject" class="form-control form-input" name="subject" placeholder="Subject" required/>
                            </div>
                            <div class="form-group mb-3">
                                <label for="message">Message *</label>
                                <textarea name="message" id="message" class="form-control form-input textarea" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <script src="https://www.google.com/recaptcha/api.js?hl=en" async="" defer="" ></script>
                                <div class="g-recaptcha" data-sitekey="{{ \Setting::info()->google_recaptcha_sitekey }}"></div>
                                <label class="control-label text-danger" for="g-recaptcha-response" id="catpchaError" style="display:none;font-size: 14px;"><i class="fa fa-times-circle-o"></i>The Captcha field is required.</label></br>
                                @if($errors->has('g-recaptcha-response'))
                                    @foreach($errors->get('g-recaptcha-response') as $message)
                                        <label class="control-label text-danger" for="g-recaptcha-response"><i class="fa fa-times-circle-o"></i>{{ $message }}</label></br>
                                    @endforeach
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6 px-1">
                                    <button type="submit" class="button button-custom button-large mt-2 noleftmargin d-block w-100 clearfix">Submit</button>
                                </div>
                                <div class="col-md-6 px-1">
                                    <button type="reset" class="button button-default button-dark button-large mt-2 noleftmargin d-block w-100 clearfix">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('pagejs')
<script>
    $('#contactUsForm').submit(function (evt) {
        let recaptcha = $("#g-recaptcha-response").val();
        if (recaptcha === "") {
            evt.preventDefault();
            $('#catpchaError').show();
            return false;
        }
    });
</script>
@endsection
