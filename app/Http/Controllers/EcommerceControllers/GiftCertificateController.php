<?php

namespace App\Http\Controllers\EcommerceControllers;

use App\Http\Requests\GiftCertificateRequest;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\EcommerceModel\GiftCertificate;
use App\Helpers\ListingHelper;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\EcommerceModel\SalesHeader;
use Response;


class GiftCertificateController extends Controller
{
    private $searchFields = ['code','status'];

    public function __construct()
    {
        Permission::module_init($this, 'gift_certificate');
    }


    public function index()
    {
        $listing = new ListingHelper('desc',10,'code');
        $giftcertificate = $listing->simple_search(GiftCertificate::class, $this->searchFields);

        $filter = $listing->get_filter($this->searchFields);
        $searchType = 'simple_search';

        return view('admin.giftcertificate.index',compact('giftcertificate','filter','searchType'));

    }

    public function verify(Request $request)
    {
        $coupon = GiftCertificate::whereCode($request->coupon)->whereStatus('Unused')->first();

        if(empty($coupon)){
            return response()->json([
                'success' => 0
            ]);
        }
        else{
            return response()->json([
                'success' => 1,
                'rate' => number_format($coupon->amount,2),
                'rate2' => (int)$coupon->amount,
                'code' => $request->coupon
            ]);
        }

    }

    public function upload()
    {

        return view('admin.giftcertificate.upload');
    }

    public function upload_submit(Request $request)
    {
        //$data='';
        $validate = $this->validate_upload($request->file('uploaded_file'));
        if($validate['errors'] > 0){
            return back()->with('error',$validate['remark']);
        }

        $x=0;
        $file = fopen($request->file('uploaded_file'), 'r');
        while (($d = fgetcsv($file)) !== FALSE) {
            $x++;
            if($x>1){
                $insert = GiftCertificate::create([
                    'code' => $d[0],
                    'amount' => $d[1],
                    'gc_type' => $d[2],
                    'status' => 'Unused',
                    'user_id' => Auth::id()
                ]);
            }
        }
        fclose($file);
        return back()->with('success','Successfully added new codes');

    }

    public function validate_upload($file){
        $data['remark'] = '';
        $data['errors'] = 0;

        $file = fopen($file,"r");
        $x = 0;
        $code_type = array("E-GIFT", "PHYSICAL GC", "COMPLEMENTARY");
        while (($d = fgetcsv($file)) !== FALSE) {
            $x++;

            if($x > 1){
                $gc = GiftCertificate::whereCode($d[0])->count();
                if($gc > 0){
                    $data['errors']++;
                    $data['remark'] .= '<br>'.$d[0].' already exist';
                }

                if((float) $d[1]<=0){
                    $data['errors']++;
                    $data['remark'] .= '<br>'.$d[0].' has invalid amount - '.$d[1];
                }

                if(!in_array(strtoupper($d[2]),$code_type)){
                    $data['errors']++;
                    $data['remark'] .= '<br>'.$d[0].' has invalid GC type. Allowed GC types: E-gift, Physical GC, Complementary';
                }
            }
        }
        fclose($file);
        return $data;
    }

    public function export(){
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=GC_Codes".date('Ymdhis').".csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $gc = GiftCertificate::all();
        $columns = array('Code', 'Amount', 'GC Type', 'Status', 'Added By', 'Sales#', 'Customer', 'Added On', 'Updated On');

        $callback = function() use ($gc, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($gc as $g) {
                fputcsv($file, array($g->code, $g->amount, $g->gc_type, $g->status, $g->user->name, $g->sales->order_number, $g->sales->customer_name, $g->created_at, $g->updated_at));
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function create()
    {
        $giftcertificate = GiftCertificate::all();

        return view('admin.giftcertificate.create',compact('giftcertificate'));
    }

    public function store(Request $request)
    {
        $save = GiftCertificate::create([
            'code' => $request->code,
            'amount' => $request->amount,
            'gc_type' => $request->gc_type,
            'status' => (isset($request->status) ? 'Used' : 'Unused'),
            'user_id' => Auth::id(),
            'sales_header_id' => $request->sales_header_id
        ]);

        return back()->with('success','Successfully saved new gift certificate!');
//        return $request;
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $giftcertificate = GiftCertificate::findOrFail($id);
        //$giftcertificate = GiftCertificate::all();
        return view('admin.giftcertificate.edit',compact('giftcertificate'));
    }


    public function update(Request $request, $id)
    {
        $save = GiftCertificate::findOrFail($id)->update([
            'code' => $request->code,
            'amount' => $request->amount,
            'gc_type' => $request->gc_type,
            'status' => (isset($request->status) ? 'Used' : 'Unused'),
            'user_id' => Auth::id(),
            'sales_header_id' => $request->sales_header_id
        ]);

        return redirect()->route('gift-certificate.index')->with('success','Successfully updated gift certificate!');
    }

    public function change_status(Request $request)
    {
        $pages = explode("|", $request->pages);

        //Validator::make($request->all(), [
        //    'sales_header_id' => 'exists:order_number,id',
        //])->validate();

        foreach ($pages as $page) {
            $publish = GiftCertificate::where('status', '!=', $request->status)
                ->whereId($page)
                ->update([
                    'status'  => (isset($request->status) ? 'Used' : 'Unused'),
                    'sales_header_id'  => $request->status,
                    'user_id' => Auth::user()->id
                ]);
        }

        return back()->with('success',  __('standard.pages.status_success',['STATUS' => $request->status]));
        //return $request;
    }

    public function destroy($id)
    {
        //
    }

    public function single_delete(Request $request)
    {
        $giftcertificate = GiftCertificate::findOrFail($request->pages);
        $giftcertificate->update([ 'user_id' => Auth::id() ]);
        $giftcertificate->delete();


        return back()->with('success','Successfully deleted gift certificate!');
    }

    public function multiple_delete(Request $request)
    {
        $giftcertificate = explode("|",$request->pages);

        foreach($giftcertificate as $gc){
            GiftCertificate::whereId($gc)->update(['user_id' => Auth::id() ]);
            GiftCertificate::whereId($gc)->delete();
        }

        return back()->with('success','Successfully deleted gift certificate(s)!');
    }

    public function restore($id)
    {
        GiftCertificate::withTrashed()->find($id)->update(['user_id' => Auth::id() ]);
        GiftCertificate::whereId($id)->restore();

        return back()->with('success','Successfully restored gift certificate!');
    }
}
