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
                ->where('region_id', transRegion($regionName))
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        $origSiteInfos = array();
        foreach ($excepSiteInfos as $excepSiteInfo) {
            $siteInfo = DB::table('site_info')
                ->where('id', $excepSiteInfo->site_info_id)
                ->get();
            $siteInfo[0]->import_site_exception_id = $excepSiteInfo->id;
            array_push($origSiteInfos, $siteInfo[0]);
        }
//        dd($origSiteInfos);
        return array($excepSiteInfos, $origSiteInfos);
    }

    public function addSiteInfoExcep($infoSites, $origInfoSiteID)
    {
        $business_code = $infoSites[0];
        $site_code = $infoSites[1];
        $site_name = $infoSites[2];
        $cdma_code = $infoSites[3];
        $cdma_name = $infoSites[4];
        $lte_code = $infoSites[5];
        $lte_name = $infoSites[6];
        $m800_code = $infoSites[7];
        $m800_name = $infoSites[8];
        $req_code = $infoSites[9];
        $region_name = $infoSites[10];
        $product_type = $infoSites[11];
        $gnr_type = $infoSites[12];
        $established_time = $infoSites[13];
        $is_new_tower = $infoSites[14];
        $tower_type = $infoSites[15];
        $sys_num1 = $infoSites[16];
        $sys1_height = $infoSites[17];
        $sys_num2 = $infoSites[18];
        $sys2_height = $infoSites[19];
        $sys_num3 = $infoSites[20];
        $sys3_height = $infoSites[21];
        $land_form = $infoSites[22];
        $is_co_opetition = $infoSites[23];
        $share_num_house = $infoSites[24];
        $user1_rent_house_date = $infoSites[25];
        $user2_rent_house_date = $infoSites[26];
        $share_num_tower = $infoSites[27];
        $user1_rent_tower_date = $infoSites[28];
        $user2_rent_tower_date = $infoSites[29];
        $share_num_support = $infoSites[30];
        $user1_rent_support_date = $infoSites[31];
        $user2_rent_support_date = $infoSites[32];
        $share_num_maintain = $infoSites[33];
        $user1_rent_maintain_date = $infoSites[34];
        $user2_rent_maintain_date = $infoSites[35];
        $share_num_site = $infoSites[36];
        $user1_rent_site_date = $infoSites[37];
        $user2_rent_site_date = $infoSites[38];
        $share_num_import = $infoSites[39];
        $user1_rent_import_date = $infoSites[40];
        $user2_rent_import_date = $infoSites[41];
        $site_district_type = $infoSites[42];
        $is_rru_away = $infoSites[43];
        $user_type = $infoSites[44];
        $elec_introduced_type = $infoSites[45];
        $fee_wlan = $infoSites[46];
        $fee_micwav = $infoSites[47];
        $fee_add = $infoSites[48];
        $fee_battery = $infoSites[49];
        $fee_bbu = $infoSites[50];

        // 培训之后新增的属性
        $cityName = $infoSites[52];
        $rentSiteType = $infoSites[53];
        $siteProperty = $infoSites[54];
        $villageSiteCode = $infoSites[61];
        $mobileSiteName = $infoSites[59];
        $unicomSiteName = $infoSites[60];
        $siteNet = $infoSites[64];
        $towerOriProterty = $infoSites[65];
        $houseOccupation = $infoSites[66];
        $powerSupplyMode = $infoSites[67];
        $hasGovAffairs = $infoSites[68];
        $dualBandAntennaNum = $infoSites[69];
        $maintainImportScene = $infoSites[70];
        $siteFeeScene = $infoSites[71];
        $siteFeeBeginDate = $infoSites[72];
        $siteFeeContractCode = $infoSites[73];
        $BBULocation = $infoSites[74];
        $RRULocation = $infoSites[75];
        $siteLevel = $infoSites[78];
        $isMountainSite = $infoSites[79];
        $SPDLevel1 = $infoSites[80];
        $SPDLevel2 = $infoSites[81];
        $SPDLevel3 = $infoSites[82];
        $NEWireMixed = $infoSites[83];
        $isBusinessEarth = $infoSites[84];
        $earthBusbarWire = $infoSites[85];
        $SPDEarthStatus = $infoSites[86];
        $hasPowerConversion = $infoSites[87];
        $NEVoltage = $infoSites[88];
        $hasGeCondition = $infoSites[89];
        $isGnrAllincharge = $infoSites[90];
        $powerCabinetCapacity = $infoSites[91];
        $moduleVolume = $infoSites[92];
        $batteryVolume = $infoSites[93];
        $batteryNum = $infoSites[94];
        $batteryCapacity = $infoSites[95];
        $AloadSite = $infoSites[96];
        $DloadTele = $infoSites[97];
        $DloadMobile = $infoSites[98];
        $DloadUnicom = $infoSites[99];
        $DloadTowerGov = $infoSites[100];
        $envirEquip = $infoSites[101];
        $envireEquipStatus = $infoSites[102];
        $teleMainEquip = $infoSites[103];
        $towerDEStatus = $infoSites[104];
        $unreachable = $infoSites[108];
        $roofControl = $infoSites[107];
        $certificateCheck = $infoSites[106];
        $directCheck = $infoSites[105];
        $CUTowerView = $infoSites[109];
        $CUHouseView = $infoSites[110];
        $CUSupportView = $infoSites[111];
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
                'site_info_id' => $origInfoSiteID,
                'business_code' => $business_code,
                'site_code' => $site_code,
                'site_name' => $site_name,
                'cdma_code' => $cdma_code,
                'lte_code' => $lte_code,
                'req_code' => $req_code,
                'region_name' => $region_name,
                'region_id' => transRegion($region_name),
                'product_type' => transProductType($product_type),
                'established_time' => $established_time,
                'is_new_tower' => transIsNewTower($is_new_tower),
                'is_newly_added' => $is_newly_added,
                'tower_type' => transTowerType($tower_type),
                'sys_num1' => $sys_num1,
                'sys1_height' => transSysHeight($sys1_height),
                'sys_num2' => $sys_num2,
                'sys2_height' => transSysHeight($sys2_height),
                'sys_num3' => $sys_num3,
                'sys3_height' => transSysHeight($sys3_height),
                'land_form' => transLandForm($land_form),
                'is_co_opetition' => transIsCoOpetition($is_co_opetition),
                'share_num_house' => $share_num_house,
                'user1_rent_house_date' => $user1_rent_house_date,
                'user2_rent_house_date' => $user2_rent_house_date,
                'share_num_tower' => $share_num_tower,
                'user1_rent_tower_date' => $user1_rent_tower_date,
                'user2_rent_tower_date' => $user2_rent_tower_date,
                'share_num_support' => $share_num_support,
                'user1_rent_support_date' => $user1_rent_support_date,
                'user2_rent_support_date' => $user2_rent_support_date,
                'share_num_maintain' => $share_num_maintain,
                'user1_rent_maintain_date' => $user1_rent_maintain_date,
                'user2_rent_maintain_date' => $user2_rent_maintain_date,
                'share_num_site' => $share_num_site,
                'user1_rent_site_date' => $user1_rent_site_date,
                'user2_rent_site_date' => $user2_rent_site_date,
                'share_num_import' => $share_num_import,
                'user1_rent_import_date' => $user1_rent_import_date,
                'user2_rent_import_date' => $user2_rent_import_date,
                'site_district_type' => transSiteDistType($site_district_type),
                'is_rru_away' => transIsRRUAway($is_rru_away),
                'user_type' => transUserType($user_type),
                'elec_introduced_type' => transElecType($elec_introduced_type),
                'check_status' => 0,
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
                'business_code' => $excepSiteInfo[0]->business_code,
                'site_code' => $excepSiteInfo[0]->site_code,
                'site_name' => $excepSiteInfo[0]->site_name,
                'cdma_code' => $excepSiteInfo[0]->cdma_code,
                'lte_code' => $excepSiteInfo[0]->lte_code,
                'req_code' => $excepSiteInfo[0]->req_code,
                'region_name' => $excepSiteInfo[0]->region_name,
                'region_id' => $excepSiteInfo[0]->region_id,
                'product_type' => $excepSiteInfo[0]->product_type,
                'share_num_tower' => $excepSiteInfo[0]->share_num_tower,
                'share_num_house' => $excepSiteInfo[0]->share_num_house,
                'share_num_support' => $excepSiteInfo[0]->share_num_support,
                'share_num_maintain' => $excepSiteInfo[0]->share_num_maintain,
                'share_num_site' => $excepSiteInfo[0]->share_num_site,
                'share_num_import' => $excepSiteInfo[0]->share_num_import,
                'user1_rent_house_date' => $excepSiteInfo[0]->user1_rent_house_date,
                'user2_rent_house_date' => $excepSiteInfo[0]->user2_rent_house_date,
                'user1_rent_tower_date' => $excepSiteInfo[0]->user1_rent_tower_date,
                'user2_rent_tower_date' => $excepSiteInfo[0]->user2_rent_tower_date,
                'user1_rent_support_date' => $excepSiteInfo[0]->user1_rent_support_date,
                'user2_rent_support_date' => $excepSiteInfo[0]->user2_rent_support_date,
                'user1_rent_maintain_date' => $excepSiteInfo[0]->user1_rent_maintain_date,
                'user2_rent_maintain_date' => $excepSiteInfo[0]->user2_rent_maintain_date,
                'user1_rent_site_date' => $excepSiteInfo[0]->user1_rent_site_date,
                'user2_rent_site_date' => $excepSiteInfo[0]->user2_rent_site_date,
                'user1_rent_import_date' => $excepSiteInfo[0]->user1_rent_import_date,
                'user2_rent_import_date' => $excepSiteInfo[0]->user2_rent_import_date,
                'established_time' => $excepSiteInfo[0]->established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => $excepSiteInfo[0]->is_new_tower,
                'is_newly_added' => $excepSiteInfo[0]->is_newly_added,
                'is_rru_away' => $excepSiteInfo[0]->is_rru_away,
                'sys_num1' => $excepSiteInfo[0]->sys_num1,
                'sys_num2' => $excepSiteInfo[0]->sys_num2,
                'sys_num3' => $excepSiteInfo[0]->sys_num3,
                'sys1_height' => $excepSiteInfo[0]->sys1_height,
                'sys2_height' => $excepSiteInfo[0]->sys2_height,
                'sys3_height' => $excepSiteInfo[0]->sys3_height,
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
