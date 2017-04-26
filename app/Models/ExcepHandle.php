<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class ExcepHandle extends Model
{
    public function getExcepSiteInfos($regionName)
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

    public function addSiteInfoExcep($infoSites, $origInfoSiteID)
    {
        $business_code            = $infoSites[0];
        $site_code                = $infoSites[1];
        $site_name                = $infoSites[2];
        $cdma_code                = $infoSites[3];
        $lte_code                 = $infoSites[4];
        $req_code                 = $infoSites[5];
        $region_name              = $infoSites[6];
        $product_type             = $infoSites[7];
        $established_time         = $infoSites[8];
        $is_new_tower             = $infoSites[9];
        $tower_type               = $infoSites[10];
        $sys_num1                 = $infoSites[11];
        $sys1_height              = $infoSites[12];
        $sys_num2                 = $infoSites[13];
        $sys2_height              = $infoSites[14];
        $sys_num3                 = $infoSites[15];
        $sys3_height              = $infoSites[16];
        $land_form                = $infoSites[17];
        $is_co_opetition          = $infoSites[18];
        $share_num_house          = $infoSites[19];
        $user1_rent_house_date    = $infoSites[20];
        $user2_rent_house_date    = $infoSites[21];
        $share_num_tower          = $infoSites[22];
        $user1_rent_tower_date    = $infoSites[23];
        $user2_rent_tower_date    = $infoSites[24];
        $share_num_support        = $infoSites[25];
        $user1_rent_support_date  = $infoSites[26];
        $user2_rent_support_date  = $infoSites[27];
        $share_num_maintain       = $infoSites[28];
        $user1_rent_maintain_date = $infoSites[29];
        $user2_rent_maintain_date = $infoSites[30];
        $share_num_site           = $infoSites[31];
        $user1_rent_site_date     = $infoSites[32];
        $user2_rent_site_date     = $infoSites[33];
        $share_num_import         = $infoSites[34];
        $user1_rent_import_date   = $infoSites[35];
        $user2_rent_import_date   = $infoSites[36];
        $site_district_type       = $infoSites[37];
        $is_rru_away              = $infoSites[38];
        $user_type                = $infoSites[39];
        $elec_introduced_type     = $infoSites[40];
        $fee_wlan                 = $infoSites[41];
        $fee_micwav               = $infoSites[42];
        $fee_add                  = $infoSites[43];
        $fee_battery              = $infoSites[44];
        $fee_bbu                  = $infoSites[45];
        //推导是否存在新增共享
        $user_rent_site_date = transShareDisc($user1_rent_site_date, $user2_rent_site_date);
        if ($is_new_tower == '否') {
            if (strtotime($user_rent_site_date) >= strtotime('2015-11-01')) {
                $is_newly_added = 1;
            } elseif (strtotime($user_rent_site_date) < strtotime('2015-11-01')) {
                $is_newly_added = 0;
            }
        } else {
            $is_newly_added = 0;
        }
        $addSites = DB::table('import_site_exception')
        ->insert([
            'site_info_id'             => $origInfoSiteID,
            'business_code'            => $business_code,
            'site_code'                => $site_code,
            'site_name'                => $site_name,
            'cdma_code'                => $cdma_code,
            'lte_code'                 => $lte_code,
            'req_code'                 => $req_code,
            'region_name'              => $region_name,
            'region_id'                => transRegion($region_name),
            'product_type'             => transProductType($product_type),
            'established_time'         => $established_time,
            'is_new_tower'             => transIsNewTower($is_new_tower),
            'is_newly_added'           => $is_newly_added,
            'tower_type'               => transTowerType($tower_type),
            'sys_num1'                 => $sys_num1,
            'sys1_height'              => transSysHeight($sys1_height),
            'sys_num2'                 => $sys_num2,
            'sys2_height'              => transSysHeight($sys2_height),
            'sys_num3'                 => $sys_num3,
            'sys3_height'              => transSysHeight($sys3_height),
            'land_form'                => transLandForm($land_form),
            'is_co_opetition'          => transIsCoOpetition($is_co_opetition),
            'share_num_house'          => $share_num_house,
            'user1_rent_house_date'    => $user1_rent_house_date,
            'user2_rent_house_date'    => $user2_rent_house_date,
            'share_num_tower'          => $share_num_tower,
            'user1_rent_tower_date'    => $user1_rent_tower_date,
            'user2_rent_tower_date'    => $user2_rent_tower_date,
            'share_num_support'        => $share_num_support,
            'user1_rent_support_date'  => $user1_rent_support_date,
            'user2_rent_support_date'  => $user2_rent_support_date,
            'share_num_maintain'       => $share_num_maintain,
            'user1_rent_maintain_date' => $user1_rent_maintain_date,
            'user2_rent_maintain_date' => $user2_rent_maintain_date,
            'share_num_site'           => $share_num_site,
            'user1_rent_site_date'     => $user1_rent_site_date,
            'user2_rent_site_date'     => $user2_rent_site_date,
            'share_num_import'         => $share_num_import,
            'user1_rent_import_date'   => $user1_rent_import_date,
            'user2_rent_import_date'   => $user2_rent_import_date,
            'site_district_type'       => transSiteDistType($site_district_type),
            'is_rru_away'              => transIsRRUAway($is_rru_away),
            'user_type'                => transUserType($user_type),
            'elec_introduced_type'     => transElecType($elec_introduced_type),
            'check_status'             => 0,
        ]);
    }

    public function updateSiteInfo($excepSiteInfo)
    {
        $updateResult = DB::table('site_info')
        ->where('id', $excepSiteInfo[0]->site_info_id)
        ->update([
            'is_valid' => 0,
        ]);
        $updateResult &= DB::table('site_info')
        ->insert([
            'business_code'            => $excepSiteInfo[0]->business_code,
            'site_code'            => $excepSiteInfo[0]->site_code,
            'site_name'            => $excepSiteInfo[0]->site_name,
            'cdma_code'                => $excepSiteInfo[0]->cdma_code,
            'lte_code'                 => $excepSiteInfo[0]->lte_code,
            'req_code'                 => $excepSiteInfo[0]->req_code,
            'region_name'          => $excepSiteInfo[0]->region_name,
            'region_id'          => $excepSiteInfo[0]->region_id,
            'product_type'         => $excepSiteInfo[0]->product_type,
            'share_num_tower'      => $excepSiteInfo[0]->share_num_tower,
            'share_num_house'      => $excepSiteInfo[0]->share_num_house,
            'share_num_support'    => $excepSiteInfo[0]->share_num_support,
            'share_num_maintain'   => $excepSiteInfo[0]->share_num_maintain,
            'share_num_site'       => $excepSiteInfo[0]->share_num_site,
            'share_num_import'     => $excepSiteInfo[0]->share_num_import,
            'user1_rent_house_date'    => $excepSiteInfo[0]->user1_rent_house_date,
            'user2_rent_house_date'    => $excepSiteInfo[0]->user2_rent_house_date,
            'user1_rent_tower_date'    => $excepSiteInfo[0]->user1_rent_tower_date,
            'user2_rent_tower_date'    => $excepSiteInfo[0]->user2_rent_tower_date,
            'user1_rent_support_date'  => $excepSiteInfo[0]->user1_rent_support_date,
            'user2_rent_support_date'  => $excepSiteInfo[0]->user2_rent_support_date,
            'user1_rent_maintain_date' => $excepSiteInfo[0]->user1_rent_maintain_date,
            'user2_rent_maintain_date' => $excepSiteInfo[0]->user2_rent_maintain_date,
            'user1_rent_site_date'     => $excepSiteInfo[0]->user1_rent_site_date,
            'user2_rent_site_date'     => $excepSiteInfo[0]->user2_rent_site_date,
            'user1_rent_import_date'   => $excepSiteInfo[0]->user1_rent_import_date,
            'user2_rent_import_date'   => $excepSiteInfo[0]->user2_rent_import_date,
            'established_time'     => $excepSiteInfo[0]->established_time,
            'effective_date'       => date('Y-m-d', time()),
            'is_new_tower'         => $excepSiteInfo[0]->is_new_tower,
            'is_newly_added'       => $excepSiteInfo[0]->is_newly_added,
            'is_rru_away'          => $excepSiteInfo[0]->is_rru_away,
            'sys_num1'              => $excepSiteInfo[0]->sys_num1,
            'sys_num2'              => $excepSiteInfo[0]->sys_num2,
            'sys_num3'              => $excepSiteInfo[0]->sys_num3,
            'sys1_height'          => $excepSiteInfo[0]->sys1_height,
            'sys2_height'          => $excepSiteInfo[0]->sys2_height,
            'sys3_height'          => $excepSiteInfo[0]->sys3_height,
            'is_co_opetition'      => $excepSiteInfo[0]->is_co_opetition,
            'is_valid'             => 1,
            'site_district_type'   => $excepSiteInfo[0]->site_district_type,
            'tower_type'           => $excepSiteInfo[0]->tower_type,
            'land_form'            => $excepSiteInfo[0]->land_form,
            'user_type'            => $excepSiteInfo[0]->user_type,
            'elec_introduced_type' => $excepSiteInfo[0]->elec_introduced_type,
        ]);
$updateResult &= DB::table('import_site_exception')
->where('id', $excepSiteInfo[0]->id)
->update([
    'check_status' => '1',
]);
return $updateResult;

}

public function denySiteInfo($id)
{
    $denyResult = DB::table('import_site_exception')
    ->where('id', $id)
    ->update([
        'check_status' => '2',
    ]);
    return $denyResult;
}
}
