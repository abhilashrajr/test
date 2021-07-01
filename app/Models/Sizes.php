<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Sizes extends Model
{
    use HasFactory;
    use Sortable;
    
    public $fillable = ['name','sort_order', 'active'];
    public $sortable = ['name','sort_order','active'];
    /*
    public function menu()
    {
        return $this->belongsTo(User::class);
    }*/
}
