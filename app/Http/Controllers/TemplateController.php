<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Facades\App\Helpers\ListingHelper;

use App\Models\TemplateCategory;
use App\Models\Template;


use Storage;
use Auth;

class TemplateController extends Controller
{
    private $searchFields = ['name'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = ListingHelper::simple_search(Template::class, $this->searchFields);
        $filter = ListingHelper::get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.templates.index',compact('templates','filter', 'searchType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = TemplateCategory::where('status','Active')->get();
        return view('admin.templates.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = request()->all();
        $requestData['status'] = (isset($request->visibility) ? 'Active' : 'Inactive');
        $requestData['user_id'] = Auth::id();

        $temp = Template::create($requestData);

        if($request->hasFile('thumbnail_url')){
            $folder = 'thumbnails/'.$temp->id;
            $file = $request->file('thumbnail_url');
            $fileName = $file->getClientOriginalName();

            Template::find($temp->id)->update([
                'thumbnail_url' => $folder.'/'.$fileName,
            ]);

            Storage::disk('public')->putFileAs($folder, $file, $fileName);

        }

        return redirect()->route('templates.index')->with('success', 'Template has been added.');
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
        //
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
        //
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
}
