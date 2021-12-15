<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\BranchNumbers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchNumbersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $rs = BranchNumbers::where('branch_id',$request->id)->get();
        $table ='';
        if($rs->count() == 0){
            $table='<tr><td colspan="3">No record found!</td></tr>';
        }
        else{
            foreach($rs as $r){
                $table.='<tr>
                    <td>'.$r->name.'</td>
                    <td>'.$r->number.'</td>
                    <td><a class="btn btn-warning btn-sm delete-number" href="javascript:;" data-toggle="modal" data-id="'.$r->id.'|'.$request->id.'" data-target="#prompt-delete-number">Delete</a></td>
                </tr>';
            }
        }
      
        return $table;
    }

    public function delete(Request $request){
        BranchNumbers::whereId($request->con_id)->delete();
        return back()->with('success','Successfully deleted contact number!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rs = BranchNumbers::create([
            'branch_id' => $request->br_id,
            'name' => $request->name,
            'number' => $request->number
        ]);

        return $request->br_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BranchNumbers  $branchNumbers
     * @return \Illuminate\Http\Response
     */
    public function show(BranchNumbers $branchNumbers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BranchNumbers  $branchNumbers
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchNumbers $branchNumbers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BranchNumbers  $branchNumbers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchNumbers $branchNumbers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BranchNumbers  $branchNumbers
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchNumbers $branchNumbers)
    {
        //
    }
}
