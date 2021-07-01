<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Coupon extends Model
{
    use HasFactory;
    use Sortable;
    
    public $fillable = ['name','type','value','reduction','min_amount','max_reduction','start_date','end_date', 'active'];
    public $sortable = ['name','type','active'];
}
