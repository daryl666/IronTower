<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BillOut extends Model
{
    protected $table = 'bill_out';
    protected $guarded = ['id'];


    public function store($bill)
    {
        $billOut = $this->firstOrNew(['month' => $bill->month, 'region_id' => $bill->region_id]);
        $billOut->fee_out_id = $bill->id;
        $billOut->month = $bill->month;
        $billOut->region_id = $bill->region_id;
        $billOut->region_name = $bill->region_name;
        $billOut->order_num = $bill->order_num;
        $billOut->fee_import = $bill->fee_import;
        $billOut->fee_tower = $bill->fee_tower;
        $billOut->fee_house = $bill->fee_house;
        $billOut->fee_support = $bill->fee_support;
        $billOut->fee_maintain = $bill->fee_maintain;
        $billOut->fee_site = $bill->fee_site;
        $billOut->fee_electricity = $bill->fee_electricity;
        $billOut->fee_gnr_allincharge = $bill->fee_gnr_allincharge;
        $billOut->fee_wlan = $bill->fee_wlan;
        $billOut->fee_microwave = $bill->fee_microwave;
        $billOut->fee_add = $bill->fee_add;
        $billOut->fee_battery = $bill->fee_battery;
        $billOut->fee_bbu = $bill->fee_bbu;
        $billOut->gnr_num = $bill->gnr_num;
        $billOut->fee_gnr = $bill->fee_gnr;
        $billOut->deduction_1 = $bill->deduction_1;
        $billOut->deduction_2 = $bill->deduction_2;
        $billOut->fee_total_allincharge = $bill->fee_total_allincharge;
        $billOut->fee_total_succ = $bill->fee_total_succ;
        $billOut->fee_service = $bill->fee_service;
        $billOut->operator = Auth::user()->name;
        $billOut->save();
        return $billOut->id;
    }
}
