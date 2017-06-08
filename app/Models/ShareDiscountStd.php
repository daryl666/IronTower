<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShareDiscountStd extends Model
{
    protected $table = 'share_discount_std';

    public function scopeGetDiscount($query, $isNewTower, $shareNum, $userType, $isNewlyAdded)
    {
        return $query->whereIs_new_tower($isNewTower)
            ->whereShare_num(transShareType($shareNum))
            ->whereUser_type(transUserType($userType))
            ->whereIs_newly_added($isNewlyAdded);
    }

}
