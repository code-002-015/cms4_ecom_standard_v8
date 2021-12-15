<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Models\MediaAccounts;
use App\Models\Permission;
use App\Models\Setting;

use Auth;

class WebController extends Controller
{
    public function __construct()
    {
        Permission::module_init($this, 'website_settings');
    }

    public function edit(Request $request)
    {
        $web = Setting::first();
        $medias = MediaAccounts::get();

        return view('admin.settings.website.index',compact('web','medias'));
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'website_name' => 'required',
            'company_name' => 'required',
            'copyright'    => 'required',
            'web_favicon'  => 'mimes:ico|max:100',
            'company_logo' => 'image|mimes:jpeg,png,jpg,svg|max:1000',
        ]);


        $web = Setting::first();
        $web->website_name = $request->website_name;
        $web->company_name = $request->company_name;
        $web->copyright = $request->copyright;
        $web->google_map = $request->g_map;
        $web->user_id = Auth::id();
        $web->google_recaptcha_sitekey = $request->g_recaptcha_sitekey;
        $web->save();


        if($web){
            if($request->has('web_favicon')) {
                $this->upload_favicons($request->file('web_favicon'));
            }

            if($request->has('company_logo')) {
                $this->upload_logo($request->file('company_logo'));
            }
            return back()->with('success', __('standard.settings.website.update_success'));
        } else {
            return back()->with('error', __('standard.settings.website.update_failed'));
        }
    }

    public function upload_favicons($favicon)
    {
        $fileName = time().'_'.$favicon->getClientOriginalName();
        $web = Setting::first()->update([
            'website_favicon' => $fileName,
            'user_id' => Auth::id()
        ]);

        if($web){
            $image_url = Storage::putFileAs('/public/icons', $favicon, $fileName);
        }

    }

    public function upload_logo($logo)
    {
        $fileName = time().'_'.$logo->getClientOriginalName();
        $web = Setting::first()->update([
            'company_logo' => $fileName,
            'user_id' => Auth::id()
         ]);

        if($web){
            $image_url = Storage::putFileAs('/public/logos', $logo, $fileName);
        }

    }

    public function remove_logo(Request $request){

        $web = Setting::first();
        $web->company_logo = '';
        $web->user_id = Auth::id();
        $web->save();

        Storage::delete(Setting::select('company_logo')->where('id',$web->id)->get());

        return back()->with('success', __('standard.settings.website.remove_logo_success'));
    }

    public function remove_icon(Request $request){

        $web = Setting::first();
        $web->website_favicon = '';
        $web->user_id = Auth::id();
        $web->save();

        Storage::delete(Setting::select('website_favicon')->where('id',$web->id)->get());

        return back()->with('success', __('standard.settings.website.remove_favicon_success'));
    }


    public function update_contacts(Request $request)
    {
        $contacts = Setting::first();
        $contacts->company_address = $request->company_address;
        $contacts->mobile_no = $request->mobile_no;
        $contacts->fax_no = $request->fax_no;
        $contacts->tel_no = $request->tel_no;
        $contacts->email = $request->email;
        $contacts->user_id = Auth::id();
        $contacts->save();

        if($contacts){
            return back()->with('success', __('standard.settings.website.contact_update_success'));
        } else {
            return back()->with('error', __('standard.settings.website.contact_update_failed'));
        }
    }

    public function update_ecommerce(Request $request)
    {
        $ecommerce = Setting::first();
        $ecommerce->min_order = $request->min_order;
        $ecommerce->promo_is_displayed = (isset($_POST['promo_is_displayed']) == '1' ? '1' : '0');
        $ecommerce->review_is_allowed = (isset($_POST['review_is_allowed']) == '1' ? '1' : '0');
        $ecommerce->pickup_is_allowed = (isset($_POST['pickup_is_allowed']) == '1' ? '1' : '0');

        $ecommerce->min_order_is_allowed = (isset($_POST['min_order_is_allowed']) == '1' ? '1' : '0');
        $ecommerce->flatrate_is_allowed = (isset($_POST['flatrate_is_allowed']) == '1' ? '1' : '0');
        $ecommerce->delivery_collect_is_allowed = (isset($_POST['delivery_collect_is_allowed']) == '1' ? '1' : '0');

        $ecommerce->delivery_note = $request->delivery_note;
        $ecommerce->coupon_limit = $request->coupon_limit;
        $ecommerce->save();

        if($ecommerce){
            return back()->with('success','Successfully Updated Ecommerce Settings');
        } else {
            return back()->with('error', __('standard.settings.website.contact_update_failed'));
        }
    }

    public function update_paynamics(Request $request)
    {
        $ecommerce = Setting::first();
        $accepted_payments = '';
        if( isset($request->accepted_payments) && is_array($request->accepted_payments) ) {
            $accepted_payments = implode(',', $request->accepted_payments);
        }
        $ecommerce->accepted_payments = $accepted_payments;

        $ecommerce->save();

        if($ecommerce){
            return back()->with('success','Successfully Updated Paynamics Settings');
        } else {
            return back()->with('error', __('standard.settings.website.contact_update_failed'));
        }
    }

    public function update_media_accounts(Request $request)
    {
        $data   = $request->all();

        $mid   = $data['mid'];
        $urls   = $data['url'];
        $medias = $data['social_media'];

        foreach($medias as $key => $i){
            if($urls[$key] <> null){
                if($mid[$key] == null){
                    MediaAccounts::create([
                        'name' => $i,
                        'media_account' => $urls[$key],
                        'user_id' => Auth::id()
                    ]);
                } else {
                    MediaAccounts::where('id',$mid[$key])->update([
                        'name' => $i,
                        'media_account' => $urls[$key],
                        'user_id' => Auth::id()
                    ]);
                }
            }
        }

        return back()->with('success', __('standard.settings.website.social_updates_success'));
    }

    public function remove_media(Request $request)
    {
        $media = MediaAccounts::whereId($request->id);

        $media->update([ 'user_id' => Auth::id() ]);
        $media->delete();

        return back()->with('success', __('standard.settings.website.social_remove_success'));
    }

    public function update_data_privacy(Request $request)
    {
        $privacy = Setting::first();
        $privacy->data_privacy_title = $request->privacy_title;
        $privacy->data_privacy_popup_content = $request->pop_up_content;
        $privacy->data_privacy_content = $request->content;
        $privacy->user_id = Auth::id();
        $privacy->save();

        return back()->with('success', __('standard.settings.website.privacy_updates_success'));
    }
}
