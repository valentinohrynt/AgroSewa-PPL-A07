<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    static function getAllDataProductCategory()
    {
        $AllDataProductCategory = static::all();
        return $AllDataProductCategory;
    }
    public function equipmentRequest()
    {
        return $this->hasMany(EquipmentRequest::class, 'product_category_id');
    }
    use HasFactory;
}
