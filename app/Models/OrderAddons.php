<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddons extends Model
{
    use HasFactory;
    public function addons() {
        return $this->hasMany('App\Models\AddonItems','id','addon_items_id');
    }
}
