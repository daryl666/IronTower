<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ServPrice extends Model
{
    public function searchServPrice($region)
    {
        $query = DB::table('fee_out_site_price')->where('region_name', $region);
        return $query->get();
    }

    public function searchServPriceBySiteCode($siteCode)
    {
        //$query = DB::table('fee_out_site_price')->where('site_code', $siteCode)->orderBy('updated_at','desc');
        $query = DB::table('fee_out_site_price')->where('site_code', $siteCode)->where('is_valid', 1);
        return $query->get();
    }

}
