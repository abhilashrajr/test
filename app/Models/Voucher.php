<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Voucher extends Model
{
    use HasFactory;
    use Sortable;
    // public $fillable = ['name','sort_order'];
     public $fillable = ['name', 'description','image', 'price', 'sort_order', 'active'];
     public $sortable = ['name','price', 'sort_order','active'];
}
