<?php

namespace App\Http\Controllers\Settings;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Validator;

use Facades\App\Helpers\ListingHelper;
use App\Helpers\Setting;

use Illuminate\Support\Facades\Input;
use App\Http\Requests\UserRequest;

use App\Mail\UpdatePasswordMail;
use App\Mail\AddNewUserMail;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\ActivityLog;

use Auth;


class UserController extends Controller
{
    use SendsPasswordResetEmails;

    private $searchFields = ['name'];

    public function __construct()
    {
        Permission::module_init($this, 'user');
    }

    public function index()
    {
        $listing = ListingHelper::required_condition('role_id', '<>', 6);
        $users = $listing->simple_search(User::class, $this->searchFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.users.index',compact('users','filter', 'searchType'));
    }

    public function create()
    {
        $roles = Role::orderBy('name','asc')->get();
        return view('admin.users.create',compact('roles'));
    }

    public function store(UserRequest $request)
    {
//        if(User::where('name',$request->fname.' '.$request->lname)->exists()){
//            return back()->with('duplicate', __('standard.users.duplicate_email'));
//        } else {
        $user = User::create([
            'firstname'      => $request->fname,
            'lastname'       => $request->lname,
            'name'           => $request->fname.' '.$request->lname,
            'password'       => str_random(32),
            'email'          => $request->email,
            'role_id'        => $request->role,
            'is_active'      => 1,
            'user_id'        => Auth::id(),
            'remember_token' => str_random(10)
        ]);

        $user->send_reset_temporary_password_email();

        return redirect()->route('users.index')->with('success', 'Pending for activation. Please remind the user to check the email and activate the account.');
//        }
    }

    public function edit($id)
    {
        $roles = Role::orderBy('name','asc')->get();
        $user = User::where('id',$id)->first();

        return view('admin.users.edit',compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        Validator::make($request->all(), [
            'fname' => 'required|max:150',
            'lname' => 'required|max:150',
            'email' => 'required|email|max:191|unique:users,email,'.$user->id,
            'role' => 'required|exists:role,id'
        ])->validate();

        $user->update([
            'firstname'=> $request->fname,
            'lastname' => $request->lname,
            'name'     => $request->fname.' '.$request->lname,
            'email'    => $request->email,
            'role_id'  => $request->role,
            'user_id'  => Auth::id(),
        ]);

        return redirect()->route('users.edit', $user->id)->with('success', __('standard.users.update_success'));
    }

    public function deactivate(Request $request)
    {
        $user = User::find($request->user_id);

        $user->update([
            'is_active' => 0,
            'user_id'   => Auth::id(),
        ]);
        $user->delete();

        return back()->with('success', __('standard.users.status_success', ['status' => 'deactivated']));
    }

    public function activate(Request $request)
    {
        $user = User::withTrashed()->find($request->user_id);

        $user->update([
            'is_active' => 1,
            'user_id'   => Auth::id(),
        ]);
        $user->restore();

        return back()->with('success', __('standard.users.status_success', ['status' => 'activated']));
    }


    public function show($id, $param = null)
    {
        $user = User::where('id',$id)->first();
        $logs = ActivityLog::where('log_by',$id)->orderBy('id','desc')->paginate(10);

        return view('admin.users.profile',compact('user','logs','param'));
    }

    public function filter()
    {
        $params = Input::all();

        return $this->apply_filter($params);
    }

    public function apply_filter($param = null)
    {
        $user = User::where('id',$param['id'])->first();

        if(isset($param['order'])){
            $logs = ActivityLog::where('log_by',$param['id'])->orderBy($param['sort'],$param['order'])->paginate($param['pageLimit']);
        } else {
            $logs = ActivityLog::where('log_by',$param['id'])->paginate($param['pageLimit']);
        }

        return view('admin.users.profile',compact('user','logs','param'));
    }

}
