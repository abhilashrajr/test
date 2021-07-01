<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuTypes extends Model
{
    use HasFactory;
    protected $table = 'menu_types';

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'id', 'menu_type_id');
    }
}
