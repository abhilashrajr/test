<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Orders extends Model
{
    use HasFactory;
    use Sortable;

    public $fillable = ['order_type','amount' ,'sub_total' ,'discount','status','payment_status'];
    public $sortable = ['order_type','order_time', 'delivery_postcode','payment_method','status'];
    public function payment_methods()
    {
        return $this->hasOne('App\Models\PaymentMethods', 'id', 'payment_method');
    }
    public function order_items() {
        return $this->hasMany('App\Models\OrderItems','order_id','id');
    }
}
