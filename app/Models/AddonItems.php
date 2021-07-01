<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AddonItems extends Model
{
    use HasFactory;
    use Sortable;
    public $fillable = ['addon_categories_id','name', 'description','image',  'sort_order', 'active'];
    public $sortable = ['addon_categories_id','name', 'sort_order','active'];
 /*
    public function addon_categories()
    {
        return $this->belongsTo('App\Models\AddonCategories');
    }
    public function addon_menu_addonitems()
    {
        return $this->belongsTo('App\Models\MenuAddonitems','addon_item_id', 'id');
    }
  */
    public function addon_category_item()
    {
        return $this->hasMany('App\Models\AddonCategoryItems', 'id', 'addon_item_id');
    }
    
}
