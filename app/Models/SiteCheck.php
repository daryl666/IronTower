<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteCheck extends Model
{
    function addSiteCheck($siteCode, $checkReqTime, $checkType, $regionName, $shieldID = null)
    {
        $checkDate = explode('-', $checkReqTime);
        $checkMonth = $checkDate[0].'-'.$checkDate[1];
        $addResult = DB::table('site_check')
            ->insert([
                'site_code' => $siteCode,
                'region_name' => $regionName,
                'region_id' => transRegion($regionName),
                'check_type' => $checkType,
                'check_status' => 0,
                'check_req_time' => $checkReqTime,
                'month' => $checkMonth,
                'shield_id' => $shieldID
            ]);
        return $addResult;
    }

    function getSiteChecks($region, $procState, $startDate = '', $endDate = '')
    {
        if ($region == '湖北省') {
            if ($procState == 0) {
                $query = DB::table('site_check')
                    ->where('check_status', 0)
                    ->orderBy('created_at', 'DESC');
            } else {
                $query = DB::table('site_check')
                    ->where('check_status', 1)
                    ->orderBy('created_at', 'DESC');
            }
        } else {
            if ($procState == 0) {
                $query = DB::table('site_check')
                    ->where('region_id', transRegion($region))
                    ->where('check_status', 0)
                    ->orderBy('created_at', 'DESC');
            } else {
                $query = DB::table('site_check')
                    ->where('region_id', transRegion($region))
                    ->where('check_status', 1)
                    ->orderBy('created_at', 'DESC');
            }
        }
        if ($startDate != '') {
            $query->where('check_req_time', '>=', $startDate . '00:00:00');
        }
        if ($endDate != '') {
            $query->where('check_req_time', '<=', $endDate . '23:59:59');
        }
        return $query;

    }

    function siteCheckTimeValidate($checkReqTime, $stationCode)
    {
        $shieldFinished = DB::table('shield_info')
            ->where('shield_reason', '!=', transShieldReason('故障'))
            ->where('shield_state', 3)
            ->where('station_code', $stationCode)
            ->where('shield_start_time', '<=', $checkReqTime)
            ->where('shield_end_time', '>=', $checkReqTime)
            ->get();
        $shieldUnfinished = DB::table('shield_info')
            ->where('shield_reason', '!=', transShieldReason('故障'))
            ->where('station_code', $stationCode)
            ->where('shield_state', '!=', 3)
            ->where('shield_start_time', '<=', $checkReqTime)
            ->get();
        if (empty($shieldFinished) && empty($shieldUnfinished)) {
            return true;
        } else {
            return false;
        }
    }
}
