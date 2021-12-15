<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rolepermission;
use App\Models\Permission;
use App\Models\Role;

use Auth;
use DB;

class AccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (env('APP_DEBUG') == "true") {
            $permissions = Permission::orderBy('module','asc')->get();
            $modules = Permission::distinct()->get(['module']);
        } else {
            $permissions = Permission::where('module', '!=', 'permission')->orderBy('module','asc')->get();
            $modules = Permission::where('module', '!=', 'permission')->distinct()->get(['module']);
        }
        $roles = Role::where('id', '>', 1)->orderBy('id','asc')->get();

        $access = [];
        foreach($permissions as $permission){
            foreach($roles as $role){
                if (Rolepermission::where('role_id', '=', $role->id)->where('permission_id', '=', $permission->id)->where('isAllowed','=',1)->exists()) {
                    array_push($access, $role->id."_".$permission->id);
                }
            }
        }

        return view('admin.settings.role_permission.index', compact('permissions','roles','access','modules'));
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
        //
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

    public function update_roles_and_permissions(Request $request)
    {

        $permissions = Permission::orderBy('id','asc')->get();
        $roles       = Role::where('id', '!=', 1)->orderBy('id','asc')->get();

        foreach($permissions as $permission){
            foreach($roles as $role){

                $allowed = 0;
                if(isset($request->cb["'".$permission->id."_".$role->id."'"])){
                    $allowed = 1;
                }

                $save = Rolepermission::updateOrCreate(
                    [
                        'role_id' => $role->id,
                        'permission_id' => $permission->id,
                        'user_id' => Auth::user()->id
                    ],
                    [
                        'user_id' => Auth::user()->id,
                        'isAllowed' => $allowed
                    ]
                );

            }
        }

        return back()->with('success', __('standard.account_management.access_rights.update_success'));
    }

}
