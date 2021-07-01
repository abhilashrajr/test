<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VoucherOrders extends Model
{
    use HasFactory;
    use Sortable;
    
    public $fillable = ['payment_status','status'];
    public $sortable = ['customer_name','order_time','voucher_amount','payment_status'];
}
