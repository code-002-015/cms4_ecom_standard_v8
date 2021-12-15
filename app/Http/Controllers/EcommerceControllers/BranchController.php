<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EcommerceModel\Branch;
use App\Helpers\ListingHelper;
use Auth;

class BranchController extends Controller
{
    private $searchFields = ['name','code', 'address', 'contact_person'];

    public function __construct()
    {
        Permission::module_init($this, 'branch');
    }


    public function index()
    {
        $listing = new ListingHelper();
        $branches = $listing->simple_search(Branch::class, $this->searchFields);
        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.branches.index',  compact('branches', 'filter','searchType'));

    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $save = Branch::create([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
            'contact_nos' => $request->contact_nos,
            'contact_person' => $request->contact_person ?? ' ',
            'email_address' => $request->email_address,
            'hotline' => $request->hotline,
            'branch_type' => $request->branch_type,
            'pickup_branch' => (isset($request->pickup_branch) ? 1 : 0),
            'token' => $request->token,
            'user_id' => Auth::id()
        ]);
        return redirect()->route('branch.index')->with('success','Successfully saved new branch!');
        //return back()->with('success','Successfully saved new branch!');
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $branches = Branch::findOrFail($id);
        return view('admin.branches.edit',compact('branches'));
    }


    public function update(Request $request, $id)
    {
        logger($request);
        $save = Branch::findOrFail($id)->update([
            'name' => $request->name,
            'code' => $request->code,
            'address' => $request->address,
            'contact_nos' => $request->contact_nos,
            'contact_person' => $request->contact_person ?? ' ',
            'email_address' => $request->email_address,
            'hotline' => $request->hotline,
            'branch_type' => $request->branch_type,
            'pickup_branch' => (isset($request->pickup_branch) ? 1 : 0),
            'token' => $request->token,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('branch.index')->with('success','Successfully updated branch!');
    }

    public function destroy(Request $request)
    {
        //
    }

    public function single_delete(Request $request)
    {
        $branch = Branch::findOrFail($request->pages);
        $branch->update([ 'user_id' => Auth::id() ]);
        $branch->delete();


        return back()->with('success','Successfully deleted branch!');
    }

    public function multiple_delete(Request $request)
    {
        $branches = explode("|",$request->pages);

        foreach($branches as $branch){
            Branch::whereId($branch)->update(['user_id' => Auth::id() ]);
            Branch::whereId($branch)->delete();
        }

        return back()->with('success','Successfully deleted branch!');
    }

    public function restore($id)
    {
        Branch::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        Branch::whereId($id)->restore();

        return back()->with('success','Successfully restored branch!');
    }
}
