<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPermission:admin/file-manager', ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        return view('admin.files.index');
    }
}
