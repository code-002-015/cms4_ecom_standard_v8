<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Facades\App\Helpers\ListingHelper;
use Illuminate\Support\Facades\Input;

use App\Models\ActivityLog;
use App\Models\Permission;

class LogsController extends Controller
{
    private $searchFields = ['db_table', 'activity_date',];

    public function __construct()
    {
        Permission::module_init($this, 'audit_logs');
    }

    public function index()
    {
        $listing = ListingHelper::sort_by('activity_date');
        $logs = $listing->simple_search(ActivityLog::class, $this->searchFields);

        $filter = ListingHelper::get_filter($this->searchFields);

        $searchType = 'simple_search';

        return view('admin.settings.audit.index', compact('logs', 'filter', 'searchType'));
    }
}
