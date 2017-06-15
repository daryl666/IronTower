<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeOutGnr extends Model
{
    protected $table = 'fee_out_gnr';

    public function scopeIsCheck($query)
    {
        return $query->whereCheck_status(1);
    }
}
