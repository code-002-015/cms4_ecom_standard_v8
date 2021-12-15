<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\Cart;
use App\EcommerceModel\Member;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberFrontController extends Controller
{
    public function sign_up(Request $request)
    {
        $member = null;
        if (auth()->check() && auth()->user()->profile && auth()->user()->profile->has_sponsor()) {
            $member = auth()->user()->profile->sponsor;
        } else if ($request->has('member')) {
            $member = Member::where('code', $request->member)->first();
        }

        $withSponsor = (!empty($member)) ? true : false;

        $entityTypes = Member::entity_types();
        $securityQuestions = Member::security_questions();
        $governmentIdTypes = Member::government_id_types();

        return view('theme.legande.ecommerce.member.sign-up2', compact('member', 'withSponsor', 'entityTypes','securityQuestions', 'governmentIdTypes'));
    }

    public function member_sign_up(Request $request)
    {
        Validator::make($request->all(), [
            'sponsor_id' => '',
            'entity_type' => ['required', Rule::in(Member::entity_types())],
            'first_name' => 'required',
            'middle_name' => '',
            'last_name' => 'required',
            'government_id' => '',
            'government_id_photo' => '',
            'file' => '',
            'birthday' => '',
            "username" => "required|unique:users,username",
            "password" => [
                'required',
                'min:6',
//                'regex:/[a-z]/', // must contain at least one lowercase letter
//                'regex:/[A-Z]/', // must contain at least one uppercase letter
//                'regex:/[0-9]/', // must contain at least one digit
//                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            "confirm_password" => 'required|same:password',
            "security_question" => "required",
            "security_answer" => "required",
            "address_country" => "required",
            "address_province" => "required",
            "address_city" => "required",
            "address_street" => "required",
            "address_zip" => "required",
            "address_delivery_country" => "required",
            "address_delivery_province" => "required",
            "address_delivery_city" => "required",
            "address_delivery_street" => "required",
            "address_delivery_zip" => "required",
            "email" => 'required|email|max:191|unique:users,email',
            "mobile" => "",
            "phone" => "",
            "work_phone" => "",
            "fax" => "",
        ])->validate();

        $user = User::create([
            'username'       => $request->username,
            'firstname'      => $request->first_name,
            'lastname'       => $request->last_name,
            'name'           => $request->first_name.' '.$request->last_name,
            'password'       => Hash::make($request->password),
            'email'          => $request->email,
            'is_active'      => 1,
            'user_type'      => 'incomplete_member',
        ]);

        \App\EcommerceModel\Member::create([
            'user_id' => $user->id,
            'sponsor_id' => $request->sponsor_id,
            'code' => $this->get_random_code(),
            'entity_type' => $request->entity_type,

            'government_id_type' => $request->government_id_type,
            'government_id' => $request->government_id,

            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,

            'email' => $request->email,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'work_phone' => $request->work_phone,
            'fax' => $request->fax,

            'address_street' => $request->address_street,
            'address_city' => $request->address_city,
            'address_province' => $request->address_province,
            'address_zip' => $request->address_zip,
            'address_country' => $request->address_country,

            'address_delivery_street' => $request->address_delivery_street,
            'address_delivery_city' => $request->address_delivery_city,
            'address_delivery_province' => $request->address_delivery_province,
            'address_delivery_zip' => $request->address_delivery_zip,
            'address_delivery_country' => $request->address_delivery_country,

            'security_question' => $request->security_question,
            'security_answer' => $request->security_answer,

            'status' => 'active'
        ]);

        Auth::login($user);

        Cart::updateOrCreate([
            'product_id' => 1,
            'user_id' => Auth::id(),
            'qty' => 1,
            'price' => 1000,
            'with_installation' => 0,
            'installation_fee' => 0,
        ]);

        return redirect()->route('product.front.list');
    }

    public function verify_member(Request $request)
    {
        // Member new username must be unique with username and code
        $exist = ['isExist' => true];
        $notExist = ['isExist' => false];

        if ($request->has('code')) {
            $member = Member::where('code', $request->code)->first();

            if (empty($member)) {
                $member = User::where('user_type', 'member')->where('username', $request->code)->first();

                if (empty($member)) {
                    return response()->json($notExist);
                } else {
                    $exist['sponsorId'] = $member->profile->id;
                }
            } else {
                $exist['sponsorId'] = $member->id;
            }

            return response()->json($exist);
        }

        return response()->json($notExist);
    }

    public function get_random_code($length = 6)
    {
        $token = "";
        $codeAlphabet= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet); // edited

        $member = \App\EcommerceModel\Member::where('code', $token)->first();

        while($token == "" || $member) {
            $token = "";
            for ($i = 0; $i < $length; $i++) {
                $token .= $codeAlphabet[random_int(0, $max-1)];
            }
            $member = \App\EcommerceModel\Member::where('code', $token)->first();
        }

        return $token;
    }
}
