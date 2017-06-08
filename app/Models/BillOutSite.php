<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BillOutSite extends Model
{
    protected $table = 'bill_out_site';
    protected $guarded = ['id'];

    public function store($billDetail, $id)
    {
        $billDetailOut = $this->firstOrNew(['month' => $billDetail->start_day, 'region_id' => $billDetail->region_id]);
        $billDetailOut->out_id = $id;
        $billDetailOut->region_id = $billDetail->region_id;
        $billDetailOut->region_name = $billDetail->region_name;
        $billDetailOut->business_code = $billDetail->business_code;
        $billDetailOut->req_code = $billDetail->req_code;
        $billDetailOut->site_code = $billDetail->site_code;
        $billDetailOut->month = $billDetail->month;
        $billDetailOut->fee_tower = $billDetail->fee_tower;
        $billDetailOut->fee_house = $billDetail->fee_house;
        $billDetailOut->fee_support = $billDetail->fee_support;
        $billDetailOut->fee_maintain = $billDetail->fee_maintain;
        $billDetailOut->fee_site = $billDetail->fee_site;
        $billDetailOut->fee_import = $billDetail->fee_import;
        $billDetailOut->fee_gnr_allincharge = $billDetail->fee_gnr_allincharge;
        $billDetailOut->fee_wlan = $billDetail->fee_wlan;
        $billDetailOut->fee_microwave = $billDetail->fee_microwave;
        $billDetailOut->fee_add = $billDetail->fee_add;
        $billDetailOut->fee_battery = $billDetail->fee_battery;
        $billDetailOut->fee_bbu = $billDetail->fee_bbu;
        $billDetailOut->fee_service = $billDetail->fee_service;
        $billDetailOut->operator = Auth::user()->name;
        $billDetailOut->save();
    }
}
