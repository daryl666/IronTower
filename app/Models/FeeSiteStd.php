<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeSiteStd extends Model
{
    protected $table = 'fee_site_std';

    public function scopeGetStd($query, $region_name, $site_district_type, $is_rru_away)
    {
        return $query->whereRegion_id(transRegion($region_name))
            ->whereSite_district_type(transSiteDistType($site_district_type))
            ->whereIs_rru_away(transIsRRUAway($is_rru_away));
    }
}
