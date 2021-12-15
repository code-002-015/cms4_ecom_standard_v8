<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class RegisterFrontController extends Controller
{
    public function sign_up(Request $request)
    {
        $page = new Page();
        $page->name = 'Sign Up';

        return view('theme.lydias.ecommerce.register.sign-up',compact('page'));
    }

    public function log_in(Request $request)
    {
        $page = new Page();
        $page->name = 'Login';

        return view('theme.lydias.ecommerce.register.log-in',compact('page'));
    }

    public function store(Request $request)
    {

        return view('theme.lydias.ecommerce.register.log-in');
    }

    public function forgot_password(Request $request)
    {
        $page = new Page();
        $page->name = 'Forgot Password';

        return view('theme.lydias.ecommerce.register.forgot-password',compact('page'));
    }
}
