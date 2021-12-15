<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\EcommerceModel\Member;
use App\Helpers\ListingHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    private $searchFields = ['first_name'];
    private $advanceSearchFields = ['sponsor_id', 'code', 'entity_type', 'first_name', 'middle_name', 'last_name',
        'email', 'mobile', 'phone', 'work_phone', 'fax', 'address_street', 'address_city', 'address_province',
        'address_zip', 'address_zip', 'address_country', 'address_delivery_street', 'address_delivery_city',
        'address_delivery_province', 'address_delivery_zip', 'address_delivery_country', 'status', 'class',
        'created_at1', 'created_at2'];

    private $customQueryFields = ['first_name'];
    private $customQuery = ["CONCAT(`first_name`, ' ', `middle_name`, ' ', `last_name`) LIKE ?",
    "CONCAT(`first_name`, ' ', CONCAT(LEFT(`middle_name`,1),'.'), ' ', `last_name`) LIKE ?"];

    public function index(Request $request)
    {
        $listing = new ListingHelper($sortBy = 'desc', $perPage = 10, $defaultSearchField = 'created_at');

        $members = $listing->simple_search(Member::class, $this->searchFields, $this->customQuery, $this->customQueryFields);

        // Simple search init data
        $filter = $listing->get_filter($this->searchFields);

        // Advance search init data
        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueMembersBySponsorId = $listing->get_unique_item_by_column(Member::class, 'sponsor_id');
        $ranks = Member::ranks();

        $searchType = 'simple_search';

        $sponsors = Member::orderBy('first_name')->get();
        $entityTypes = Member::entity_types();
        $securityQuestions = Member::security_questions();

        return view('admin.members.index', compact('members', 'filter', 'advanceSearchData', 'uniqueMembersBySponsorId', 'ranks', 'searchType', 'sponsors', 'entityTypes', 'securityQuestions'));
    }

    public function advance_index(Request $request)
    {
        $equalQueryFields = ['sponsor_id', 'class', 'status'];

        $listing = new ListingHelper($sortBy = 'desc', $perPage = 10, $defaultSearchField = 'created_at');
        $members = $listing->advance_search(Member::class, $this->advanceSearchFields, $equalQueryFields);

        $filter = $listing->get_filter($this->searchFields);

        $advanceSearchData = $listing->get_search_data($this->advanceSearchFields);
        $uniqueMembersBySponsorId = $listing->get_unique_item_by_column(Member::class, 'sponsor_id');
        $ranks = Member::ranks();

        $searchType = 'advance_search';

        $sponsors = Member::orderBy('first_name')->get();
        $entityTypes = Member::entity_types();
        $securityQuestions = Member::security_questions();

        return view('admin.members.index', compact('members', 'filter', 'advanceSearchData', 'uniqueMembersBySponsorId', 'ranks', 'searchType', 'sponsors', 'entityTypes', 'securityQuestions'));
    }

    public function change_sponsor(Request $request)
    {
        Validator::make($request->all(), [
            'id' => 'required|integer|different:sponsor_id',
            'sponsor_id' => 'different:id',
        ])->validate();

        if (empty($request->sponsor_id) || !is_numeric($request->sponsor_id)) {
            Member::find($request->id)->update(['sponsor_id' => null]);
        } else {
            Member::find($request->id)->update(['sponsor_id' => $request->sponsor_id]);
        }
        return redirect()->back()->with('success', __('Successfully changed sponsor'));
    }

    public function unregistered()
    {
        $members = Member::where('code','')->orWhereNull('code')->get();
        // dd($members);
        return view('admin.members.unregistered',compact('members'));
    }

    public function update_code(Request $request)
    {
        $members = Member::whereId($request->member_id)->update([
            'code' => $request->member_code
        ]);
        // dd($members);
        return back()->with('success', 'Successfully Register Member');
    }
}
