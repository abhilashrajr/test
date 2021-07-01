<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Menu extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'menu';
    public $fillable = ['name', 'price','active'];
    public $sortable = ['name','menu_type.name' ,'category.name','price','sort_order','active'];

    public function menu_type()
    {
        return $this->hasOne('App\Models\MenuTypes', 'id', 'menu_type_id');
    }
    /*public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }*/
    public function size()
    {
        return $this->hasOne('App\Models\Sizes', 'id', 'size_id');
    }
    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
