<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    public function order_addons() {
        return $this->hasMany('App\Models\OrderAddons','order_items_id','id');
    }
}
