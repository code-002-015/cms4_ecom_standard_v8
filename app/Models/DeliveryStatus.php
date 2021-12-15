<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ActivityLog;

class DeliveryStatus extends Model
{

    protected $table = 'ecommerce_delivery_status';
    protected $fillable = ['order_id', 'user_id', 'status', 'remarks'];


    public function getDeliveryAddressAttribute()
    {
        return "{$this->address_delivery_street} {$this->address_delivery_brgy}, {$this->address_delivery_city} {$this->address_delivery_province} {$this->address_delivery_zip}";
    }

    public function sales()
	{
	    return $this->belongsTo('App\Models\SalesHeader','order_id');
	}

}
