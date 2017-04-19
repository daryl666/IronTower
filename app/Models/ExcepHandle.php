<?php

namespace App\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class ExcepHandle extends Model
{
    function getExcepSiteInfos($regionName)
    {
        if ($regionName == '湖北省') {
            $excepSiteInfos = DB::table('import_site_exception')
                ->where('check_status', '待处理')
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            $excepSiteInfos = DB::table('import_site_exception')
                ->where('check_status', '待处理')
                ->where('region_name', $regionName)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $origSiteInfos = array();
        foreach ($excepSiteInfos as $excepSiteInfo) {
            $siteInfo = DB::table('site_info')
                ->where('id', $excepSiteInfo->site_info_id)
                ->get();
            array_push($origSiteInfos, $siteInfo[0]);
        }
        return array($excepSiteInfos, $origSiteInfos);
    }

    function updateSiteInfo($excepSiteInfo)
    {
        $updateResult = DB::table('site_info')
            ->where('id', $excepSiteInfo[0]->site_info_id)
            ->update([
                'is_valid' => 0
            ]);
        $updateResult &= DB::table('site_info')
            ->insert([
                'site_code' => $excepSiteInfo[0]->site_code,
                'region_name' => $excepSiteInfo[0]->region_name,
                'product_type' => $excepSiteInfo[0]->product_type,
                'share_num_tower' => $excepSiteInfo[0]->share_num_tower,
                'share_num_house' => $excepSiteInfo[0]->share_num_house,
                'share_num_support' => $excepSiteInfo[0]->share_num_support,
                'share_num_maintain' => $excepSiteInfo[0]->share_num_maintain,
                'share_num_site' => $excepSiteInfo[0]->share_num_site,
                'share_num_import' => $excepSiteInfo[0]->share_num_import,
                'established_time' => $excepSiteInfo[0]->established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => $excepSiteInfo[0]->is_new_tower,
                'is_newly_added' => $excepSiteInfo[0]->is_newly_added,
                'is_rru_away' => $excepSiteInfo[0]->is_rru_away,
                'sys_num' => $excepSiteInfo[0]->sys_num,
                'sys1_height' => $excepSiteInfo[0]->sys1_height,
                'sys2_height' => $excepSiteInfo[0]->sys2_height,
                'sys3_height' => $excepSiteInfo[0]->sys3_height,
                'sys4_height' => $excepSiteInfo[0]->sys4_height,
                'sys5_height' => $excepSiteInfo[0]->sys5_height,
                'is_co_opetition' => $excepSiteInfo[0]->is_co_opetition,
                'is_valid' => 1,
                'site_district_type' => $excepSiteInfo[0]->site_district_type,
                'tower_type' => $excepSiteInfo[0]->tower_type,
                'land_form' => $excepSiteInfo[0]->land_form,
                'user_type' => $excepSiteInfo[0]->user_type,
                'elec_introduced_type' => $excepSiteInfo[0]->elec_introduced_type,
            ]);
        $updateResult &= DB::table('import_site_exception')
            ->where('id', $excepSiteInfo[0]->id)
            ->update([
                'check_status' => '保留'
            ]);
        return $updateResult;

    }

    function denySiteInfo($id)
    {
        $denyResult = DB::table('import_site_exception')
            ->where('id', $id)
            ->update([
                'check_status' => '放弃'
            ]);
        return $denyResult;
    }
}
