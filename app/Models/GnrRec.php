<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GnrRec extends Model
{
    public function searchGnr($regionName, $checkStatus = '', $beginDate = '', $endDate = '')
    {
        if ($regionName == '湖北省') {
            $query = DB::table('fee_out_gnr')
                ->where('check_status', $checkStatus)
                ->orderBy('gnr_stop_time', 'DESC');
        } else {
            $query = DB::table('fee_out_gnr')
                ->where('region_id', transRegion($regionName))
                ->where('check_status', $checkStatus)
                ->orderBy('gnr_stop_time', 'DESC');
        }
        if ($beginDate != '') {
            $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
        }
        if ($endDate != '') {
            $query->where('created_at', '<=', $endDate . '-31 23:59:59');
        }
        return $query;
    }

    public function updateDB(Request $request)
    {
        $siteCode = $request->get('siteCode');
        $startTime = $request->get('startTime');
        $startTimeArray = explode('-', $startTime);
        $month = $startTimeArray[0] . '-' . $startTimeArray[1];
        $is_out = DB::table('fee_out')
            ->where('start_day', $month)
            ->pluck('is_out');
        if (!$is_out[0]) {
            $stopTime = $request->get('stopTime');
            $gnr_len_minute = floor((strtotime($stopTime) - strtotime($startTime)) / 60);
            $gnr_hour = floor($gnr_len_minute / 60);
            $gnr_minute = $gnr_len_minute % 60;
            $gnr_len = $gnr_hour . ':' . $gnr_minute;
            $gnr_compute_len = $gnr_hour > 5 ? $gnr_hour : 5;
            $land_form = DB::table('site_info')->where('site_code', $siteCode)->pluck('land_form');
            if ($land_form[0] == '山区') {
                $gnr_fee = 270 + 20 * ($gnr_compute_len - 5);
            } elseif ($land_form[0] == '平原') {
                $gnr_fee = 220 + 20 * ($gnr_compute_len - 5);
            }
            $isSuccess = DB::table('fee_out_gnr')->where('id', $request->get('id'))
                ->update([
                    'gnr_start_time' => $request->get('startTime'),
                    'gnr_stop_time' => $request->get('stopTime'),
                    'gnr_len' => $gnr_len,
                    'gnr_len_minute' => $gnr_len_minute,
                    'gnr_compute_len' => $gnr_compute_len,
                    'gnr_fee' => $gnr_fee,
                    'gnr_fee_taxed' => $gnr_fee * 1.06,
                    'updated_at' => date('Y-m-d h:i:s', time())
                ]);
            return $isSuccess;
        } else {
            return 'is_out';
        }

    }

    function addGnrRecByArray(Array $gnrRecs)
    {
        for ($i = 1; $i < count($gnrRecs); $i++) {
            $region = $gnrRecs[$i][0];
            $siteCode = $gnrRecs[$i][1];
            $startTime = $gnrRecs[$i][2];
            $stopTime = $gnrRecs[$i][3];
            $gnr_len_minute = floor((strtotime($stopTime) - strtotime($startTime)) / 60);
            $gnr_hour = floor($gnr_len_minute / 60);
            $gnr_minute = $gnr_len_minute % 60;
            $gnr_len = $gnr_hour . ':' . $gnr_minute;
            $gnr_compute_len = $gnr_hour > 5 ? $gnr_hour : 5;
            $land_form = DB::table('site_info')->where('site_code', $siteCode)->pluck('land_form');
            if ($land_form[0] == '山区') {
                $gnr_fee = 270 + 20 * ($gnr_compute_len - 5);
            } elseif ($land_form[0] == '平原') {
                $gnr_fee = 220 + 20 * ($gnr_compute_len - 5);
            }
            $isSuccess = DB::table('fee_out_gnr')
                ->insert(['site_code' => $gnrRecs[$i][1],
                    'region_name' => $gnrRecs[$i][0],
                    'gnr_start_time' => $startTime,
                    'gnr_stop_time' => $stopTime,
                    'gnr_len' => $gnr_len,
                    'gnr_len_minute' => $gnr_len_minute,
                    'gnr_compute_len' => $gnr_compute_len,
                    'gnr_fee' => $gnr_fee,
                    'gnr_fee_taxed' => $gnr_fee * 1.06,
                    'created_at' => date('Y-m-d h:i:s', time())]);
        }
    }
}
