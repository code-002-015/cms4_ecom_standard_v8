<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
