<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AddonCategories extends Model
{
    use HasFactory;
    use Sortable;
    public $fillable = ['name', 'description','image',  'sort_order', 'active'];
    public $sortable = ['name', 'sort_order','active'];

    public function addonitems()
    {
        return $this->hasMany('App\Models\Addonitems');
    }
}
