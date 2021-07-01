<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAddonitems extends Model
{
    use HasFactory;

    public function addon_categories()
    {
        return $this->hasMany('App\Models\AddonCategories', 'id', 'addon_category_id');
    }
    public function addon_items()
    {
        return $this->hasMany('App\Models\AddonItems', 'id', 'addon_item_id');
    }
}
