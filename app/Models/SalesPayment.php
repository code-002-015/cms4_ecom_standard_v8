<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesPayment extends Model
{

    protected $table = 'ecommerce_sales_payments';
    protected $fillable = ['sales_header_id','payment_type','amount','status', 'payment_date', 'receipt_number','created_by'
    ,'order_number','remark','trans_id','err_desc','signature','cc_name','cc_no','bank_name','country','remarks','response_body','response_id','response_code'
];

    public static function check_if_has_added_payments($id)
    {
        $data = SalesPayment::where('sales_header_id',$id)->exists();

        if($data){
            return 1;
        } else {
            return 0;
        }
    }

    public static function remaining_balance($amount,$id)
    {
        $paid_amount = SalesPayment::where('sales_header_id',$id)->sum('amount');

        return $amount-$paid_amount;
    }

    public static function check_if_has_remaining_balance($gross_amount,$id)
    {
        $balance = SalesPayment::remaining_balance($gross_amount,$id);
        if($balance == 0){
            return 0;
        } else {
            return 1;
        }

    }
}
