<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EcommerceModel\ProductionBranch;
use App\Helpers\ListingHelper;
use Auth;

class ProductionBranchController extends Controller
{
    private $searchFields = ['name','address_region','address_province','address_city','address_street'];

    public function __construct()
    {
        Permission::module_init($this, 'production_branch');
    }


    public function index()
    {
        $listing = new ListingHelper('desc',10,'name');
        $productions = $listing->simple_search(ProductionBranch::class, $this->searchFields);
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.productionbranches.index',  compact('productions', 'filter','searchType'));
    }

    public function create()
    {
        return view('admin.productionbranches.create');
    }

    public function store(Request $request)
    {
        $save = ProductionBranch::create([
            'name' => $request->name,
            'address_region' => $request->address_region,
            'address_province' => $request->address_province,
            'address_city' => $request->address_city,
            'address_street' => $request->address_street,
            'address_zip' => $request->address_zip,
            'contact_tel' => $request->contact_tel,
            'contact_mobile' => $request->contact_mobile,
            'contact_person' => $request->contact_person,
            'created_by' => Auth::id()
        ]);

        return back()->with('success','Successfully saved new Production Branch!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $productions = ProductionBranch::findOrFail($id);
        return view('admin.productionbranches.edit',compact('productions'));
    }

    public function update(Request $request, $id)
    {
        $save = ProductionBranch::findOrFail($id)->update([
            'name' => $request->name,
            'address_region' => $request->address_region,
            'address_province' => $request->address_province,
            'address_city' => $request->address_city,
            'address_street' => $request->address_street,
            'address_zip' => $request->address_zip,
            'contact_tel' => $request->contact_tel,
            'contact_mobile' => $request->contact_mobile,
            'contact_person' => $request->contact_person,
            'created_by' => Auth::id()
        ]);

        return redirect()->route('production-branches.index')->with('success','Successfully updated Production Branch!');
    }

    public function destroy(Request $request)
    {
        //
    }

    public function single_delete(Request $request)
    {
        $branch = ProductionBranch::findOrFail($request->pages);
        $branch->update([ 'created_by' => Auth::id() ]);
        $branch->delete();


        return back()->with('success','Successfully deleted Production Branch!');
    }

    public function multiple_delete(Request $request)
    {
        $branches = explode("|",$request->pages);

        foreach($branches as $branch){
            ProductionBranch::whereId($branch)->update(['created_by' => Auth::id() ]);
            ProductionBranch::whereId($branch)->delete();
        }

        return back()->with('success','Successfully deleted Production Branch!');
    }

    public function restore($id)
    {
        ProductionBranch::withTrashed()->find($id)->update(['created_by' => Auth::id() ]);
        ProductionBranch::whereId($id)->restore();

        return back()->with('success','Successfully restored Production Branch!');
    }
}
