<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Models\Cart;
use App\Models\SalesHeader;
use App\Models\Page;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MyAccountController extends Controller
{
    public function cancel_order(Request $request){
        $cancel = SalesHeader::whereId($request->sales_id)->delete();
        return back()->with('success_cancelled',"Your order has been successfully cancelled");
    }
    public function manage_account(Request $request)
    {
        $member = auth()->user();
        $user = auth()->user();
        $selectedTab = 0;

        if ($request->has('tab')) {
            $selectedTab = ($request->tab == 'contact-information') ? 1 : 0;
            $selectedTab = ($request->tab == 'my-address') ? 2 : $selectedTab;
        }

        return view('theme.ecommerce.pages.customer.manage-account', compact('member', 'user', 'selectedTab'));
    }

    public function update_personal_info(Request $request)
    {
        User::whereId(Auth::id())->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);

        return redirect()->back()->with('success-personal', 'Personal information has been updated');
    }

    public function update_contact_info(Request $request)
    {
        $route = route('my-account.manage-account').'?tab=contact-information';
        User::whereId(Auth::id())->update([
            'mobile' => $request->mobile,
            'phone' => $request->phone,
        ]);

        return redirect()->back()->with('success-personal', 'Contact information has been updated');
    }

    public function update_address_info(Request $request)
    {
        $route = route('my-account.manage-account').'?tab=my-address';
        User::whereId(Auth::id())->update([
            'address_street' => $request->address_street,
            'address_city' => $request->address_city,
            'address_municipality' => $request->address_municipality,
            'address_zip' => $request->address_zip
        ]);

        return back()->with([
            'tab' => 'my-address',
            'success-address' =>  'Address information has been updated.'
        ]);
    }

    public function change_password()
    {
        $page = new Page();
        $page->name = 'Change Password';

        return view('theme.ecommerce.pages.customer.change-password',compact('page'));
    }

    public function update_password(Request $request)
    {
        $personalInfo = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, auth()->user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => [
                'required',
                'min:8',
                'max:150', 
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character              
            ],
            'confirm_password' => 'required|same:password',
        ]);

        auth()->user()->update(['password' => bcrypt($personalInfo['password'])]);

        return redirect()->back()->with('success', 'Password has been updated');
    }

}
