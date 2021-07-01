<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class PaynowOrders extends Model
{
    use HasFactory;
    use Sortable;
    public $fillable = ['payment_status'];
    public $sortable = ['order_time'];
}
