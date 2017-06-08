<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeImportStd extends Model
{
    protected $table = 'fee_import_std';

    public function scopeGetStd($query, $region_name, $elec_introduced_type)
    {
        return $query->whereRegion_id(transRegion($region_name))
            ->whereElec_introduced_type(transElecType($elec_introduced_type));
    }
}
