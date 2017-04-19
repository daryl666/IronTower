<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OtherCost extends Model
{
    function searchOtherCost($region){
        if($region == '湖北省'){
            $query = DB::table('fee_other')
                ->where('is_valid','是')
                ->get();
        }else{
            $query = DB::table('fee_other')
                ->where('region_name',$region)
                ->where('is_valid','是')
                ->get();
        }
        return $query;
    }

    function addOtherCost(Request $request){
        $isExist = DB::table('fee_other')
            ->where('site_code',$request->get('siteCode'))
            ->where('is_valid','是')
            ->get();
        if (empty($isExist)){
            $addOtherCost = DB::table('fee_other')
                ->insert([
                    'site_code' => $request->get('siteCode'),
                    'region_name' => $request->get('regionName'),
                    'fee_wlan' => $request->get('feeWlan'),
                    'fee_microwave' => $request->get('feeMicwav'),
                    'fee_add' => $request->get('feeAdd'),
                    'fee_battery' => $request->get('feeBat'),
                    'fee_bbu' => $request->get('feeBbu'),
                    'is_valid' => 1
                ]);
                return array(false, $addOtherCost);
        }else{
            return array(false, false);
        }
    }

    function updateOtherCost($id, Request $request){
        $isExist = DB::table('fee_other')
            ->where('id', $id)
            ->get();
        if(!empty($isExist)){
            $updOtherCost = DB::table('fee_other')
                ->where('id',$id)
                ->update([
                    'is_valid' => 0
                ]);
            $addOtherCost = DB::table('fee_other')
                ->insert([
                    'site_code' => $request->get('siteCode'),
                    'region_name' => $request->get('region'),
                    'fee_wlan' => $request->get('feeWlan'),
                    'fee_microwave' => $request->get('feeMicwav'),
                    'fee_add' => $request->get('feeAdd'),
                    'fee_battery' => $request->get('feeBat'),
                    'fee_bbu' => $request->get('feeBbu'),
                    'is_valid' => 1
                ]);
            return array($updOtherCost, $addOtherCost);
        }else{
            return array(false, false);
        }
    }

    function deleteDB($id){
        $isExist = DB::table('fee_other')
            ->where('id',$id)
            ->where('is_valid','是')
            ->get();
        if(!empty($isExist)){
            $delOtherCost = DB::table('fee_other')
                ->where('id',$id)
                ->where('is_valid','是')
                ->update([
                    'is_valid' => 0
                ]);
            return $delOtherCost;
        }else{
            return false;
        }
    }
}
