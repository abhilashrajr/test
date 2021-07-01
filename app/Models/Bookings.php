<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Bookings extends Model
{
    use HasFactory;
    use Sortable;


    public $fillable = ['status'];
    public $sortable = ['date','time','guests','status'];
}
