<?php

namespace App\Http\Controllers\EcommerceControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ListingHelper;

use App\EcommerceModel\ShareableLink;

use Auth;

class ShareableLinkController extends Controller
{
    private $searchFields = ['name'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listing = new ListingHelper();
        $links = $listing->simple_search(ShareableLink::class, $this->searchFields);

        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.shareable-links.index',  compact('links', 'filter','searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shareable-links.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|unique:media_shareable_links,name,',
            'soc_med' => 'required',
            'url' => 'required'
        ])->validate();

        ShareableLink::create([
            'name' => $request->name,
            'soc_media' => $request->soc_med != 'other' ? $request->soc_med : $request->other,
            'url' => $request->url."?origin=".$request->soc_med,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('shareable-links.index')->with('success','Shareable link has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $link = ShareableLink::find($id);
        return view('admin.shareable-links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'soc_med' => 'required',
            'url' => 'required'
        ])->validate();

        if($request->soc_med == 'other'){
            $origin = $request->other;
        } else {
            $origin = $request->soc_med;
        }
        
        ShareableLink::find($id)->update([
            'name' => $request->name,
            'soc_media' => $request->soc_med != 'other' ? $request->soc_med : $request->other,
            'url' => $request->url."?origin=".$origin,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('shareable-links.index')->with('success','Shareable link has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function single_delete(Request $request)
    {
        $link = ShareableLink::findOrFail($request->links);
        $link->update([ 'user_id' => Auth::id() ]);
        $link->delete();


        return back()->with('success','Link has been deleted!');
    }

    public function multiple_delete(Request $request)
    {
        $links = explode("|",$request->links);

        foreach($links as $link){
            ShareableLink::whereId($link)->update(['user_id' => Auth::id() ]);
            ShareableLink::whereId($link)->delete();
        }

        return back()->with('success','Selected link(s) has been deleted!');
    }


    public function restore($id)
    {
        ShareableLink::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        ShareableLink::whereId($id)->restore();

        return back()->with('success','Link has been restored!');
    }
}
