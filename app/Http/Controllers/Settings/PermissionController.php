<?php

namespace App\Http\Controllers\Settings;

use App\Helpers\PanelHelper;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Permission;

use Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('checkPermission:admin/permission', ['only' => ['index']]);
        $this->middleware('checkPermission:admin/permission/create', ['only' => ['create','store']]);
        $this->middleware('checkPermission:admin/permission/edit', ['only' => ['show','edit','update']]);
        $this->middleware('checkPermission:admin/permission/delete', ['only' => ['destroy']]);
    }

    public function search(){

        $params = Input::all();

        return $this->index($params);

    }

    public function index($param = null)
    {
        $permissions = Permission::whereNotNull('id')->orderByDesc('updated_at');

        $pageLimit = 10;
        /*## Search Function##*/
        if(isset($param)){

            $order = 'desc';
            $sort = 'updated_at';

            if(isset($param['order'])){
                $order = $param['order'];
            }
            if(isset($param['sort'])){
                $sort = $param['sort'];
            }

            $permissions->orderBy($sort,$order);

            if(isset($param['showDeleted'])){
                $permissions->withTrashed();
            }

            if(isset($param['search'])){
                $permissions->where('module', 'like', '%'.$param['search'].'%');
            }

            if(isset($param['pageLimit'])){
                $pageLimit = $param['pageLimit'];
            }

        }
        else{
            $param = [];
            $permissions->orderBy('updated_at','desc');
        }
        /** End Search ***/

        $permissions = $permissions->paginate($pageLimit);

        return view('admin.settings.permission.index', compact('permissions','param'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $panelRoutes = PanelHelper::get_routes();
        $modules = Permission::modules();

        return view('admin.settings.permission.create', compact('panelRoutes', 'modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newData = $request->validate([
            'name' => 'required',
            'module' => 'required',
            'routes' => 'required|array',
            'methods' => 'required|array',
            'description' => 'required',
            'is_view_page' => ''
        ]);

        $newData['is_view_page'] = ($request->has('is_view_page')) ? 1 : 0;
        $newData['user_id'] = auth()->id();

        Permission::create($newData);

        return redirect()->route('permission.index')->with('success', __('standard.account_management.permissions.create_success'));

//        if(Permission::where('name',$request->permission)->orWhere('description',$request->description)->exists()){
//            return back()->with('duplicate', __('standard.account_management.permissions.duplicate_permission'));
//        } else {
//            $data = Permission::create([
//                'name'        => $request->permission,
//                'module'        => $request->module,
//                'description' => $request->description,
//                'user_id'     => Auth::id(),
//                'is_view_page' => ($request->is_view_page == 'on') ? 1 : 0
//            ]);
//            return redirect()->route('permission.index')->with('success', __('standard.account_management.permissions.create_success'));
//        }
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
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        $panelRoutes = PanelHelper::get_routes();
        $modules = Permission::modules();

        return view('admin.settings.permission.edit', compact('permission', 'panelRoutes', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $updateData = $request->validate([
            'name' => 'required',
            'module' => 'required',
            'routes' => 'required|array',
            'methods' => 'required|array',
            'description' => 'required',
            'is_view_page' => ''
        ]);

        $updateData['is_view_page'] = ($request->has('is_view_page')) ? 1 : 0;
        $updateData['user_id'] = auth()->id();

        $permission->update($updateData);

        return redirect()->route('permission.index')->with('success', __('standard.account_management.permissions.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    // }

    public function destroy(Request $request){

        $permission = Permission::findOrFail($request->permission_id);
        $permission->update([ 'user_id' => Auth::id() ]);
        $permission->delete();

        return back()->with('success', __('standard.account_management.permissions.delete_success'));
    }

    public function restore($id){
        Permission::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        Permission::whereId($id)->restore();

        return back()->with('success', __('standard.account_management.permissions.restore_success'));
    }
}
