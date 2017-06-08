<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeHouseStd extends Model
{
    protected $table = 'fee_house_std';

    public function scopeGetStd($query, $tower_type, $product_type, $is_new_tower)
    {
        return $query->whereTower_type(transTowerType($tower_type))
            ->whereProduct_type(transProductType($product_type))
            ->whereIs_new_tower($is_new_tower);
    }

}
