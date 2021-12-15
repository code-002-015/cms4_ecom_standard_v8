<?php

namespace App\Http\Controllers\Cms4Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Permission;

class FileManagerController extends Controller
{
    public function __construct()
    {
        Permission::module_init($this, 'file_manager');
    }

    public function index(Request $request)
    {
        return view('admin.cms4.files.index');
    }
}
