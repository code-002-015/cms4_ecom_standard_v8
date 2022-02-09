<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class SalesHeader extends Model
{
    use SoftDeletes;

    protected $table = 'ecommerce_sales_headers';
    protected $fillable = ['user_id', 'order_number', 'response_code', 'customer_name', 'customer_contact_number', 'customer_address', 'customer_delivery_adress', 'delivery_tracking_number', 'delivery_fee_amount', 'delivery_courier', 'delivery_type',
        'gross_amount', 'tax_amount', 'net_amount', 'discount_amount', 'payment_status',
        'delivery_status', 'status','other_instruction','customer_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function balance($id){
        $amount = SalesHeader::whereId($id)->sum('net_amount');        
        $paid = (float) SalesPayment::where('sales_header_id',$id)->whereStatus('PAID')->sum('amount');
        return ($amount - $paid);
    }

    public static function paid($id){
        $paid = SalesPayment::where('sales_header_id',$id)->whereStatus('PAID')->sum('amount');
        return $paid;
    }
    public function getPaymentstatusAttribute(){
        $paid = SalesPayment::where('sales_header_id',$this->id)->whereStatus('PAID')->sum('amount');
  
        if($paid >= $this->net_amount){
            $tag_as_paid = SalesHeader::whereId($this->id)->update(['payment_status' => 'PAID']);
            if($this->delivery_status == 'Waiting for Payment'){
                $update_delivery_status = SalesHeader::whereId($this->id)->update(['delivery_status' => 'Processing Stock']);
            }
            return 'PAID';
        }else{
            return 'UNPAID';
        }
       
    }

    public function items(){
    	return $this->hasMany(SalesDetail::class,'sales_header_id');
    }

    public function deliveries(){
        return $this->hasMany(DeliveryStatus::class,'order_id');
    }

    public function customer_details(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function payment_status($order_num){
        $data = SalesHeader::where('order_number',$order_num)->first();
        return $data->payment_status;
        
    }

    public static function status(){
        $data = SalesHeader::where('status','PAID')->first();
        if(!empty($data)){
            return $data;
        } else {
            return NULL;
        }

    }

    public static function media_color($media) {

        switch($media){
            case 'Facebook':
                return '#3b5998';
            break;

            case 'Twitter':
                return '#00aced';
            break;

            case 'Youtube':
                return '#bb0000';
            break;

            case 'Instagram':
                return '#517fa4';
            break;

            default:
                return '#004E1F';
        }
    }

    public static function random_color()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public static function monthly_sales($yr)
    {
        $total_sales = '';
        $month_num  = date('m');
        for ($x = 1; $x <= $month_num; $x++) {

            $sales = DB::select("select sum(net_amount) as total_sale from ecommerce_sales_headers where year(created_at) = '$yr' and month(created_at) = $x and status = 'active' and payment_status = 'PAID' ");

            if(isset($sales[0]->total_sale)){
                $total = number_format($sales[0]->total_sale,2,'.','');
            } else {
                $total = 0;
            }

            $total_sales .= $total.',';
        }

        return $total_sales;
    }

    public static function socmed_order_volume($media,$startdate,$enddate)
    {
        $qry ="select sum(d.qty) as volume from ecommerce_sales_details d left join ecommerce_sales_headers h on h.id = d.sales_header_id where h.status = 'active' and h.payment_status = 'PAID' and h.created_at >='".date('Y-m-d',strtotime($startdate))." 00:00:00.000' and h.created_at <='".date('Y-m-d',strtotime($enddate))." 23:59:59.999' ";

        if($media == ''){
            $qry .= " and h.origin IS NULL";
        } else {
            $qry .= " and h.origin = '$media'";
        }

        $order = DB::select($qry);
        
        return number_format($order[0]->volume,0);  
    }

}
