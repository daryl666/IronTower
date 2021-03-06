<?php

namespace App\Models;

use App\Models\ExcepHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteInfo extends Model
{
    protected $table = 'site_info';
    protected $guarded = ['id'];

    /**
     * [searchCode description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */

    public function addInfoSiteNew(Request $request)
    {
        //插入站址属性信息
        $business_code = $request->get('businessCode');
        $site_code = $request->get('siteCode');
        $site_name = $request->get('siteName');
        $cdma_code = $request->get('cdmaCode');
        $lte_code = $request->get('lteCode');
        $req_code = $request->get('reqCode');
        $region_name = $request->get('region');
        $product_type = $request->get('productType');
        $established_time = $request->get('establishedTime');
        $is_new_tower = 1;
        $is_newly_added = 0;
        $tower_type = $request->get('towerType');
        $sys_num1 = floatval($request->get('sysNum1'));
        $sys1_height = $request->get('sysHeight1');
        $sys_num2 = floatval($request->get('sysNum2'));
        $sys2_height = $request->get('sysHeight2');
        $sys_num3 = floatval($request->get('sysNum3'));
        $sys3_height = $request->get('sysHeight3');
        $land_form = $request->get('landForm');
        $is_co_opetition = $request->get('isCoOpetition');
        $share_num_house = $request->get('shareNumHouse');
        $share_num_tower = $request->get('shareNumTower');
        $share_num_support = $request->get('shareNumSupport');
        $share_num_maintain = $request->get('shareNumMaintain');
        $share_num_site = $request->get('shareNumSite');
        $share_num_import = $request->get('shareNumImport');
        $site_district_type = $request->get('siteDistType');
        $is_rru_away = $request->get('rruAway');
        $user_type = $request->get('userType');
        $elec_introduced_type = $request->get('elecIntroType');
        $fee_wlan = $request->get('feeWlan');
        $fee_micwav = $request->get('feeMicwav');
        $fee_add = $request->get('feeAdd');
        $fee_battery = $request->get('feeBat');
        $fee_bbu = $request->get('feeBbu');

        // 培训后新增的属性
        $cityName = $request->get('cityName');
        $rentSiteType = $request->get('rentSiteType');
        $siteProperty = $request->get('siteProperty');
        $villageSiteCode = $request->get('villageSiteCode');
        $mobileSiteName = $request->get('mobileSiteName');
        $unicomSiteName = $request->get('unicomSiteName');
        $siteNet = $request->get('siteNet');
        $towerOriProterty = $request->get('towerOriProterty');
        $houseOccupation = $request->get('houseOccupation');
        $powerSupplyMode = $request->get('powerSupplyMode');
        $hasGovAffairs = $request->get('hasGovAffairs');
        $dualBandAntennaNum = $request->get('dualBandAntennaNum');
        $maintainImportScene = $request->get('maintainImportScene');
        $siteFeeScene = $request->get('siteFeeScene');
        $siteFeeBeginDate = $request->get('siteFeeBeginDate');
        $siteFeeContractCode = $request->get('siteFeeContractCode');
        $BBULocation = $request->get('BBULocation');
        $RRULocation = $request->get('RRULocation');
        $siteLevel = $request->get('siteLevel');
        $isMountainSite = $request->get('isMountainSite');
        $SPDLevel1 = $request->get('SPDLevel1');
        $SPDLevel2 = $request->get('SPDLevel2');
        $SPDLevel3 = $request->get('SPDLevel3');
        $NEWireMixed = $request->get('NEWireMixed');
        $isBusinessEarth = $request->get('isBusinessEarth');
        $earthBusbarWire = $request->get('earthBusbarWire');
        $SPDEarthStatus = $request->get('SPDEarthStatus');
        $hasPowerConversion = $request->get('hasPowerConversion');
        $NEVoltage = $request->get('NEVoltage');
        $hasGeCondition = $request->get('hasGeCondition');
        $isGnrAllincharge = $request->get('isGnrAllincharge');
        $powerCabinetCapacity = $request->get('powerCabinetCapacity');
        $moduleVolume = $request->get('moduleVolume');
        $batteryVolume = $request->get('batteryVolume');
        $batteryNum = $request->get('batteryNum');
        $batteryCapacity = $request->get('batteryCapacity');
        $AloadSite = $request->get('AloadSite');
        $DloadTele = $request->get('DloadTele');
        $DloadMobile = $request->get('DloadMobile');
        $DloadUnicom = $request->get('DloadUnicom');
        $DloadTowerGov = $request->get('DloadTowerGov');
        $envirEquip = $request->get('envirEquip');
        $envireEquipStatus = $request->get('envireEquipStatus');
        $teleMainEquip = $request->get('teleMainEquip');
        $towerDEStatus = $request->get('towerDEStatus');
        $unreachable = $request->get('unreachable');
        $roofControl = $request->get('roofControl');
        $certificateCheck = $request->get('certificateCheck');
        $directCheck = $request->get('directCheck');
        $CUTowerView = $request->get('CUTowerView');
        $CUHouseView = $request->get('CUHouseView');
        $CUSupportView = $request->get('CUSupportView');


        $siteIsExist = DB::table('site_info')
            ->where('business_code', $request->get('business_code'))
            ->where('is_valid', 1)->get();
        if (empty($siteIsExist)) {
            // 插入价格记录
            $site_price = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->get();

            $tower_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_tower, $user_type, $is_newly_added)->value('discount_basic');
            $tower_share_discount = ($tower_share_discount == null) ? 1 : $tower_share_discount;
            $house_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_house, $user_type, $is_newly_added)->value('discount_basic');
            $house_share_discount = ($house_share_discount == null) ? 1 : $house_share_discount;
            $support_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_support, $user_type, $is_newly_added)->value('discount_basic');
            $support_share_discount = ($support_share_discount == null) ? 1 : $support_share_discount;
            $maintain_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_maintain, $user_type, $is_newly_added)->value('discount_basic');
            $maintain_share_discount = ($maintain_share_discount == null) ? 1 : $maintain_share_discount;
            $site_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_site, $user_type, $is_newly_added)->value('discount_site');
            $site_share_discount = ($site_share_discount == null) ? 1 : $site_share_discount;
            $import_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_import, $user_type, $is_newly_added)->value('discount_import');
            $import_share_discount = ($import_share_discount == null) ? 1 : $import_share_discount;


            $fee_house1 = FeeHouseStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_house');
            $fee_house1 = ($fee_house1 == null) ? 0 : $fee_house1;

            $fee_support1 = FeeSupportStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_support');
            $fee_support1 = ($fee_support1 == null) ? 0 : $fee_support1;

            $fee_maintain1 = FeeMaintainStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_maintain');
            $fee_maintain1 = ($fee_maintain1 == null) ? 0 : $fee_maintain1;

            if (!empty($sys1_height) && $sys1_height != '无') {
                $fee_tower1 = FeeTowerStd::getStd($tower_type, $sys1_height, $is_new_tower)->value('fee_tower');
                $fee_tower1 = ($fee_tower1 == null) ? 0 : $fee_tower1;
            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
            }
            if (!empty($sys2_height) && $sys2_height != '无') {
                $fee_tower2 = FeeTowerStd::getStd($tower_type, $sys2_height, $is_new_tower)->value('fee_tower');
                $fee_tower2 = ($fee_tower2 == null) ? 0 : $fee_tower2;
                $fee_house2 = $fee_house1;
                $fee_maintain2 = $fee_maintain1;
                $fee_support2 = $fee_support1;
            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if (!empty($sys3_height) && $sys3_height != '无') {
                $fee_tower3 = FeeTowerStd::getStd($tower_type, $sys3_height, $is_new_tower)->value('fee_tower');
                $fee_tower3 = ($fee_tower3 == null) ? 0 : $fee_tower3;
                $fee_house3 = $fee_house1;
                $fee_maintain3 = $fee_maintain1;
                $fee_support3 = $fee_support1;
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }
            if ($sys_num1 >= 1) {
                $fee_site = FeeSiteStd::getStd($region_name, $site_district_type, $is_rru_away)->value('fee_site');
                $fee_site = ($fee_site == null) ? 0 : $fee_site;
                $fee_import = FeeImportStd::getStd($region_name, $elec_introduced_type)->value('fee_import');
                $fee_import = ($fee_import == null) ? 0 : $fee_import;
            } else {
                $fee_site = 0;
                $fee_import = 0;
            }
            $fee_tower = $fee_tower1 * $sys_num1 + $fee_tower2 * $sys_num2 + $fee_tower3 * $sys_num3;
            $fee_house = $fee_house1 * $sys_num1 + $fee_house2 + $sys_num2 + $fee_house3 * $sys_num3;
            $fee_support = $fee_support1 * $sys_num1 + $fee_support2 * $sys_num2 + $fee_support3 * $sys_num3;
            $fee_maintain = $fee_maintain1 * $sys_num1 + $fee_maintain2 * $sys_num2 + $fee_maintain3 * $sys_num3;
            $fee_tower_discounted = $fee_tower * $tower_share_discount;
            $fee_house_discounted = $fee_house * $house_share_discount;
            $fee_support_discounted = $fee_support * $support_share_discount;
            $fee_maintain_discounted = $fee_maintain * $maintain_share_discount;
            $fee_site_discounted = $fee_site * $site_share_discount;
            $fee_import_discounted = $fee_import * $import_share_discount;

            if (empty($site_price)) {
                $insSitePrice = FeeOutSitePrice::create([
                    'site_code' => $site_code,
                    'req_code' => $req_code,
                    'business_code' => $business_code,
                    'fee_tower1' => $fee_tower1,
                    'fee_house1' => $fee_house1,
                    'fee_support1' => $fee_support1,
                    'fee_maintain1' => $fee_maintain1,
                    'fee_tower2' => $fee_tower2,
                    'fee_house2' => $fee_house2,
                    'fee_support2' => $fee_support2,
                    'fee_maintain2' => $fee_maintain2,
                    'fee_tower3' => $fee_tower3,
                    'fee_house3' => $fee_house3,
                    'fee_support3' => $fee_support3,
                    'fee_maintain3' => $fee_maintain3,
                    'fee_tower' => $fee_tower,
                    'fee_house' => $fee_house,
                    'fee_support' => $fee_support,
                    'fee_maintain' => $fee_maintain,
                    'fee_wlan' => $fee_wlan,
                    'fee_microwave' => $fee_micwav,
                    'fee_add' => $fee_add,
                    'fee_battery' => $fee_battery,
                    'fee_bbu' => $fee_bbu,
                    'tower_share_discount' => $tower_share_discount,
                    'house_share_discount' => $house_share_discount,
                    'support_share_discount' => $support_share_discount,
                    'maintain_share_discount' => $maintain_share_discount,
                    'fee_tower_discounted' => $fee_tower_discounted,
                    'fee_house_discounted' => $fee_house_discounted,
                    'fee_support_discounted' => $fee_support_discounted,
                    'fee_maintain_discounted' => $fee_maintain_discounted,
                    'fee_site' => $fee_site,
                    'site_share_discount' => $site_share_discount,
                    'fee_site_discounted' => $fee_site_discounted,
                    'fee_import' => $fee_import,
                    'import_share_discount' => $import_share_discount,
                    'fee_import_discounted' => $fee_import_discounted,
                    'is_valid' => 1,
                    'is_right' => 1,
                    'effective_date' => $established_time,
                    'region_id' => transRegion($region_name),
                ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('business_code', $business_code)
                    ->where('is_valid', 1)
                    ->update([
                        'is_valid' => 0,
                    ]);
                $insSitePrice = FeeOutSitePrice::create([
                    'site_code' => $site_code,
                    'req_code' => $req_code,
                    'business_code' => $business_code,
                    'fee_tower1' => $fee_tower1,
                    'fee_house1' => $fee_house1,
                    'fee_support1' => $fee_support1,
                    'fee_maintain1' => $fee_maintain1,
                    'fee_tower2' => $fee_tower2,
                    'fee_house2' => $fee_house2,
                    'fee_support2' => $fee_support2,
                    'fee_maintain2' => $fee_maintain2,
                    'fee_tower3' => $fee_tower3,
                    'fee_house3' => $fee_house3,
                    'fee_support3' => $fee_support3,
                    'fee_maintain3' => $fee_maintain3,
                    'fee_tower' => $fee_tower,
                    'fee_house' => $fee_house,
                    'fee_support' => $fee_support,
                    'fee_maintain' => $fee_maintain,
                    'fee_wlan' => $fee_wlan,
                    'fee_microwave' => $fee_micwav,
                    'fee_add' => $fee_add,
                    'fee_battery' => $fee_battery,
                    'fee_bbu' => $fee_bbu,
                    'tower_share_discount' => $tower_share_discount,
                    'house_share_discount' => $house_share_discount,
                    'support_share_discount' => $support_share_discount,
                    'maintain_share_discount' => $maintain_share_discount,
                    'fee_tower_discounted' => $fee_tower_discounted,
                    'fee_house_discounted' => $fee_house_discounted,
                    'fee_support_discounted' => $fee_support_discounted,
                    'fee_maintain_discounted' => $fee_maintain_discounted,
                    'fee_site' => $fee_site,
                    'site_share_discount' => $site_share_discount,
                    'fee_site_discounted' => $fee_site_discounted,
                    'fee_import' => $fee_import,
                    'import_share_discount' => $import_share_discount,
                    'fee_import_discounted' => $fee_import_discounted,
                    'is_valid' => 1,
                    'is_right' => 1,
                    'effective_date' => $established_time,
                    'region_id' => transRegion($region_name),
                ]);
            }
            $insSiteInfo = DB::table('site_info')->insert([
                'business_code' => $business_code,
                'req_code' => $req_code,
                'site_code' => $site_code,
                'site_name' => $site_name,
                'region_name' => $region_name,
                'region_id' => transRegion($region_name),
                'product_type' => transProductType($product_type),
                'share_num_tower' => transShareType($share_num_tower),
                'share_num_house' => transShareType($share_num_house),
                'share_num_support' => transShareType($share_num_support),
                'share_num_maintain' => transShareType($share_num_maintain),
                'share_num_site' => transShareType($share_num_site),
                'share_num_import' => transShareType($share_num_import),
                'established_time' => $established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => $is_new_tower,
                'is_newly_added' => $is_newly_added,
                'is_rru_away' => transIsRRUAway($is_rru_away),
                'sys_num1' => $sys_num1,
                'sys_num2' => $sys_num2,
                'sys_num3' => $sys_num3,
                'sys1_height' => transSysHeight($sys1_height),
                'sys2_height' => transSysHeight($sys2_height),
                'sys3_height' => transSysHeight($sys3_height),
                'is_co_opetition' => transIsCoOpetition($is_co_opetition),
                'is_valid' => 1,
                'is_right' => 1,
                'site_district_type' => transSiteDistType($site_district_type),
                'tower_type' => transTowerType($tower_type),
                'land_form' => transLandForm($land_form),
                'user_type' => transUserType($user_type),
                'elec_introduced_type' => transElecType($elec_introduced_type),
                'fee_out_site_price_table_id' => $insSitePrice->id,
                'city_name' => $cityName,
                'rent_site_type' => $rentSiteType,
                'site_property' => $siteProperty,
                'village_site_code' => $villageSiteCode,
                'mobile_site_name' => $mobileSiteName,
                'unicom_site_name' => $unicomSiteName,
                'site_net' => transSiteNet($siteNet),
                'tower_ori_property' => transTowerOriProperty($towerOriProterty),
                'house_occupation' => $houseOccupation,
                'power_supply_mode' => transPowerSupplyMode($powerSupplyMode),
                'has_gov_affairs' => $hasGovAffairs,
                'dual_band_antenna_num' => $dualBandAntennaNum,
                'maintain_import_scene' => $maintainImportScene,
                'site_fee_scene' => $siteFeeScene,
                'site_fee_begin_date' => $siteFeeBeginDate,
                'site_fee_contract_code' => $siteFeeContractCode,
                'BBU_location' => transBBULocation($BBULocation),
                'RRU_location' => transRRULocation($RRULocation),
                'site_level' => transSiteLevel($siteLevel),
                'is_mountain_site' => transIsMountainSite($isMountainSite),
                'SPD_level1' => transSPDLevel($SPDLevel1),
                'SPD_level2' => transSPDLevel($SPDLevel2),
                'SPD_level3' => transSPDLevel($SPDLevel3),
                'NE_wire_mixed' => $NEWireMixed,
                'is_business_earth' => transIsBusinessEarth($isBusinessEarth),
                'earth_busbar_wire' => transEarthBusbarWire($earthBusbarWire),
                'SPD_earth_status' => transSPDEarthStatus($SPDEarthStatus),
                'has_power_conversion' => $hasPowerConversion,
                'NE_voltage' => $NEVoltage,
                'has_ge_condition' => $hasGeCondition,
                'is_gnr_allincharge' => $isGnrAllincharge,
                'power_cabinet_capacity' => transPowerCabinetCapacity($powerCabinetCapacity),
                'module_volume' => $moduleVolume,
                'battery_volume' => transBatteryVolume($batteryVolume),
                'battery_num' => transBatteryNum($batteryNum),
                'battery_capacity' => transBatteryCapacity($batteryCapacity),
                'Aload_site' => $AloadSite,
                'Dload_tele' => $DloadTele,
                'Dload_mobile' => $DloadMobile,
                'Dload_unicom' => $DloadUnicom,
                'Dload_tower_gov' => $DloadTowerGov,
                'envir_equip' => transEnvirEquip($envirEquip),
                'envir_equip_status' => transEnvirEquipStatus($envireEquipStatus),
                'tele_main_equip' => $teleMainEquip,
                'tower_DE_status' => transTowerDEStatus($towerDEStatus),
                'unreachable' => $unreachable,
                'roof_control' => $roofControl,
                'certificate_check' => $certificateCheck,
                'direct_check' => $directCheck,
                'CU_tower_view' => $CUTowerView,
                'CU_house_view' => $CUHouseView,
                'CU_support_view' => $CUSupportView,
            ]);

            return array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteOld(Request $request)
    {
        //插入站址属性信息
        $business_code = $request->get('businessCode');


        $siteIsExist = DB::table('site_info')
            ->where('business_code', $request->get('business_code'))
            ->where('is_valid', 1)->get();
        if (empty($siteIsExist)) {
            // 插入价格记录
            $site_price = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->get();

            $business_code = $request->get('businessCode');
            $site_code = $request->get('siteCode');
            $site_name = $request->get('siteName');
            $cdma_code = $request->get('cdmaCode');
            $lte_code = $request->get('lteCode');
            $req_code = $request->get('reqCode');
            $region_name = $request->get('region');
            $product_type = $request->get('productType');
            $established_time = $request->get('establishedTime');
            $is_new_tower = 1;
            $is_newly_added = $request->get('isNewlyAdded');
            $tower_type = $request->get('towerType');
            $sys_num1 = $request->get('sysNum1');
            $sys1_height = $request->get('sysHeight1');
            $sys_num2 = $request->get('sysNum2');
            $sys2_height = $request->get('sysHeight2');
            $sys_num3 = $request->get('sysNum3');
            $sys3_height = $request->get('sysHeight3');
            $land_form = $request->get('landForm');
            $is_co_opetition = $request->get('isCoOpetition');
            $share_num_house = $request->get('shareNumHouse');
            $share_num_tower = $request->get('shareNumTower');
            $share_num_support = $request->get('shareNumSupport');
            $share_num_maintain = $request->get('shareNumMaintain');
            $share_num_site = $request->get('shareNumSite');
            $share_num_import = $request->get('shareNumImport');
            $site_district_type = $request->get('siteDistType');
            $is_rru_away = $request->get('rruAway');
            $user_type = $request->get('userType');
            $elec_introduced_type = $request->get('elecIntroType');
            $fee_wlan = $request->get('feeWlan');
            $fee_micwav = $request->get('feeMicwav');
            $fee_add = $request->get('feeAdd');
            $fee_battery = $request->get('feeBat');
            $fee_bbu = $request->get('feeBbu');

            // 培训后新增的属性
            $cityName = $request->get('cityName');
            $rentSiteType = $request->get('rentSiteType');
            $siteProperty = $request->get('siteProperty');
            $villageSiteCode = $request->get('villageSiteCode');
            $mobileSiteName = $request->get('mobileSiteName');
            $unicomSiteName = $request->get('unicomSiteName');
            $siteNet = $request->get('siteNet');
            $towerOriProterty = $request->get('towerOriProterty');
            $houseOccupation = $request->get('houseOccupation');
            $powerSupplyMode = $request->get('powerSupplyMode');
            $hasGovAffairs = $request->get('hasGovAffairs');
            $dualBandAntennaNum = $request->get('dualBandAntennaNum');
            $maintainImportScene = $request->get('maintainImportScene');
            $siteFeeScene = $request->get('siteFeeScene');
            $siteFeeBeginDate = $request->get('siteFeeBeginDate');
            $siteFeeContractCode = $request->get('siteFeeContractCode');
            $BBULocation = $request->get('BBULocation');
            $RRULocation = $request->get('RRULocation');
            $siteLevel = $request->get('siteLevel');
            $isMountainSite = $request->get('isMountainSite');
            $SPDLevel1 = $request->get('SPDLevel1');
            $SPDLevel2 = $request->get('SPDLevel2');
            $SPDLevel3 = $request->get('SPDLevel3');
            $NEWireMixed = $request->get('NEWireMixed');
            $isBusinessEarth = $request->get('isBusinessEarth');
            $earthBusbarWire = $request->get('earthBusbarWire');
            $SPDEarthStatus = $request->get('SPDEarthStatus');
            $hasPowerConversion = $request->get('hasPowerConversion');
            $NEVoltage = $request->get('NEVoltage');
            $hasGeCondition = $request->get('hasGeCondition');
            $isGnrAllincharge = $request->get('isGnrAllincharge');
            $powerCabinetCapacity = $request->get('powerCabinetCapacity');
            $moduleVolume = $request->get('moduleVolume');
            $batteryVolume = $request->get('batteryVolume');
            $batteryNum = $request->get('batteryNum');
            $batteryCapacity = $request->get('batteryCapacity');
            $AloadSite = $request->get('AloadSite');
            $DloadTele = $request->get('DloadTele');
            $DloadMobile = $request->get('DloadMobile');
            $DloadUnicom = $request->get('DloadUnicom');
            $DloadTowerGov = $request->get('DloadTowerGov');
            $envirEquip = $request->get('envirEquip');
            $envireEquipStatus = $request->get('envireEquipStatus');
            $teleMainEquip = $request->get('teleMainEquip');
            $towerDEStatus = $request->get('towerDEStatus');
            $unreachable = $request->get('unreachable');
            $roofControl = $request->get('roofControl');
            $certificateCheck = $request->get('certificateCheck');
            $directCheck = $request->get('directCheck');
            $CUTowerView = $request->get('CUTowerView');
            $CUHouseView = $request->get('CUHouseView');
            $CUSupportView = $request->get('CUSupportView');

            $tower_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_tower, $user_type, $is_newly_added)->value('discount_basic');
            $tower_share_discount = ($tower_share_discount == null) ? 1 : $tower_share_discount;
            $house_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_house, $user_type, $is_newly_added)->value('discount_basic');
            $house_share_discount = ($house_share_discount == null) ? 1 : $house_share_discount;
            $support_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_support, $user_type, $is_newly_added)->value('discount_basic');
            $support_share_discount = ($support_share_discount == null) ? 1 : $support_share_discount;
            $maintain_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_maintain, $user_type, $is_newly_added)->value('discount_basic');
            $maintain_share_discount = ($maintain_share_discount == null) ? 1 : $maintain_share_discount;
            $fee_house1 = FeeHouseStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_house');
            $fee_house1 = ($fee_house1 == null) ? 0 : $fee_house1;
            $fee_support1 = FeeSupportStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_support');
            $fee_support1 = ($fee_support1 == null) ? 0 : $fee_support1;
            $fee_maintain1 = FeeMaintainStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_maintain');
            $fee_maintain1 = ($fee_maintain1 == null) ? 0 : $fee_maintain1;
            if (!empty($sys1_height) && $sys1_height != 0) {
                $fee_tower1 = FeeTowerStd::getStd($tower_type, $sys1_height, $is_new_tower)->value('fee_tower');
                $fee_tower1 = ($fee_tower1 == null) ? 0 : $fee_tower1;

            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
            }
            if (!empty($sys2_height) && $sys2_height != 0) {
                $fee_tower2 = FeeTowerStd::getStd($tower_type, $sys2_height, $is_new_tower)->value('fee_tower');
                $fee_tower2 = ($fee_tower2 == null) ? 0 : $fee_tower2;
                $fee_house2 = $fee_house1;
                $fee_maintain2 = $fee_maintain1;
                $fee_support2 = $fee_support1;
            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if (!empty($sys3_height) && $sys3_height != 0) {
                $fee_tower3 = FeeTowerStd::getStd($tower_type, $sys3_height, $is_new_tower)->value('fee_tower');
                $fee_tower3 = ($fee_tower3 == null) ? 0 : $fee_tower3;
                $fee_house3 = $fee_house1;
                $fee_maintain3 = $fee_maintain1;
                $fee_support3 = $fee_support1;
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }

            $site_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_site, $user_type, $is_newly_added)->value('discount_site');
            $site_share_discount = ($site_share_discount == null) ? 1 : $site_share_discount;
            $import_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_import, $user_type, $is_newly_added)->value('discount_import');
            $import_share_discount = ($import_share_discount == null) ? 1 : $import_share_discount;
            if ($sys_num1 >= 1) {
                $fee_site = $request->get('feeSiteOld');
                $fee_import = FeeImportStd::getStd($region_name, $elec_introduced_type)->value('fee_import');
                $fee_import = ($fee_import == null) ? 0 : $fee_import;
            } else {
                $fee_site = 0;
                $fee_import = 0;
            }

            $fee_tower = $fee_tower1 * $sys_num1 + $fee_tower2 * $sys_num2 + $fee_tower3 * $sys_num3;
            $fee_house = $fee_house1 * $sys_num1 + $fee_house2 + $sys_num2 + $fee_house3 * $sys_num3;
            $fee_support = $fee_support1 * $sys_num1 + $fee_support2 * $sys_num2 + $fee_support3 * $sys_num3;
            $fee_maintain = $fee_maintain1 * $sys_num1 + $fee_maintain2 * $sys_num2 + $fee_maintain3 * $sys_num3;
            $fee_tower_discounted = $fee_tower * $tower_share_discount;
            $fee_house_discounted = $fee_house * $house_share_discount;
            $fee_support_discounted = $fee_support * $support_share_discount;
            $fee_maintain_discounted = $fee_maintain * $maintain_share_discount;
            $fee_site_discounted = $fee_site * $site_share_discount;
            $fee_import_discounted = $fee_import * $import_share_discount;

            if (empty($site_price)) {
                $insSitePrice = FeeOutSitePrice::create([
                    'site_code' => $site_code,
                    'req_code' => $req_code,
                    'business_code' => $business_code,
                    'fee_tower1' => $fee_tower1,
                    'fee_house1' => $fee_house1,
                    'fee_support1' => $fee_support1,
                    'fee_maintain1' => $fee_maintain1,
                    'fee_tower2' => $fee_tower2,
                    'fee_house2' => $fee_house2,
                    'fee_support2' => $fee_support2,
                    'fee_maintain2' => $fee_maintain2,
                    'fee_tower3' => $fee_tower3,
                    'fee_house3' => $fee_house3,
                    'fee_support3' => $fee_support3,
                    'fee_maintain3' => $fee_maintain3,
                    'fee_tower' => $fee_tower,
                    'fee_house' => $fee_house,
                    'fee_support' => $fee_support,
                    'fee_maintain' => $fee_maintain,
                    'fee_wlan' => $fee_wlan,
                    'fee_microwave' => $fee_micwav,
                    'fee_add' => $fee_add,
                    'fee_battery' => $fee_battery,
                    'fee_bbu' => $fee_bbu,
                    'tower_share_discount' => $tower_share_discount,
                    'house_share_discount' => $house_share_discount,
                    'support_share_discount' => $support_share_discount,
                    'maintain_share_discount' => $maintain_share_discount,
                    'fee_tower_discounted' => $fee_tower_discounted,
                    'fee_house_discounted' => $fee_house_discounted,
                    'fee_support_discounted' => $fee_support_discounted,
                    'fee_maintain_discounted' => $fee_maintain_discounted,
                    'fee_site' => $fee_site,
                    'site_share_discount' => $site_share_discount,
                    'fee_site_discounted' => $fee_site_discounted,
                    'fee_import' => $fee_import,
                    'import_share_discount' => $import_share_discount,
                    'fee_import_discounted' => $fee_import_discounted,
                    'is_valid' => 1,
                    'is_right' => 1,
                    'effective_date' => $established_time,
                    'region_id' => transRegion($region_name),
                ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('business_code', $business_code)
                    ->where('is_valid', 1)
                    ->update([
                        'is_valid' => 0,
                    ]);
                $insSitePrice = FeeOutSitePrice::create([
                    'site_code' => $site_code,
                    'req_code' => $req_code,
                    'business_code' => $business_code,
                    'fee_tower1' => $fee_tower1,
                    'fee_house1' => $fee_house1,
                    'fee_support1' => $fee_support1,
                    'fee_maintain1' => $fee_maintain1,
                    'fee_tower2' => $fee_tower2,
                    'fee_house2' => $fee_house2,
                    'fee_support2' => $fee_support2,
                    'fee_maintain2' => $fee_maintain2,
                    'fee_tower3' => $fee_tower3,
                    'fee_house3' => $fee_house3,
                    'fee_support3' => $fee_support3,
                    'fee_maintain3' => $fee_maintain3,
                    'fee_tower' => $fee_tower,
                    'fee_house' => $fee_house,
                    'fee_support' => $fee_support,
                    'fee_maintain' => $fee_maintain,
                    'fee_wlan' => $fee_wlan,
                    'fee_microwave' => $fee_micwav,
                    'fee_add' => $fee_add,
                    'fee_battery' => $fee_battery,
                    'fee_bbu' => $fee_bbu,
                    'tower_share_discount' => $tower_share_discount,
                    'house_share_discount' => $house_share_discount,
                    'support_share_discount' => $support_share_discount,
                    'maintain_share_discount' => $maintain_share_discount,
                    'fee_tower_discounted' => $fee_tower_discounted,
                    'fee_house_discounted' => $fee_house_discounted,
                    'fee_support_discounted' => $fee_support_discounted,
                    'fee_maintain_discounted' => $fee_maintain_discounted,
                    'fee_site' => $fee_site,
                    'site_share_discount' => $site_share_discount,
                    'fee_site_discounted' => $fee_site_discounted,
                    'fee_import' => $fee_import,
                    'import_share_discount' => $import_share_discount,
                    'fee_import_discounted' => $fee_import_discounted,
                    'is_valid' => 1,
                    'is_right' => 1,
                    'effective_date' => $established_time,
                    'region_id' => transRegion($region_name),
                ]);
            }
            $insSiteInfo = DB::table('site_info')->insert([
                'business_code' => $business_code,
                'req_code' => $req_code,
                'site_code' => $site_code,
                'site_name' => $site_name,
                'region_name' => $region_name,
                'region_id' => transRegion($region_name),
                'product_type' => transProductType($product_type),
                'share_num_tower' => transShareType($share_num_tower),
                'share_num_house' => transShareType($share_num_house),
                'share_num_support' => transShareType($share_num_support),
                'share_num_maintain' => transShareType($share_num_maintain),
                'share_num_site' => transShareType($share_num_site),
                'share_num_import' => transShareType($share_num_import),
                'established_time' => $established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => transIsNewTower($is_new_tower),
                'is_newly_added' => transIsNewlyAdded($is_newly_added),
                'is_rru_away' => transIsRRUAway($is_rru_away),
                'sys_num1' => $sys_num1,
                'sys_num2' => $sys_num2,
                'sys_num3' => $sys_num3,
                'sys1_height' => transSysHeight($sys1_height),
                'sys2_height' => transSysHeight($sys2_height),
                'sys3_height' => transSysHeight($sys3_height),
                'is_co_opetition' => transIsCoOpetition($is_co_opetition),
                'is_valid' => 1,
                'is_right' => 1,
                'site_district_type' => transSiteDistType($site_district_type),
                'tower_type' => transTowerType($tower_type),
                'land_form' => transLandForm($land_form),
                'user_type' => transUserType($user_type),
                'elec_introduced_type' => transElecType($elec_introduced_type),
                'fee_out_site_price_table_id' => $insSitePrice->id,
                'city_name' => $cityName,
                'rent_site_type' => $rentSiteType,
                'site_property' => $siteProperty,
                'village_site_code' => $villageSiteCode,
                'mobile_site_name' => $mobileSiteName,
                'unicom_site_name' => $unicomSiteName,
                'site_net' => transSiteNet($siteNet),
                'tower_ori_property' => transTowerOriProperty($towerOriProterty),
                'house_occupation' => $houseOccupation,
                'power_supply_mode' => transPowerSupplyMode($powerSupplyMode),
                'has_gov_affairs' => $hasGovAffairs,
                'dual_band_antenna_num' => $dualBandAntennaNum,
                'maintain_import_scene' => $maintainImportScene,
                'site_fee_scene' => $siteFeeScene,
                'site_fee_begin_date' => $siteFeeBeginDate,
                'site_fee_contract_code' => $siteFeeContractCode,
                'BBU_location' => transBBULocation($BBULocation),
                'RRU_location' => transRRULocation($RRULocation),
                'site_level' => transSiteLevel($siteLevel),
                'is_mountain_site' => transIsMountainSite($isMountainSite),
                'SPD_level1' => transSPDLevel($SPDLevel1),
                'SPD_level2' => transSPDLevel($SPDLevel2),
                'SPD_level3' => transSPDLevel($SPDLevel3),
                'NE_wire_mixed' => $NEWireMixed,
                'is_business_earth' => transIsBusinessEarth($isBusinessEarth),
                'earth_busbar_wire' => transEarthBusbarWire($earthBusbarWire),
                'SPD_earth_status' => transSPDEarthStatus($SPDEarthStatus),
                'has_power_conversion' => $hasPowerConversion,
                'NE_voltage' => $NEVoltage,
                'has_ge_condition' => $hasGeCondition,
                'is_gnr_allincharge' => $isGnrAllincharge,
                'power_cabinet_capacity' => transPowerCabinetCapacity($powerCabinetCapacity),
                'module_volume' => $moduleVolume,
                'battery_volume' => transBatteryVolume($batteryVolume),
                'battery_num' => transBatteryNum($batteryNum),
                'battery_capacity' => transBatteryCapacity($batteryCapacity),
                'Aload_site' => $AloadSite,
                'Dload_tele' => $DloadTele,
                'Dload_mobile' => $DloadMobile,
                'Dload_unicom' => $DloadUnicom,
                'Dload_tower_gov' => $DloadTowerGov,
                'envir_equip' => transEnvirEquip($envirEquip),
                'envir_equip_status' => transEnvirEquipStatus($envireEquipStatus),
                'tele_main_equip' => $teleMainEquip,
                'tower_DE_status' => transTowerDEStatus($towerDEStatus),
                'unreachable' => $unreachable,
                'roof_control' => $roofControl,
                'certificate_check' => $certificateCheck,
                'direct_check' => $directCheck,
                'CU_tower_view' => $CUTowerView,
                'CU_house_view' => $CUHouseView,
                'CU_support_view' => $CUSupportView,

            ]);
            return array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteByArray(array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            unset($infoSites[0]);
            foreach ($infoSites as $infoSite) {
                if (array_filter($infoSite)) {
                    $infoSite = array_values($infoSite);
                    $business_code = $infoSite[0];
                    $site_code = $infoSite[1];
                    $site_name = $infoSite[2];
                    $cdma_code = $infoSite[3];
                    $cdma_name = $infoSite[4];
                    $lte_code = $infoSite[5];
                    $lte_name = $infoSite[6];
                    $m800_code = $infoSite[7];
                    $m800_name = $infoSite[8];
                    $req_code = $infoSite[9];
                    $region_name = $infoSite[10];
                    $product_type = $infoSite[11];
                    $gnr_type = $infoSite[12];
                    $established_time = $infoSite[13];
                    $is_new_tower = $infoSite[14];
                    $tower_type = $infoSite[15];
                    $sys_num1 = $infoSite[16];
                    $sys1_height = $infoSite[17];
                    $sys_num2 = $infoSite[18];
                    $sys2_height = $infoSite[19];
                    $sys_num3 = $infoSite[20];
                    $sys3_height = $infoSite[21];
                    $land_form = $infoSite[22];
                    $is_co_opetition = $infoSite[23];
                    $share_num_house = $infoSite[24];
                    $user1_rent_house_date = $infoSite[25];
                    $user2_rent_house_date = $infoSite[26];
                    $share_num_tower = $infoSite[27];
                    $user1_rent_tower_date = $infoSite[28];
                    $user2_rent_tower_date = $infoSite[29];
                    $share_num_support = $infoSite[30];
                    $user1_rent_support_date = $infoSite[31];
                    $user2_rent_support_date = $infoSite[32];
                    $share_num_maintain = $infoSite[33];
                    $user1_rent_maintain_date = $infoSite[34];
                    $user2_rent_maintain_date = $infoSite[35];
                    $share_num_site = $infoSite[36];
                    $user1_rent_site_date = $infoSite[37];
                    $user2_rent_site_date = $infoSite[38];
                    $share_num_import = $infoSite[39];
                    $user1_rent_import_date = $infoSite[40];
                    $user2_rent_import_date = $infoSite[41];
                    $site_district_type = $infoSite[42];
                    $is_rru_away = $infoSite[43];
                    $user_type = $infoSite[44];
                    $elec_introduced_type = $infoSite[45];
                    $fee_wlan = $infoSite[46];
                    $fee_micwav = $infoSite[47];
                    $fee_add = $infoSite[48];
                    $fee_battery = $infoSite[49];
                    $fee_bbu = $infoSite[50];

                    // 培训之后新增的属性
                    $cityName = $infoSite[52];
                    $rentSiteType = $infoSite[53];
                    $siteProperty = $infoSite[54];
                    $villageSiteCode = $infoSite[61];
                    $mobileSiteName = $infoSite[59];
                    $unicomSiteName = $infoSite[60];
                    $siteNet = $infoSite[64];
                    $towerOriProterty = $infoSite[65];
                    $houseOccupation = $infoSite[66];
                    $powerSupplyMode = $infoSite[67];
                    $hasGovAffairs = $infoSite[68];
                    $dualBandAntennaNum = $infoSite[69];
                    $maintainImportScene = $infoSite[70];
                    $siteFeeScene = $infoSite[71];
                    $siteFeeBeginDate = $infoSite[72];
                    $siteFeeContractCode = $infoSite[73];
                    $BBULocation = $infoSite[74];
                    $RRULocation = $infoSite[75];
                    $siteLevel = $infoSite[78];
                    $isMountainSite = $infoSite[79];
                    $SPDLevel1 = $infoSite[80];
                    $SPDLevel2 = $infoSite[81];
                    $SPDLevel3 = $infoSite[82];
                    $NEWireMixed = $infoSite[83];
                    $isBusinessEarth = $infoSite[84];
                    $earthBusbarWire = $infoSite[85];
                    $SPDEarthStatus = $infoSite[86];
                    $hasPowerConversion = $infoSite[87];
                    $NEVoltage = $infoSite[88];
                    $hasGeCondition = $infoSite[89];
                    $isGnrAllincharge = $infoSite[90];
                    $powerCabinetCapacity = $infoSite[91];
                    $moduleVolume = $infoSite[92];
                    $batteryVolume = $infoSite[93];
                    $batteryNum = $infoSite[94];
                    $batteryCapacity = $infoSite[95];
                    $AloadSite = $infoSite[96];
                    $DloadTele = $infoSite[97];
                    $DloadMobile = $infoSite[98];
                    $DloadUnicom = $infoSite[99];
                    $DloadTowerGov = $infoSite[100];
                    $envirEquip = $infoSite[101];
                    $envireEquipStatus = $infoSite[102];
                    $teleMainEquip = $infoSite[103];
                    $towerDEStatus = $infoSite[104];
                    $unreachable = $infoSite[108];
                    $roofControl = $infoSite[107];
                    $certificateCheck = $infoSite[106];
                    $directCheck = $infoSite[105];
                    $CUTowerView = $infoSite[109];
                    $CUHouseView = $infoSite[110];
                    $CUSupportView = $infoSite[111];

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

                    $origInfoSiteID = DB::table('site_info')
                        ->where('business_code', $business_code)
                        ->where('is_valid', 1)
                        ->pluck('id');

                    if (empty($origInfoSiteID)) {
                        //插入站址价格
                        $site_price = DB::table('fee_out_site_price')
                            ->where('business_code', $business_code)
                            ->where('is_valid', 1)
                            ->get();

                        //查表得出各种价格
                        $tower_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_tower, $user_type, $is_newly_added)->value('discount_basic');
                        $tower_share_discount = ($tower_share_discount == null) ? 1 : $tower_share_discount;
                        $house_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_house, $user_type, $is_newly_added)->value('discount_basic');
                        $house_share_discount = ($house_share_discount == null) ? 1 : $house_share_discount;
                        $support_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_support, $user_type, $is_newly_added)->value('discount_basic');
                        $support_share_discount = ($support_share_discount == null) ? 1 : $support_share_discount;
                        $maintain_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_maintain, $user_type, $is_newly_added)->value('discount_basic');
                        $maintain_share_discount = ($maintain_share_discount == null) ? 1 : $maintain_share_discount;


                        $fee_house1 = FeeHouseStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_house');
                        $fee_house1 = ($fee_house1 == null) ? 0 : $fee_house1;
                        $fee_support1 = FeeSupportStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_support');
                        $fee_support1 = ($fee_support1 == null) ? 0 : $fee_support1;
                        $fee_maintain1 = FeeMaintainStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_maintain');
                        $fee_maintain1 = ($fee_maintain1 == null) ? 0 : $fee_maintain1;

                        if (!empty($sys1_height)) {
                            $fee_tower1 = FeeTowerStd::getStd($tower_type, $sys1_height, $is_new_tower)->value('fee_tower');
                            $fee_tower1 = ($fee_tower1 == null) ? 0 : $fee_tower1;
                        } else {
                            $fee_tower1 = 0;
                            $fee_house1 = 0;
                            $fee_support1 = 0;
                            $fee_maintain1 = 0;
                        }
                        if (!empty($sys2_height)) {
                            $fee_tower2 = FeeTowerStd::getStd($tower_type, $sys2_height, $is_new_tower)->value('fee_tower');
                            $fee_tower2 = ($fee_tower2 == null) ? 0 : $fee_tower2;
                            $fee_house2 = $fee_house1;
                            $fee_maintain2 = $fee_maintain1;
                            $fee_support2 = $fee_support1;
                        } else {
                            $fee_tower2 = 0;
                            $fee_house2 = 0;
                            $fee_support2 = 0;
                            $fee_maintain2 = 0;
                        }
                        if (!empty($sys3_height)) {
                            $fee_tower3 = FeeTowerStd::getStd($tower_type, $sys3_height, $is_new_tower)->value('fee_tower');
                            $fee_tower3 = ($fee_tower3 == null) ? 0 : $fee_tower3;
                            $fee_house3 = $fee_house1;
                            $fee_maintain3 = $fee_maintain1;
                            $fee_support3 = $fee_support1;
                        } else {
                            $fee_tower3 = 0;
                            $fee_house3 = 0;
                            $fee_support3 = 0;
                            $fee_maintain3 = 0;
                        }

                        $site_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_site, $user_type, $is_newly_added)->value('discount_site');
                        $site_share_discount = ($site_share_discount == null) ? 1 : $site_share_discount;

                        $import_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_import, $user_type, $is_newly_added)->value('discount_site');
                        $import_share_discount = ($import_share_discount == null) ? 1 : $import_share_discount;

                        if (transIsNewTower($is_new_tower) == 1) {
                            if ($sys_num1 >= 1) {
                                $fee_site = FeeSiteStd::getStd($region_name, $site_district_type, $is_rru_away)->value('fee_site');
                                $fee_site = ($fee_site == null) ? 0 : $fee_site;
                                $fee_import = FeeImportStd::getStd($region_name, $elec_introduced_type)->value('fee_import');
                                $fee_import = ($fee_import == null) ? 0 : $fee_import;

                            } else {
                                $fee_site = 0;
                                $fee_import = 0;
                            }

                        } else {
                            if ($sys_num1 >= 1) {
                                $fee_site = $infoSite[51];
                                $fee_import = 0;
                            } else {
                                $fee_site = 0;
                                $fee_import = 0;
                            }
                        }

                        $fee_tower = $fee_tower1 * $sys_num1 + $fee_tower2 * $sys_num2 + $fee_tower3 * $sys_num3;
                        $fee_house = $fee_house1 * $sys_num1 + $fee_house2 + $sys_num2 + $fee_house3 * $sys_num3;
                        $fee_support = $fee_support1 * $sys_num1 + $fee_support2 * $sys_num2 + $fee_support3 * $sys_num3;
                        $fee_maintain = $fee_maintain1 * $sys_num1 + $fee_maintain2 * $sys_num2 + $fee_maintain3 * $sys_num3;
                        $fee_tower_discounted = $fee_tower * $tower_share_discount;
                        $fee_house_discounted = $fee_house * $house_share_discount;
                        $fee_support_discounted = $fee_support * $support_share_discount;
                        $fee_maintain_discounted = $fee_maintain * $maintain_share_discount;
                        $fee_site_discounted = $fee_site * $site_share_discount;
                        $fee_import_discounted = $fee_import * $import_share_discount;

                        if (empty($site_price)) {
                            $insSitePrice = FeeOutSitePrice::create([
                                'site_code' => $site_code,
                                'req_code' => $req_code,
                                'business_code' => $business_code,
                                'fee_tower1' => $fee_tower1,
                                'fee_house1' => $fee_house1,
                                'fee_support1' => $fee_support1,
                                'fee_maintain1' => $fee_maintain1,
                                'fee_tower2' => $fee_tower2,
                                'fee_house2' => $fee_house2,
                                'fee_support2' => $fee_support2,
                                'fee_maintain2' => $fee_maintain2,
                                'fee_tower3' => $fee_tower3,
                                'fee_house3' => $fee_house3,
                                'fee_support3' => $fee_support3,
                                'fee_maintain3' => $fee_maintain3,
                                'fee_tower' => $fee_tower,
                                'fee_house' => $fee_house,
                                'fee_support' => $fee_support,
                                'fee_maintain' => $fee_maintain,
                                'fee_wlan' => $fee_wlan,
                                'fee_microwave' => $fee_micwav,
                                'fee_add' => $fee_add,
                                'fee_battery' => $fee_battery,
                                'fee_bbu' => $fee_bbu,
                                'tower_share_discount' => $tower_share_discount,
                                'house_share_discount' => $house_share_discount,
                                'support_share_discount' => $support_share_discount,
                                'maintain_share_discount' => $maintain_share_discount,
                                'fee_tower_discounted' => $fee_tower_discounted,
                                'fee_house_discounted' => $fee_house_discounted,
                                'fee_support_discounted' => $fee_support_discounted,
                                'fee_maintain_discounted' => $fee_maintain_discounted,
                                'fee_site' => $fee_site,
                                'site_share_discount' => $site_share_discount,
                                'fee_site_discounted' => $fee_site_discounted,
                                'fee_import' => $fee_import,
                                'import_share_discount' => $import_share_discount,
                                'fee_import_discounted' => $fee_import_discounted,
                                'is_valid' => 1,
                                'is_right' => 1,
                                'effective_date' => $established_time,
                                'region_id' => transRegion($region_name),
                            ]);
                        } else {
                            $updSitePrice = DB::table('fee_out_site_price')
                                ->where('business_code', $business_code)
                                ->where('is_valid', 1)
                                ->update([
                                    'is_valid' => 0,
                                ]);
                            $insSitePrice = FeeOutSitePrice::create([
                                'site_code' => $site_code,
                                'req_code' => $req_code,
                                'business_code' => $business_code,
                                'fee_tower1' => $fee_tower1,
                                'fee_house1' => $fee_house1,
                                'fee_support1' => $fee_support1,
                                'fee_maintain1' => $fee_maintain1,
                                'fee_tower2' => $fee_tower2,
                                'fee_house2' => $fee_house2,
                                'fee_support2' => $fee_support2,
                                'fee_maintain2' => $fee_maintain2,
                                'fee_tower3' => $fee_tower3,
                                'fee_house3' => $fee_house3,
                                'fee_support3' => $fee_support3,
                                'fee_maintain3' => $fee_maintain3,
                                'fee_tower' => $fee_tower,
                                'fee_house' => $fee_house,
                                'fee_support' => $fee_support,
                                'fee_maintain' => $fee_maintain,
                                'fee_wlan' => $fee_wlan,
                                'fee_microwave' => $fee_micwav,
                                'fee_add' => $fee_add,
                                'fee_battery' => $fee_battery,
                                'fee_bbu' => $fee_bbu,
                                'tower_share_discount' => $tower_share_discount,
                                'house_share_discount' => $house_share_discount,
                                'support_share_discount' => $support_share_discount,
                                'maintain_share_discount' => $maintain_share_discount,
                                'fee_tower_discounted' => $fee_tower_discounted,
                                'fee_house_discounted' => $fee_house_discounted,
                                'fee_support_discounted' => $fee_support_discounted,
                                'fee_maintain_discounted' => $fee_maintain_discounted,
                                'fee_site' => $fee_site,
                                'site_share_discount' => $site_share_discount,
                                'fee_site_discounted' => $fee_site_discounted,
                                'fee_import' => $fee_import,
                                'import_share_discount' => $import_share_discount,
                                'fee_import_discounted' => $fee_import_discounted,
                                'is_valid' => 1,
                                'is_right' => 1,
                                'effective_date' => $established_time,
                                'region_id' => transRegion($region_name),
                            ]);
                        }
                        // 插入站址记录
                        $addSites = DB::table('site_info')
                            ->insert([
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
                                'is_valid' => 1,
                                'is_right' => 1,
                                'fee_out_site_price_table_id' => $insSitePrice->id,
                                'city_name' => $cityName,
                                'rent_site_type' => $rentSiteType,
                                'site_property' => $siteProperty,
                                'village_site_code' => $villageSiteCode,
                                'mobile_site_name' => $mobileSiteName,
                                'unicom_site_name' => $unicomSiteName,
                                'site_net' => transSiteNet($siteNet),
                                'tower_ori_property' => transTowerOriProperty($towerOriProterty),
                                'house_occupation' => $houseOccupation,
                                'power_supply_mode' => transPowerSupplyMode($powerSupplyMode),
                                'has_gov_affairs' => $hasGovAffairs,
                                'dual_band_antenna_num' => $dualBandAntennaNum,
                                'maintain_import_scene' => $maintainImportScene,
                                'site_fee_scene' => $siteFeeScene,
                                'site_fee_begin_date' => $siteFeeBeginDate,
                                'site_fee_contract_code' => $siteFeeContractCode,
                                'BBU_location' => transBBULocation($BBULocation),
                                'RRU_location' => transRRULocation($RRULocation),
                                'site_level' => transSiteLevel($siteLevel),
                                'is_mountain_site' => transIsMountainSite($isMountainSite),
                                'SPD_level1' => transSPDLevel($SPDLevel1),
                                'SPD_level2' => transSPDLevel($SPDLevel2),
                                'SPD_level3' => transSPDLevel($SPDLevel3),
                                'NE_wire_mixed' => $NEWireMixed,
                                'is_business_earth' => transIsBusinessEarth($isBusinessEarth),
                                'earth_busbar_wire' => transEarthBusbarWire($earthBusbarWire),
                                'SPD_earth_status' => transSPDEarthStatus($SPDEarthStatus),
                                'has_power_conversion' => $hasPowerConversion,
                                'NE_voltage' => $NEVoltage,
                                'has_ge_condition' => $hasGeCondition,
                                'is_gnr_allincharge' => $isGnrAllincharge,
                                'power_cabinet_capacity' => transPowerCabinetCapacity($powerCabinetCapacity),
                                'module_volume' => $moduleVolume,
                                'battery_volume' => transBatteryVolume($batteryVolume),
                                'battery_num' => transBatteryNum($batteryNum),
                                'battery_capacity' => transBatteryCapacity($batteryCapacity),
                                'Aload_site' => $AloadSite,
                                'Dload_tele' => $DloadTele,
                                'Dload_mobile' => $DloadMobile,
                                'Dload_unicom' => $DloadUnicom,
                                'Dload_tower_gov' => $DloadTowerGov,
                                'envir_equip' => transEnvirEquip($envirEquip),
                                'envir_equip_status' => transEnvirEquipStatus($envireEquipStatus),
                                'tele_main_equip' => $teleMainEquip,
                                'tower_DE_status' => transTowerDEStatus($towerDEStatus),
                                'unreachable' => $unreachable,
                                'roof_control' => $roofControl,
                                'certificate_check' => $certificateCheck,
                                'direct_check' => $directCheck,
                                'CU_tower_view' => $CUTowerView,
                                'CU_house_view' => $CUHouseView,
                                'CU_support_view' => $CUSupportView,
                            ]);


                    } else {
                        $siteInfoExceptionDB = new ExcepHandle();
                        $siteInfoExceptionDB->addSiteInfoExcep($infoSite, $origInfoSiteID[0]);
                    }
                }

            }
        }

    }


    public function searchInfoSiteById($id)
    {
        $query = DB::table('site_info')
            ->where('site_info.id', $id)
            ->where('site_info.is_valid', 1)
            ->join('fee_out_site_price', 'site_info.req_code', '=', 'fee_out_site_price.req_code')
            ->where('fee_out_site_price.is_valid', 1)
            ->select('fee_out_site_price.fee_tower1', 'fee_out_site_price.fee_house1', 'fee_out_site_price.fee_support1',
                'fee_out_site_price.fee_maintain1', 'fee_out_site_price.fee_tower2', 'fee_out_site_price.fee_house2',
                'fee_out_site_price.fee_support2', 'fee_out_site_price.fee_maintain2', 'fee_out_site_price.fee_tower3',
                'fee_out_site_price.fee_house3', 'fee_out_site_price.fee_support3', 'fee_out_site_price.fee_maintain3',
                'fee_out_site_price.fee_tower', 'fee_out_site_price.fee_house', 'fee_out_site_price.fee_support',
                'fee_out_site_price.fee_maintain', 'fee_out_site_price.fee_wlan', 'fee_out_site_price.fee_microwave',
                'fee_out_site_price.fee_add', 'fee_out_site_price.fee_battery', 'fee_out_site_price.fee_bbu',
                'fee_out_site_price.tower_share_discount', 'fee_out_site_price.house_share_discount',
                'fee_out_site_price.support_share_discount', 'fee_out_site_price.maintain_share_discount', 'fee_out_site_price.fee_tower_discounted',
                'fee_out_site_price.fee_house_discounted', 'fee_out_site_price.fee_support_discounted', 'fee_out_site_price.fee_maintain_discounted',
                'fee_out_site_price.fee_site', 'fee_out_site_price.site_share_discount',
                'fee_out_site_price.fee_site_discounted', 'fee_out_site_price.fee_import', 'fee_out_site_price.import_share_discount',
                'fee_out_site_price.fee_import_discounted', 'site_info.*');
        return $query->get();
    }

    public function searchInfoSite($region, $siteCode = '', $businessCode = '', $id = '', $telecomSiteName = '')
    {
        if ($region != '湖北省') {
            $query = DB::table('site_info')
                ->where('site_info.region_id', 'like', '%' . transRegion($region) . '%')
                ->where('site_info.is_valid', 1)
                ->where('site_info.site_code', 'like', '%' . $siteCode . '%')
                ->where('site_info.business_code', 'like', '%' . $businessCode . '%')
//                ->where('site_info.id', $id)
                ->leftJoin('fee_out_site_price', 'site_info.req_code', '=', 'fee_out_site_price.req_code')
                ->where('fee_out_site_price.is_valid', 1)
                ->select('site_info.id as site_info_id', 'site_info.*', 'fee_out_site_price.*');
//                ->select('fee_out_site_price.fee_tower1', 'fee_out_site_price.fee_house1', 'fee_out_site_price.fee_support1',
//                    'fee_out_site_price.fee_maintain1', 'fee_out_site_price.fee_tower2', 'fee_out_site_price.fee_house2',
//                    'fee_out_site_price.fee_support2', 'fee_out_site_price.fee_maintain2', 'fee_out_site_price.fee_tower3',
//                    'fee_out_site_price.fee_house3', 'fee_out_site_price.fee_support3', 'fee_out_site_price.fee_maintain3',
//                    'fee_out_site_price.fee_tower', 'fee_out_site_price.fee_house', 'fee_out_site_price.fee_support',
//                    'fee_out_site_price.fee_maintain', 'fee_out_site_price.fee_wlan', 'fee_out_site_price.fee_microwave',
//                    'fee_out_site_price.fee_add', 'fee_out_site_price.fee_battery', 'fee_out_site_price.fee_bbu',
//                    'fee_out_site_price.tower_share_discount', 'fee_out_site_price.house_share_discount',
//                    'fee_out_site_price.support_share_discount', 'fee_out_site_price.maintain_share_discount', 'fee_out_site_price.fee_tower_discounted',
//                    'fee_out_site_price.fee_house_discounted', 'fee_out_site_price.fee_support_discounted', 'fee_out_site_price.fee_maintain_discounted',
//                    'fee_out_site_price.fee_site', 'fee_out_site_price.site_share_discount',
//                    'fee_out_site_price.fee_site_discounted', 'fee_out_site_price.fee_import', 'fee_out_site_price.import_share_discount',
//                    'fee_out_site_price.fee_import_discounted', 'site_info.*');
        } else {
            $query = DB::table('site_info')
                ->where('site_info.is_valid', 1)
                ->where('site_info.site_code', 'like', '%' . $siteCode . '%')
                ->leftJoin('fee_out_site_price', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->where('fee_out_site_price.is_valid', 1)
                ->select('site_info.id as site_info_id', 'fee_out_site_price.id as fee_out_site_price_id', 'site_info.*', 'fee_out_site_price.*');
//                ->select('fee_out_site_price.fee_tower1', 'fee_out_site_price.fee_house1', 'fee_out_site_price.fee_support1',
//                    'fee_out_site_price.fee_maintain1', 'fee_out_site_price.fee_tower2', 'fee_out_site_price.fee_house2',
//                    'fee_out_site_price.fee_support2', 'fee_out_site_price.fee_maintain2', 'fee_out_site_price.fee_tower3',
//                    'fee_out_site_price.fee_house3', 'fee_out_site_price.fee_support3', 'fee_out_site_price.fee_maintain3',
//                    'fee_out_site_price.fee_tower', 'fee_out_site_price.fee_house', 'fee_out_site_price.fee_support',
//                    'fee_out_site_price.fee_maintain', 'fee_out_site_price.fee_wlan', 'fee_out_site_price.fee_microwave',
//                    'fee_out_site_price.fee_add', 'fee_out_site_price.fee_battery', 'fee_out_site_price.fee_bbu',
//                    'fee_out_site_price.tower_share_discount', 'fee_out_site_price.house_share_discount',
//                    'fee_out_site_price.support_share_discount', 'fee_out_site_price.maintain_share_discount', 'fee_out_site_price.fee_tower_discounted',
//                    'fee_out_site_price.fee_house_discounted', 'fee_out_site_price.fee_support_discounted', 'fee_out_site_price.fee_maintain_discounted',
//                    'fee_out_site_price.fee_site', 'fee_out_site_price.site_share_discount',
//                    'fee_out_site_price.fee_site_discounted', 'fee_out_site_price.fee_import', 'fee_out_site_price.import_share_discount',
//                    'fee_out_site_price.fee_import_discounted', 'site_info.*');
        }
        if (!empty($telecomSiteName)) {
            if ($region == '湖北省') {
                $siteCodes = SiteStation::where('tele_site_name', 'like', '%' . $telecomSiteName . '%')
                    ->pluck('tower_site_code');
            } else {
                $siteCodes = SiteStation::where('tele_site_name', 'like', '%' . $telecomSiteName . '%')
                    ->where('region_id', transRegion($region))
                    ->pluck('tower_site_code');
            }
            $query->whereIn('site_info.site_code', $siteCodes);
        }
        return $query;
    }

    public function updateDB(Request $request)
    {
        $establishedTime = DB::table('site_info')
            ->where('business_code', $request->get('businessCode'))
            ->where('is_valid', 1)
            ->pluck('established_time');
        $regionId = DB::table('site_info')
            ->where('business_code', $request->get('businessCode'))
            ->where('is_valid', 1)
            ->pluck('region_id');

        // 培训后新增的属性
        $cityName = $request->get('cityName');
        $rentSiteType = $request->get('rentSiteType');
        $siteProperty = $request->get('siteProperty');
        $villageSiteCode = $request->get('villageSiteCode');
        $mobileSiteName = $request->get('mobileSiteName');
        $unicomSiteName = $request->get('unicomSiteName');
        $siteNet = $request->get('siteNet');
        $towerOriProterty = $request->get('towerOriProterty');
        $houseOccupation = $request->get('houseOccupation');
        $powerSupplyMode = $request->get('powerSupplyMode');
        $hasGovAffairs = $request->get('hasGovAffairs');
        $dualBandAntennaNum = $request->get('dualBandAntennaNum');
        $maintainImportScene = $request->get('maintainImportScene');
        $siteFeeScene = $request->get('siteFeeScene');
        $siteFeeBeginDate = $request->get('siteFeeBeginDate');
        $siteFeeContractCode = $request->get('siteFeeContractCode');
        $BBULocation = $request->get('BBULocation');
        $RRULocation = $request->get('RRULocation');
        $siteLevel = $request->get('siteLevel');
        $isMountainSite = $request->get('isMountainSite');
        $SPDLevel1 = $request->get('SPDLevel1');
        $SPDLevel2 = $request->get('SPDLevel2');
        $SPDLevel3 = $request->get('SPDLevel3');
        $NEWireMixed = $request->get('NEWireMixed');
        $isBusinessEarth = $request->get('isBusinessEarth');
        $earthBusbarWire = $request->get('earthBusbarWire');
        $SPDEarthStatus = $request->get('SPDEarthStatus');
        $hasPowerConversion = $request->get('hasPowerConversion');
        $NEVoltage = $request->get('NEVoltage');
        $hasGeCondition = $request->get('hasGeCondition');
        $isGnrAllincharge = $request->get('isGnrAllincharge');
        $powerCabinetCapacity = $request->get('powerCabinetCapacity');
        $moduleVolume = $request->get('moduleVolume');
        $batteryVolume = $request->get('batteryVolume');
        $batteryNum = $request->get('batteryNum');
        $batteryCapacity = $request->get('batteryCapacity');
        $AloadSite = $request->get('AloadSite');
        $DloadTele = $request->get('DloadTele');
        $DloadMobile = $request->get('DloadMobile');
        $DloadUnicom = $request->get('DloadUnicom');
        $DloadTowerGov = $request->get('DloadTowerGov');
        $envirEquip = $request->get('envirEquip');
        $envireEquipStatus = $request->get('envireEquipStatus');
        $teleMainEquip = $request->get('teleMainEquip');
        $towerDEStatus = $request->get('towerDEStatus');
        $unreachable = $request->get('unreachable');
        $roofControl = $request->get('roofControl');
        $certificateCheck = $request->get('certificateCheck');
        $directCheck = $request->get('directCheck');
        $CUTowerView = $request->get('CUTowerView');
        $CUHouseView = $request->get('CUHouseView');
        $CUSupportView = $request->get('CUSupportView');

        if ($request->get('isNewTower') == 1) {

            $fee_tower1 = 1;
            $fee_tower2 = 1;
            $fee_tower3 = 1;
            $sysHeight1 = $request->get('sysHeight1');
            $sysHeight2 = $request->get('sysHeight2');
            $sysHeight3 = $request->get('sysHeight3');
            if ($sysHeight1 != '无') {
                $fee_tower1 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight1))
                    ->where('is_new_tower', 1)
                    ->pluck('fee_tower');
            }
            if ($sysHeight2 != '无') {
                $fee_tower2 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight2))
                    ->where('is_new_tower', 1)
                    ->pluck('fee_tower');
            }
            if ($sysHeight3 != '无') {
                $fee_tower3 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight3))
                    ->where('is_new_tower', 1)
                    ->pluck('fee_tower');
            }
            if (empty($fee_tower1)) {
                return "error1";
            } elseif (empty($fee_tower2)) {
                return "error2";
            } elseif (empty($fee_tower3)) {
                return "error3";
            }
            $business_code = $request->get('businessCode');
            $site_code = $request->get('siteCode');
            $site_name = $request->get('siteName');
            $cdma_code = $request->get('cdmaCode');
            $lte_code = $request->get('lteCode');
            $req_code = $request->get('reqCode');
            $region_name = transRegion($regionId[0]);
            $product_type = $request->get('productType');
            $established_time = $request->get('establishedTime');
            $is_new_tower = 1;
            $is_newly_added = 0;
            $tower_type = $request->get('towerType');
            $sys_num1 = $request->get('sysNum1');
            $sys1_height = $request->get('sysHeight1');
            $sys_num2 = $request->get('sysNum2');
            $sys2_height = $request->get('sysHeight2');
            $sys_num3 = $request->get('sysNum3');
            $sys3_height = $request->get('sysHeight3');
            $land_form = $request->get('landForm');
            $is_co_opetition = $request->get('isCoOpetition');
            $share_num_house = $request->get('shareNumHouse');
            $share_num_tower = $request->get('shareNumTower');
            $share_num_support = $request->get('shareNumSupport');
            $share_num_maintain = $request->get('shareNumMaintain');
            $share_num_site = $request->get('shareNumSite');
            $share_num_import = $request->get('shareNumImport');
            $site_district_type = $request->get('siteDistType');
            $is_rru_away = $request->get('rruAway');
            $user_type = $request->get('userType');
            $elec_introduced_type = $request->get('elecIntroType');
            $fee_wlan = $request->get('feeWlan');
            $fee_micwav = $request->get('feeMicwav');
            $fee_add = $request->get('feeAdd');
            $fee_battery = $request->get('feeBat');
            $fee_bbu = $request->get('feeBbu');
            $effective_date = $request->get('effectiveDate');




            // 插入价格记录
            $site_price = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->get();

            $tower_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_tower, $user_type, $is_newly_added)->value('discount_basic');
            $tower_share_discount = ($tower_share_discount == null) ? 1 : $tower_share_discount;
            $house_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_house, $user_type, $is_newly_added)->value('discount_basic');
            $house_share_discount = ($house_share_discount == null) ? 1 : $house_share_discount;
            $support_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_support, $user_type, $is_newly_added)->value('discount_basic');
            $support_share_discount = ($support_share_discount == null) ? 1 : $support_share_discount;
            $maintain_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_maintain, $user_type, $is_newly_added)->value('discount_basic');
            $maintain_share_discount = ($maintain_share_discount == null) ? 1 : $maintain_share_discount;
            $site_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_site, $user_type, $is_newly_added)->value('discount_site');
            $site_share_discount = ($site_share_discount == null) ? 1 : $site_share_discount;
            $import_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_import, $user_type, $is_newly_added)->value('discount_import');
            $import_share_discount = ($import_share_discount == null) ? 1 : $import_share_discount;


            $fee_house1 = FeeHouseStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_house');
            $fee_house1 = ($fee_house1 == null) ? 0 : $fee_house1;

            $fee_support1 = FeeSupportStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_support');
            $fee_support1 = ($fee_support1 == null) ? 0 : $fee_support1;

            $fee_maintain1 = FeeMaintainStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_maintain');
            $fee_maintain1 = ($fee_maintain1 == null) ? 0 : $fee_maintain1;

            if (!empty($sys1_height) && $sys1_height != '无') {
                $fee_tower1 = FeeTowerStd::getStd($tower_type, $sys1_height, $is_new_tower)->value('fee_tower');
                $fee_tower1 = ($fee_tower1 == null) ? 0 : $fee_tower1;
            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
            }
            if (!empty($sys2_height) && $sys2_height != '无') {
                $fee_tower2 = FeeTowerStd::getStd($tower_type, $sys2_height, $is_new_tower)->value('fee_tower');
                $fee_tower2 = ($fee_tower2 == null) ? 0 : $fee_tower2;
                $fee_house2 = $fee_house1;
                $fee_maintain2 = $fee_maintain1;
                $fee_support2 = $fee_support1;
            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if (!empty($sys3_height) && $sys3_height != '无') {
                $fee_tower3 = FeeTowerStd::getStd($tower_type, $sys3_height, $is_new_tower)->value('fee_tower');
                $fee_tower3 = ($fee_tower3 == null) ? 0 : $fee_tower3;
                $fee_house3 = $fee_house1;
                $fee_maintain3 = $fee_maintain1;
                $fee_support3 = $fee_support1;
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }
            if ($sys_num1 >= 1) {
                $fee_site = FeeSiteStd::getStd($region_name, $site_district_type, $is_rru_away)->value('fee_site');
                $fee_site = ($fee_site == null) ? 0 : $fee_site;
                $fee_import = FeeImportStd::getStd($region_name, $elec_introduced_type)->value('fee_import');
                $fee_import = ($fee_import == null) ? 0 : $fee_import;
            } else {
                $fee_site = 0;
                $fee_import = 0;
            }

            $fee_tower = $fee_tower1 * $sys_num1 + $fee_tower2 * $sys_num2 + $fee_tower3 * $sys_num3;
            $fee_house = $fee_house1 * $sys_num1 + $fee_house2 + $sys_num2 + $fee_house3 * $sys_num3;
            $fee_support = $fee_support1 * $sys_num1 + $fee_support2 * $sys_num2 + $fee_support3 * $sys_num3;
            $fee_maintain = $fee_maintain1 * $sys_num1 + $fee_maintain2 * $sys_num2 + $fee_maintain3 * $sys_num3;
            $fee_tower_discounted = $fee_tower * $tower_share_discount;
            $fee_house_discounted = $fee_house * $house_share_discount;
            $fee_support_discounted = $fee_support * $support_share_discount;
            $fee_maintain_discounted = $fee_maintain * $maintain_share_discount;
            $fee_site_discounted = $fee_site * $site_share_discount;
            $fee_import_discounted = $fee_import * $import_share_discount;

            $updSitePrice = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->update([
                    'is_valid' => 0,
                ]);
            $insSitePrice = FeeOutSitePrice::create([
                'site_code' => $site_code,
                'req_code' => $req_code,
                'business_code' => $business_code,
                'fee_tower1' => $fee_tower1,
                'fee_house1' => $fee_house1,
                'fee_support1' => $fee_support1,
                'fee_maintain1' => $fee_maintain1,
                'fee_tower2' => $fee_tower2,
                'fee_house2' => $fee_house2,
                'fee_support2' => $fee_support2,
                'fee_maintain2' => $fee_maintain2,
                'fee_tower3' => $fee_tower3,
                'fee_house3' => $fee_house3,
                'fee_support3' => $fee_support3,
                'fee_maintain3' => $fee_maintain3,
                'fee_tower' => $fee_tower,
                'fee_house' => $fee_house,
                'fee_support' => $fee_support,
                'fee_maintain' => $fee_maintain,
                'fee_wlan' => $fee_wlan,
                'fee_microwave' => $fee_micwav,
                'fee_add' => $fee_add,
                'fee_battery' => $fee_battery,
                'fee_bbu' => $fee_bbu,
                'tower_share_discount' => $tower_share_discount,
                'house_share_discount' => $house_share_discount,
                'support_share_discount' => $support_share_discount,
                'maintain_share_discount' => $maintain_share_discount,
                'fee_tower_discounted' => $fee_tower_discounted,
                'fee_house_discounted' => $fee_house_discounted,
                'fee_support_discounted' => $fee_support_discounted,
                'fee_maintain_discounted' => $fee_maintain_discounted,
                'fee_site' => $fee_site,
                'site_share_discount' => $site_share_discount,
                'fee_site_discounted' => $fee_site_discounted,
                'fee_import' => $fee_import,
                'import_share_discount' => $import_share_discount,
                'fee_import_discounted' => $fee_import_discounted,
                'is_valid' => 1,
                'is_right' => 1,
                'effective_date' => $effective_date,
                'region_id' => transRegion($region_name),
            ]);

            $updateSiteInfo = DB::table('site_info')
                ->where('business_code', $business_code)
                ->update([
                    'is_valid' => 0,
                ]);

            $insSiteInfo = DB::table('site_info')->insert([
                'business_code' => $business_code,
                'req_code' => $req_code,
                'site_code' => $site_code,
                'site_name' => $site_name,
                'region_name' => $region_name,
                'region_id' => transRegion($region_name),
                'product_type' => transProductType($product_type),
                'share_num_tower' => transShareType($share_num_tower),
                'share_num_house' => transShareType($share_num_house),
                'share_num_support' => transShareType($share_num_support),
                'share_num_maintain' => transShareType($share_num_maintain),
                'share_num_site' => transShareType($share_num_site),
                'share_num_import' => transShareType($share_num_import),
                'established_time' => $established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => $is_new_tower,
                'is_newly_added' => $is_newly_added,
                'is_rru_away' => transIsRRUAway($is_rru_away),
                'sys_num1' => $sys_num1,
                'sys_num2' => $sys_num2,
                'sys_num3' => $sys_num3,
                'sys1_height' => transSysHeight($sys1_height),
                'sys2_height' => transSysHeight($sys2_height),
                'sys3_height' => transSysHeight($sys3_height),
                'is_co_opetition' => transIsCoOpetition($is_co_opetition),
                'is_valid' => 1,
                'is_right' => 1,
                'site_district_type' => transSiteDistType($site_district_type),
                'tower_type' => transTowerType($tower_type),
                'land_form' => transLandForm($land_form),
                'user_type' => transUserType($user_type),
                'elec_introduced_type' => transElecType($elec_introduced_type),
                'effective_date' => $effective_date,
                'fee_out_site_price_table_id' => $insSitePrice->id,
                'city_name' => $cityName,
                'rent_site_type' => $rentSiteType,
                'site_property' => $siteProperty,
                'village_site_code' => $villageSiteCode,
                'mobile_site_name' => $mobileSiteName,
                'unicom_site_name' => $unicomSiteName,
                'site_net' => transSiteNet($siteNet),
                'tower_ori_property' => transTowerOriProperty($towerOriProterty),
                'house_occupation' => $houseOccupation,
                'power_supply_mode' => transPowerSupplyMode($powerSupplyMode),
                'has_gov_affairs' => $hasGovAffairs,
                'dual_band_antenna_num' => $dualBandAntennaNum,
                'maintain_import_scene' => $maintainImportScene,
                'site_fee_scene' => $siteFeeScene,
                'site_fee_begin_date' => $siteFeeBeginDate,
                'site_fee_contract_code' => $siteFeeContractCode,
                'BBU_location' => transBBULocation($BBULocation),
                'RRU_location' => transRRULocation($RRULocation),
                'site_level' => transSiteLevel($siteLevel),
                'is_mountain_site' => transIsMountainSite($isMountainSite),
                'SPD_level1' => transSPDLevel($SPDLevel1),
                'SPD_level2' => transSPDLevel($SPDLevel2),
                'SPD_level3' => transSPDLevel($SPDLevel3),
                'NE_wire_mixed' => $NEWireMixed,
                'is_business_earth' => transIsBusinessEarth($isBusinessEarth),
                'earth_busbar_wire' => transEarthBusbarWire($earthBusbarWire),
                'SPD_earth_status' => transSPDEarthStatus($SPDEarthStatus),
                'has_power_conversion' => $hasPowerConversion,
                'NE_voltage' => $NEVoltage,
                'has_ge_condition' => $hasGeCondition,
                'is_gnr_allincharge' => $isGnrAllincharge,
                'power_cabinet_capacity' => transPowerCabinetCapacity($powerCabinetCapacity),
                'module_volume' => $moduleVolume,
                'battery_volume' => transBatteryVolume($batteryVolume),
                'battery_num' => transBatteryNum($batteryNum),
                'battery_capacity' => transBatteryCapacity($batteryCapacity),
                'Aload_site' => $AloadSite,
                'Dload_tele' => $DloadTele,
                'Dload_mobile' => $DloadMobile,
                'Dload_unicom' => $DloadUnicom,
                'Dload_tower_gov' => $DloadTowerGov,
                'envir_equip' => transEnvirEquip($envirEquip),
                'envir_equip_status' => transEnvirEquipStatus($envireEquipStatus),
                'tele_main_equip' => $teleMainEquip,
                'tower_DE_status' => transTowerDEStatus($towerDEStatus),
                'unreachable' => $unreachable,
                'roof_control' => $roofControl,
                'certificate_check' => $certificateCheck,
                'direct_check' => $directCheck,
                'CU_tower_view' => $CUTowerView,
                'CU_house_view' => $CUHouseView,
                'CU_support_view' => $CUSupportView,

            ]);


            if ($insSitePrice && $insSiteInfo) {
                return 'success';
            } else {
                return false;
            }
        } elseif ($request->get('isNewTower') == 0) {
            $fee_tower1 = 1;
            $fee_tower2 = 1;
            $fee_tower3 = 1;
            $sysHeight1 = $request->get('sysHeight1');
            $sysHeight2 = $request->get('sysHeight2');
            $sysHeight3 = $request->get('sysHeight3');
            if ($sysHeight1 != '无') {
                $fee_tower1 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight1))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
            }
            if ($sysHeight2 != '无') {
                $fee_tower2 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight2))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
            }
            if ($sysHeight3 != '无') {
                $fee_tower3 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', transSysHeight($sysHeight3))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
            }
            if (empty($fee_tower1)) {
                return "error1";
            } elseif (empty($fee_tower2)) {
                return "error2";
            } elseif (empty($fee_tower3)) {
                return "error3";
            }
            $business_code = $request->get('businessCode');
            $site_code = $request->get('siteCode');
            $site_name = $request->get('siteName');
            $cdma_code = $request->get('cdmaCode');
            $lte_code = $request->get('lteCode');
            $req_code = $request->get('reqCode');
            $region_name = transRegion($regionId[0]);
            $product_type = $request->get('productType');
            $established_time = $request->get('establishedTime');
            $is_new_tower = 0;
            $is_newly_added = $request->get('isNewlyAdded');
            $tower_type = $request->get('towerType');
            $sys_num1 = $request->get('sysNum1');
            $sys1_height = $request->get('sysHeight1');
            $sys_num2 = $request->get('sysNum2');
            $sys2_height = $request->get('sysHeight2');
            $sys_num3 = $request->get('sysNum3');
            $sys3_height = $request->get('sysHeight3');
            $land_form = $request->get('landForm');
            $is_co_opetition = $request->get('isCoOpetition');
            $share_num_house = $request->get('shareNumHouse');
            $share_num_tower = $request->get('shareNumTower');
            $share_num_support = $request->get('shareNumSupport');
            $share_num_maintain = $request->get('shareNumMaintain');
            $share_num_site = $request->get('shareNumSite');
            $share_num_import = $request->get('shareNumImport');
            $site_district_type = $request->get('siteDistType');
            $is_rru_away = $request->get('rruAway');
            $user_type = $request->get('userType');
            $elec_introduced_type = $request->get('elecIntroType');
            $fee_wlan = $request->get('feeWlan');
            $fee_micwav = $request->get('feeMicwav');
            $fee_add = $request->get('feeAdd');
            $fee_battery = $request->get('feeBat');
            $fee_bbu = $request->get('feeBbu');
            $effective_date = $request->get('effectiveDate');

            // 插入价格记录
            $site_price = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->get();
            $tower_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_tower, $user_type, $is_newly_added)->value('discount_basic');
            $tower_share_discount = ($tower_share_discount == null) ? 1 : $tower_share_discount;
            $house_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_house, $user_type, $is_newly_added)->value('discount_basic');
            $house_share_discount = ($house_share_discount == null) ? 1 : $house_share_discount;
            $support_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_support, $user_type, $is_newly_added)->value('discount_basic');
            $support_share_discount = ($support_share_discount == null) ? 1 : $support_share_discount;
            $maintain_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_maintain, $user_type, $is_newly_added)->value('discount_basic');
            $maintain_share_discount = ($maintain_share_discount == null) ? 1 : $maintain_share_discount;
            $fee_house1 = FeeHouseStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_house');
            $fee_house1 = ($fee_house1 == null) ? 0 : $fee_house1;
            $fee_support1 = FeeSupportStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_support');
            $fee_support1 = ($fee_support1 == null) ? 0 : $fee_support1;
            $fee_maintain1 = FeeMaintainStd::getStd($tower_type, $product_type, $is_new_tower)->value('fee_maintain');
            $fee_maintain1 = ($fee_maintain1 == null) ? 0 : $fee_maintain1;
            if (!empty($sys1_height) && $sys1_height != 0) {
                $fee_tower1 = FeeTowerStd::getStd($tower_type, $sys1_height, $is_new_tower)->value('fee_tower');
                $fee_tower1 = ($fee_tower1 == null) ? 0 : $fee_tower1;

            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
            }
            if (!empty($sys2_height) && $sys2_height != 0) {
                $fee_tower2 = FeeTowerStd::getStd($tower_type, $sys2_height, $is_new_tower)->value('fee_tower');
                $fee_tower2 = ($fee_tower2 == null) ? 0 : $fee_tower2;
                $fee_house2 = $fee_house1;
                $fee_maintain2 = $fee_maintain1;
                $fee_support2 = $fee_support1;
            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if (!empty($sys3_height) && $sys3_height != 0) {
                $fee_tower3 = FeeTowerStd::getStd($tower_type, $sys3_height, $is_new_tower)->value('fee_tower');
                $fee_tower3 = ($fee_tower3 == null) ? 0 : $fee_tower3;
                $fee_house3 = $fee_house1;
                $fee_maintain3 = $fee_maintain1;
                $fee_support3 = $fee_support1;
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }

            $site_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_site, $user_type, $is_newly_added)->value('discount_site');
            $site_share_discount = ($site_share_discount == null) ? 1 : $site_share_discount;
            $import_share_discount = ShareDiscountStd::getDiscount($is_new_tower, $share_num_import, $user_type, $is_newly_added)->value('discount_import');
            $import_share_discount = ($import_share_discount == null) ? 1 : $import_share_discount;
            if ($sys_num1 >= 1) {
                $fee_site = $request->get('feeSiteOld');
                $fee_import = FeeImportStd::getStd($region_name, $elec_introduced_type)->value('fee_import');
                $fee_import = ($fee_import == null) ? 0 : $fee_import;
            } else {
                $fee_site = 0;
                $fee_import = 0;
            }

            $fee_tower = $fee_tower1 * $sys_num1 + $fee_tower2 * $sys_num2 + $fee_tower3 * $sys_num3;
            $fee_house = $fee_house1 * $sys_num1 + $fee_house2 + $sys_num2 + $fee_house3 * $sys_num3;
            $fee_support = $fee_support1 * $sys_num1 + $fee_support2 * $sys_num2 + $fee_support3 * $sys_num3;
            $fee_maintain = $fee_maintain1 * $sys_num1 + $fee_maintain2 * $sys_num2 + $fee_maintain3 * $sys_num3;
            $fee_tower_discounted = $fee_tower * $tower_share_discount;
            $fee_house_discounted = $fee_house * $house_share_discount;
            $fee_support_discounted = $fee_support * $support_share_discount;
            $fee_maintain_discounted = $fee_maintain * $maintain_share_discount;
            $fee_site_discounted = $fee_site * $site_share_discount;
            $fee_import_discounted = $fee_import * $import_share_discount;

            $updSitePrice = DB::table('fee_out_site_price')
                ->where('business_code', $business_code)
                ->where('is_valid', 1)
                ->update([
                    'is_valid' => 0,
                ]);
            $insSitePrice = FeeOutSitePrice::create([
                    'site_code' => $site_code,
                    'req_code' => $req_code,
                    'business_code' => $business_code,
                    'fee_tower1' => $fee_tower1,
                    'fee_house1' => $fee_house1,
                    'fee_support1' => $fee_support1,
                    'fee_maintain1' => $fee_maintain1,
                    'fee_tower2' => $fee_tower2,
                    'fee_house2' => $fee_house2,
                    'fee_support2' => $fee_support2,
                    'fee_maintain2' => $fee_maintain2,
                    'fee_tower3' => $fee_tower3,
                    'fee_house3' => $fee_house3,
                    'fee_support3' => $fee_support3,
                    'fee_maintain3' => $fee_maintain3,
                    'fee_tower' => $fee_tower,
                    'fee_house' => $fee_house,
                    'fee_support' => $fee_support,
                    'fee_maintain' => $fee_maintain,
                    'fee_wlan' => $fee_wlan,
                    'fee_microwave' => $fee_micwav,
                    'fee_add' => $fee_add,
                    'fee_battery' => $fee_battery,
                    'fee_bbu' => $fee_bbu,
                    'tower_share_discount' => $tower_share_discount,
                    'house_share_discount' => $house_share_discount,
                    'support_share_discount' => $support_share_discount,
                    'maintain_share_discount' => $maintain_share_discount,
                    'fee_tower_discounted' => $fee_tower_discounted,
                    'fee_house_discounted' => $fee_house_discounted,
                    'fee_support_discounted' => $fee_support_discounted,
                    'fee_maintain_discounted' => $fee_maintain_discounted,
                    'fee_site' => $fee_site,
                    'site_share_discount' => $site_share_discount,
                    'fee_site_discounted' => $fee_site_discounted,
                    'fee_import' => $fee_import,
                    'import_share_discount' => $import_share_discount,
                    'fee_import_discounted' => $fee_import_discounted,
                    'is_valid' => 1,
                    'is_right' => 1,
                    'effective_date' => $effective_date,
                    'region_id' => transRegion($region_name),
                ]);

            $updateSiteInfo = DB::table('site_info')
                ->where('business_code', $business_code)
                ->update([
                    'is_valid' => 0,
                ]);

            $insSiteInfo = DB::table('site_info')->insert([
                'business_code' => $business_code,
                'req_code' => $req_code,
                'site_code' => $site_code,
                'site_name' => $site_name,
                'region_name' => $region_name,
                'region_id' => transRegion($region_name),
                'product_type' => transProductType($product_type),
                'share_num_tower' => transShareType($share_num_tower),
                'share_num_house' => transShareType($share_num_house),
                'share_num_support' => transShareType($share_num_support),
                'share_num_maintain' => transShareType($share_num_maintain),
                'share_num_site' => transShareType($share_num_site),
                'share_num_import' => transShareType($share_num_import),
                'established_time' => $established_time,
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => $is_new_tower,
                'is_newly_added' => $is_newly_added,
                'is_rru_away' => transIsRRUAway($is_rru_away),
                'sys_num1' => $sys_num1,
                'sys_num2' => $sys_num2,
                'sys_num3' => $sys_num3,
                'sys1_height' => transSysHeight($sys1_height),
                'sys2_height' => transSysHeight($sys2_height),
                'sys3_height' => transSysHeight($sys3_height),
                'is_co_opetition' => transIsCoOpetition($is_co_opetition),
                'is_valid' => 1,
                'is_right' => 1,
                'site_district_type' => transSiteDistType($site_district_type),
                'tower_type' => transTowerType($tower_type),
                'land_form' => transLandForm($land_form),
                'user_type' => transUserType($user_type),
                'elec_introduced_type' => transElecType($elec_introduced_type),
                'effective_date' => $effective_date,
                'fee_out_site_price_table_id' => $insSitePrice->id,
                'city_name' => $cityName,
                'rent_site_type' => $rentSiteType,
                'site_property' => $siteProperty,
                'village_site_code' => $villageSiteCode,
                'mobile_site_name' => $mobileSiteName,
                'unicom_site_name' => $unicomSiteName,
                'site_net' => transSiteNet($siteNet),
                'tower_ori_property' => transTowerOriProperty($towerOriProterty),
                'house_occupation' => $houseOccupation,
                'power_supply_mode' => transPowerSupplyMode($powerSupplyMode),
                'has_gov_affairs' => $hasGovAffairs,
                'dual_band_antenna_num' => $dualBandAntennaNum,
                'maintain_import_scene' => $maintainImportScene,
                'site_fee_scene' => $siteFeeScene,
                'site_fee_begin_date' => $siteFeeBeginDate,
                'site_fee_contract_code' => $siteFeeContractCode,
                'BBU_location' => transBBULocation($BBULocation),
                'RRU_location' => transRRULocation($RRULocation),
                'site_level' => transSiteLevel($siteLevel),
                'is_mountain_site' => transIsMountainSite($isMountainSite),
                'SPD_level1' => transSPDLevel($SPDLevel1),
                'SPD_level2' => transSPDLevel($SPDLevel2),
                'SPD_level3' => transSPDLevel($SPDLevel3),
                'NE_wire_mixed' => $NEWireMixed,
                'is_business_earth' => transIsBusinessEarth($isBusinessEarth),
                'earth_busbar_wire' => transEarthBusbarWire($earthBusbarWire),
                'SPD_earth_status' => transSPDEarthStatus($SPDEarthStatus),
                'has_power_conversion' => $hasPowerConversion,
                'NE_voltage' => $NEVoltage,
                'has_ge_condition' => $hasGeCondition,
                'is_gnr_allincharge' => $isGnrAllincharge,
                'power_cabinet_capacity' => transPowerCabinetCapacity($powerCabinetCapacity),
                'module_volume' => $moduleVolume,
                'battery_volume' => transBatteryVolume($batteryVolume),
                'battery_num' => transBatteryNum($batteryNum),
                'battery_capacity' => transBatteryCapacity($batteryCapacity),
                'Aload_site' => $AloadSite,
                'Dload_tele' => $DloadTele,
                'Dload_mobile' => $DloadMobile,
                'Dload_unicom' => $DloadUnicom,
                'Dload_tower_gov' => $DloadTowerGov,
                'envir_equip' => transEnvirEquip($envirEquip),
                'envir_equip_status' => transEnvirEquipStatus($envireEquipStatus),
                'tele_main_equip' => $teleMainEquip,
                'tower_DE_status' => transTowerDEStatus($towerDEStatus),
                'unreachable' => $unreachable,
                'roof_control' => $roofControl,
                'certificate_check' => $certificateCheck,
                'direct_check' => $directCheck,
                'CU_tower_view' => $CUTowerView,
                'CU_house_view' => $CUHouseView,
                'CU_support_view' => $CUSupportView,

            ]);


            if ($insSitePrice && $insSiteInfo) {
                return 'success';
            } else {
                return false;
            }
        }

    }

    public function transIronTowerSiteInfo(array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            for ($i = 1; $i < count($infoSites); $i++) {
                $businessCode = $infoSites[$i][1];
                $region = $infoSites[$i][3];
                $siteName = $infoSites[$i][6];
                $siteCode = $infoSites[$i][7];
                $reqCode = $infoSites[$i][8];
                $productType = $infoSites[$i][12];
                $establishedTime = $infoSites[$i][10];
                $isNewTower = transIsNewTower($infoSites[$i][97]);
                $towerType = $infoSites[$i][11];
                $sysNum1 = $infoSites[$i][18];
                $sysNum2 = $infoSites[$i][23];
                $sysNum3 = $infoSites[$i][28];
                $sys1Height = $infoSites[$i][19];
                $sys2Height = $infoSites[$i][24];
                $sys3Height = $infoSites[$i][29];
                $isCoOpetition = '是';
                $shareNumHouse = $infoSites[$i][42];
                $userRentDateHouse1 = $infoSites[$i][43];
                $userRentDateHouse2 = $infoSites[$i][45];
                $shareNumTower = $infoSites[$i][33];
                $userRentDateTower1 = $infoSites[$i][34];
                $userRentDateTower2 = $infoSites[$i][36];
                $shareNumSupport = $infoSites[$i][51];
                $userRentDateSupport1 = $infoSites[$i][52];
                $userRentDateSupport2 = $infoSites[$i][54];
                $shareNumMaintain = $infoSites[$i][61];
                $userRentDateMaintain1 = $infoSites[$i][62];
                $userRentDateMaintain2 = $infoSites[$i][64];
                $shareNumSite = $infoSites[$i][68];
                $userRentDateSite1 = $infoSites[$i][69];
                $userRentDateSite2 = $infoSites[$i][71];
                $shareNumElec = $infoSites[$i][75];
                $userRentDateElec1 = $infoSites[$i][76];
                $userRentDateElec2 = $infoSites[$i][78];
                $isRRUAway = $infoSites[$i][12];
                $feeWlan = $infoSites[$i][81];
                $feeMicWav = $infoSites[$i][82];
                $feeAdd = $infoSites[$i][16];
                $feeBat = $infoSites[$i][17];
                $feeBbu = $infoSites[$i][57];
                $siteDistType = '';
                $landForm = '平原';

                //反推覆盖场景
                if ($isNewTower == 1) {
                    $feeSite = $infoSites[$i][67];
                    $billYear = substr($infoSites[$i][0], 0, 4);
                    $billMonth = substr($infoSites[$i][0], 4, 2);
                    $billDate = $billYear . '-' . $billMonth;
                    if (strtotime($establishedTime) <= strtotime($billDate . '-01')) {
                        $siteDistType = DB::table('fee_site_std')
                            ->whereBetween('fee_site', [$feeSite - 2, $feeSite + 2])
                            ->where('is_rru_away', transIsRRUAway($isRRUAway))
                            ->where('region_id', transRegion($region))
                            ->pluck('site_district_type');
                    } else {
                        $days = date('t', strtotime($billDate));
                        $theLastDay = $billDate . '-' . $days;
                        $second1 = strtotime($establishedTime);
                        $second2 = strtotime("$theLastDay + 1 day");
                        $effectiveDays = abs(($second1 - $second2) / 86400);
                        $siteDistType = DB::table('fee_site_std')
                            ->whereBetween('fee_site', [$feeSite / $effectiveDays * $days - 2, $feeSite / $effectiveDays * $days + 2])
                            ->where('is_rru_away', transIsRRUAway($isRRUAway))
                            ->where('region_id', transRegion($region))
                            ->pluck('site_district_type');

                    }
                    if (empty($siteDistType)) {
                        $siteDistType = '未知';
                    } else {
                        $siteDistType = $siteDistType[0];
                    }
                } else {
                    $feeSite = $infoSites[$i][67];
                    $siteDistType = '未知';
                }

                //反推用户类型
                if ($infoSites[$i][97] == '原产权方') {
                    $userType = '原产权';
                } elseif ($infoSites[$i][97] == '既有共享') {
                    $userType = '既有共享';
                } elseif ($infoSites[$i][97] == '存量改造') {
                    $userType = '新增共享';
                } elseif ($infoSites[$i][97] == '新建') {
                    if ($infoSites[$i][70] == 0.55 || $infoSites[$i][70] == 0.45) {
                        $userType = '锚定用户';
                    } else {
                        $userType = '其他用户';
                    }
                } else {
                    $userType = '未知';
                }

                //反推引电类型
                $elecImportType = DB::table('fee_import_std')
                    ->where('region_id', transRegion($region))
                    ->whereBetween('fee_import', [$infoSites[$i][74] - 2, $infoSites[$i][74] + 2])
                    ->pluck('elec_introduced_type');
                if (empty($elecImportType)) {
                    $elecImportType = 2;
                } else {
                    $elecImportType = $elecImportType[0];
                }

                //推导是否存在新增共享
                $userRentDateSite = transShareDisc($userRentDateSite1, $userRentDateSite2);
                if (strtotime($userRentDateSite) >= strtotime('2015-11-01')) {
                    $isNewlyAdded = 1;
                } elseif (strtotime($userRentDateSite) < strtotime('2015-11-01')) {
                    $isNewlyAdded = 0;
                }
                $infoSitesNew[$i][0] = $businessCode;
                $infoSitesNew[$i][1] = $siteCode;
                $infoSitesNew[$i][2] = $siteName;
                $infoSitesNew[$i][3] = '';
                $infoSitesNew[$i][4] = '';
                $infoSitesNew[$i][5] = $reqCode;
                $infoSitesNew[$i][6] = $region;
                $infoSitesNew[$i][7] = $productType;
                $infoSitesNew[$i][8] = $establishedTime;
                $infoSitesNew[$i][9] = transIsNewTower($isNewTower);
                $infoSitesNew[$i][10] = $towerType;
                $infoSitesNew[$i][11] = $sysNum1;
                $infoSitesNew[$i][12] = $sys1Height;
                $infoSitesNew[$i][13] = $sysNum2;
                $infoSitesNew[$i][14] = $sys2Height;
                $infoSitesNew[$i][15] = $sysNum3;
                $infoSitesNew[$i][16] = $sys3Height;
                $infoSitesNew[$i][17] = $landForm;
                $infoSitesNew[$i][18] = $isCoOpetition;
                $infoSitesNew[$i][19] = $shareNumHouse;
                $infoSitesNew[$i][20] = $userRentDateHouse1;
                $infoSitesNew[$i][21] = $userRentDateHouse2;
                $infoSitesNew[$i][22] = $shareNumTower;
                $infoSitesNew[$i][23] = $userRentDateTower1;
                $infoSitesNew[$i][24] = $userRentDateTower2;
                $infoSitesNew[$i][25] = $shareNumSupport;
                $infoSitesNew[$i][26] = $userRentDateSupport1;
                $infoSitesNew[$i][27] = $userRentDateSupport2;
                $infoSitesNew[$i][28] = $shareNumMaintain;
                $infoSitesNew[$i][29] = $userRentDateMaintain1;
                $infoSitesNew[$i][30] = $userRentDateMaintain2;
                $infoSitesNew[$i][31] = $shareNumSite;
                $infoSitesNew[$i][32] = $userRentDateSite1;
                $infoSitesNew[$i][33] = $userRentDateSite2;
                $infoSitesNew[$i][34] = $shareNumElec;
                $infoSitesNew[$i][35] = $userRentDateElec1;
                $infoSitesNew[$i][36] = $userRentDateElec2;
                $infoSitesNew[$i][37] = transSiteDistType($siteDistType);
                $infoSitesNew[$i][38] = transIsRRUAway(transIsRRUAway($isRRUAway));
                $infoSitesNew[$i][39] = $userType;
                $infoSitesNew[$i][40] = transElecType($elecImportType);
                $infoSitesNew[$i][41] = $feeWlan;
                $infoSitesNew[$i][42] = $feeMicWav;
                $infoSitesNew[$i][43] = $feeAdd;
                $infoSitesNew[$i][44] = $feeBat;
                $infoSitesNew[$i][45] = $feeBbu;
                $infoSitesNew[$i][46] = $feeSite;

            }
            return $infoSitesNew;

        }
    }

    public function getOrders($businessCode, $month)
    {
        $telecomOrders = DB::table('site_info')
            ->where('business_code', $businessCode)
            ->orderBy('effective_date', 'DESC')
            ->get();
        $length = count($telecomOrders);
        foreach ($telecomOrders as $index => $telecomOrder) {
            if ((!empty($telecomOrder->effective_date) && (strtotime($telecomOrder->effective_date) > strtotime(date('Y-m-d', strtotime("$month +1 month -1 day"))))) || (strtotime($telecomOrder->established_time) > strtotime(date('Y-m-d', strtotime("$month +1 month -1 day"))))) {
                unset($telecomOrders[$index]);
            }
            if ((!empty($telecomOrder->effective_date) && (strtotime($telecomOrder->effective_date) < strtotime(date('Y-m-01', strtotime($month))))) || (empty($telecomOrder->effective_date) && (strtotime($telecomOrder->established_time) < strtotime(date('Y-m-01', strtotime($month)))))) {
                $indexToChoose = $index;
                for ($index = $indexToChoose + 1; $index < $length; $index++) {
                    unset($telecomOrders[$index]);
                }
                break;
            }
        }
        return $telecomOrders;

    }

    public function scopeValid()
    {
        return $this->whereIs_valid(1);
    }

    public function scopeRight()
    {
        return $this->whereIs_right(1);
    }

}
