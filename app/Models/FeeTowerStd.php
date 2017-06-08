<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeTowerStd extends Model
{
    protected $table = 'fee_tower_std';

    public function scopeGetStd($query, $tower_type, $sys_height, $is_new_tower)
    {
        return $query->whereTower_type(transTowerType($tower_type))
            ->whereSys_height(transSysHeight($sys_height))
            ->whereIs_new_tower($is_new_tower);
    }

}

