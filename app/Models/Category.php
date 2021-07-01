<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use HasFactory;
    use Sortable;
   // public $fillable = ['name','sort_order'];
    public $fillable = ['name', 'description','image', 'menu_type_id', 'sort_order', 'active'];
    public $sortable = ['name','menu_type_id', 'sort_order','active'];

    public function menu_type()
    {
        return $this->hasOne('App\Models\MenuTypes', 'id', 'menu_type_id');
    }
    public function menu()
    {
        return $this->hasMany('App\Models\Menu','category_id', 'id')->Where('active', '1')->orderBy('sort_order', 'asc');
    }
}
