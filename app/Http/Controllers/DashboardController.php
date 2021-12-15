<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use \App\Models\ActivityLog;


use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
    	if(Auth::user()->role_id == '6'){
    		Auth::logout();
    		return back()->with('error','Restricted access');
    	}

    	$logs = ActivityLog::where('log_by', auth()->id())->orderBy('id','desc')->paginate(15);

        return view('admin.dashboard.index',compact('logs'));
    }
}
