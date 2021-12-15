<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\DeliveryRate;
use Illuminate\Http\Request;
use App\Helpers\ListingHelper;
use App\Http\Controllers\Controller;
use Auth;

class DeliveryRateController extends Controller
{
    private $searchFields = ['region','province'];

    public function index()
    {
        $listing = new ListingHelper();
        $address = $listing->simple_search(DeliveryRate::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.deliveryrate.index',compact('address', 'filter', 'searchType'));

    }


    public function create()
    {
        $address = DeliveryRate::all();

        $json = $address->toJson();

        return view('admin.deliveryrate.create',compact('address','json'));
    }


    public function store(Request $request)
    {
        $save = DeliveryRate::create([
            'region' => $request->region,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'brgy' => $request->brgy,
            'zip' => $request->zip,
            'sla' => $request->sla,
            'rate' => $request->rate,
            'excess_fee' => $request->excess_fee,
            'remarks' => $request->remarks,
            'user_id' => Auth::id()
        ]);

        return back()->with('success','Successfully saved new rate!');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $rate = DeliveryRate::findOrFail($id);
        $address = DeliveryRate::all();
        return view('admin.deliveryrate.edit',compact('address','rate'));
    }


    public function update(Request $request, $id)
    {
        $save = DeliveryRate::findOrFail($id)->update([
            'region' => $request->region,
            'province' => $request->province,
            'municipality' => $request->municipality,
            'brgy' => $request->brgy,
            'zip' => $request->zip,
            'sla' => $request->sla,
            'rate' => $request->rate,
            'remarks' => $request->remarks,
            'excess_fee' => $request->excess_fee,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('deliveryrate.index')->with('success','Successfully updated delivery rate!');
    }


    public function destroy($id)
    {
        $delete = DeliveryRate::whereId($id)->delete();

        return back()->with('success','Successfully Deleted Record');
    }

    public function single_delete(Request $request)
    {
        $address = DeliveryRate::findOrFail($request->pages);
        $address->update([ 'user_id' => Auth::id() ]);
        $address->delete();


        return back()->with('success','Successfully deleted delivery rate!');
    }

    public function multiple_delete(Request $request)
    {
        $address = explode("|",$request->pages);

        foreach($address as $add){
            DeliveryRate::whereId($add)->update(['user_id' => Auth::id() ]);
            DeliveryRate::whereId($add)->delete();
        }

        return back()->with('success','Successfully deleted delivery rate(s)!');
    }

    public function restore($id)
    {
        DeliveryRate::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        DeliveryRate::whereId($id)->restore();

        return back()->with('success','Successfully restored delivery rate!');
    }
}
