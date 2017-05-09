<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteShield extends Model
{
    function getSiteShields($region, $checkStatus, $reqType, $startDate = '', $endDate = '')
    {
        if ($region != '湖北省') {
            if ($reqType == 0) {
                $query = DB::table('shield_info')
                    ->where('region_name', $region)
                    ->where('shield_req_proc_state', $checkStatus)
                    // ->where('unshield_req_proc_state', null)
                    ->orderBy('shield_start_time', 'DESC');
                if ($startDate != '') {
                    $query->where('shield_start_time', '>=', $startDate . '00:00:00');
                }
                if ($endDate != '') {
                    $query->where('shield_start_time', '<=', $endDate . '23:59:59');
                }
            } elseif ($reqType == 1) {
                $query = DB::table('shield_info')
                    ->where('region_name', $region)
                    ->where('unshield_req_proc_state', $checkStatus)
                    ->orderBy('shield_end_time', 'DESC');
                if ($startDate != '') {
                    $query->where('shield_end_time', '>=', $startDate . '00:00:00');
                }
                if ($endDate != '') {
                    $query->where('shield_end_time', '<=', $endDate . '23:59:59');
                }
            }
        } else {
            if ($reqType == 0) {
                $query = DB::table('shield_info')
                    ->where('shield_req_proc_state', $checkStatus)
                    // ->where('unshield_req_proc_state', null)
                    ->orderBy('shield_start_time', 'DESC');
                if ($startDate != '') {
                    $query->where('shield_start_time', '>=', $startDate . '00:00:00');
                }
                if ($endDate != '') {
                    $query->where('shield_start_time', '<=', $endDate . '23:59:59');
                }
            } elseif ($reqType == 1) {
                $query = DB::table('shield_info')
                    ->where('unshield_req_proc_state', $checkStatus)
                    ->orderBy('shield_end_time', 'DESC');
                if ($startDate != '') {
                    $query->where('shield_end_time', '>=', $startDate . '00:00:00');
                }
                if ($endDate != '') {
                    $query->where('shield_end_time', '<=', $endDate . '23:59:59');
                }
            }
        }
        return $query;
    }

    function addSiteShield($regionName, $stationCode, $stationName, $stationLevel, $shieldStartTime,
                           $shieldReason, $demStartTime, $estDemEndTime, $demReason, $clientName)
    {
        $addResult = DB::table('shield_info')
            ->insertGetId([
                'region_name' => $regionName,
                'region_id' => transRegion($regionName),
                'station_code' => $stationCode,
                'station_name' => $stationName,
                'station_level' => transStationLevel($stationLevel),
                'shield_start_time' => $shieldStartTime,
                'shield_reason' => transShieldReason($shieldReason),
                'demolition_start_time' => $demStartTime,
                'est_demolition_end_time' => $estDemEndTime,
                'demolition_reason' => transDemReason($demReason),
                'shield_state' => 1,
                'shield_req_proc_state' => 1,
                'atta_name' => $clientName
            ]);
        return $addResult;
    }

    function addSiteUnshield($id, $osReason, $osDetail, $respUnit, $shieldEndTime, $newStationCode, $newStationName, $newSiteCode)
    {
        $addResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'os_reason' => transOsReason($osReason),
                'os_detail' => $osDetail,
                'response_unit' => transRespUnit($respUnit),
                'shield_end_time' => $shieldEndTime,
                'new_station_code' => $newStationCode,
                'new_station_name' => $newStationName,
                'new_site_code' => $newSiteCode,
                'unshield_req_proc_state' => 1
            ]);
        return $addResult;
    }

    
}
