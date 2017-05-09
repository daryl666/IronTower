<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OsreasonFill extends Model
{
    /**
     * @param $region
     * @param string $beginDate
     * @param string $endDate
     * @param $checkStatus
     */
    function getOsReasons($region, $beginDate = '', $endDate = '', $checkStatus)
    {
        if ($checkStatus == 0) {
            if ($region == '湖北省') {
                $query = DB::table('tysys_os_info')
                    ->where('check_status', 0)
                    ->orderBy('created_at', 'DESC');
                if ($beginDate != '') {
                    $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
                }
                if ($endDate != '') {
                    $query->where('created_at', '<=', $endDate . ' -31 23:59:59');
                }
            } else {
                $query = DB::table('tysys_os_info')
                    ->where('check_status', 0)
                    ->where('bsc', 'like', '%'.$region.'%')
                    ->orderBy('created_at', 'DESC');
                if ($beginDate != '') {
                    $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
                }
                if ($endDate != '') {
                    $query->where('created_at', '<=', $endDate . '-31 23:59:59');
                }
            }
        } elseif ($checkStatus == 1) {
            if ($region == '湖北省') {
                $query = DB::table('tysys_os_info')
                    ->where('check_status', 1)
                    ->orderBy('created_at', 'DESC');
                if ($beginDate != '') {
                    $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
                }
                if ($endDate != '') {
                    $query->where('created_at', '<=', $endDate . '-31 23:59:59');
                }
            } else {
                $query = DB::table('tysys_os_info')
                    ->where('check_status', 1)
                    ->where('bsc', 'like', '%'.$region.'%')
                    ->orderBy('created_at', 'DESC');
                if ($beginDate != '') {
                    $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
                }
                if ($endDate != '') {
                    $query->where('created_at', '<=', $endDate . '-31 23:59:59');
                }
            }
        }
        return $query;

    }
}
