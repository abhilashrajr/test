<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddonCategoryItems extends Model
{
    use HasFactory;
    protected $table = 'addon_category_items';
    public $fillable = ['addon_category_id', 'addon_item_id'];
}
