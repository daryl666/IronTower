<?php

namespace App\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class TodoList extends Model
{
    function getTodoList($regionName)
    {
        if ($regionName == '湖北省'){
            $importSiteExcepsUnhandled = DB::table('import_site_exception')
                ->where('check_status', 1)
                ->get();
            $gnrRecsUnhandled = DB::table('fee_out_gnr')
                ->where('check_status', 0)
                ->get();
            $siteChecksUnhandled = DB::table('site_check')
                ->where('check_status', 0)
                ->get();
            $osReasonsUnhandled = DB::table('tysys_os_info')
                ->where('check_status', 0)
                ->get();
            $servBillsUnhandled = DB::table('fee_out')
                ->where('is_out', 0)
                ->get();
            $siteShieldUnhandled = DB::table('shield_info')
                ->where('shield_req_proc_state', 1)
                ->get();
            $siteUnshieldUnhandled = DB::table('shield_info')
                ->where('unshield_req_proc_state', 1)
                ->get();
        }else{
            $importSiteExcepsUnhandled = DB::table('import_site_exception')
                ->where('region_name', $regionName)
                ->where('check_status', 0)
                ->get();
            $gnrRecsUnhandled = DB::table('fee_out_gnr')
                ->where('region_name', $regionName)
                ->where('check_status', 0)
                ->get();
            $siteChecksUnhandled = DB::table('site_check')
                ->where('region_name', $regionName)
                ->where('check_status', 0)
                ->get();
            $osReasonsUnhandled = DB::table('tysys_os_info')
                ->where('region_name', 'like', '%' . $regionName . '%')
                ->where('check_status', 0)
                ->get();
            $servBillsUnhandled = DB::table('fee_out')
                ->where('region_name', $regionName)
                ->where('is_out', 0)
                ->get();
            $siteShieldUnhandled = DB::table('shield_info')
                ->where('region_name', $regionName)
                ->where('shield_req_proc_state', 1)
                ->get();
            $siteUnshieldUnhandled = DB::table('shield_info')
                ->where('region_name', $regionName)
                ->where('unshield_req_proc_state', 1)
                ->get();
        }

        return array($importSiteExcepsUnhandled, $gnrRecsUnhandled,
            $siteChecksUnhandled, $osReasonsUnhandled, $servBillsUnhandled,
            $siteShieldUnhandled, $siteUnshieldUnhandled);


    }
}
