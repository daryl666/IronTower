<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;
use App\Models\ServPrice;

class SiteInfo extends Model
{
    public function searchCode(Request $request)
    {
        $region_id = DB::table('area_info_copy')
            ->where('region_name', '=', $request->get('region'))
            ->pluck('region_id');
        $product_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('productType'))
            ->pluck('code');
        $rru_away = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('rruAway'))
            ->pluck('code');
        $site_district_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('siteDistType'))
            ->pluck('code');
        $sys_height = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('sysHeight'))
            ->pluck('code');
        $tower_type = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('towerType'))
            ->pluck('code');
        $elec_introduced_type
            = DB::table('dict_sys_code')
            ->where('value', '=', $request->get('elecIntroType'))
            ->pluck('code');
        $code = $region_id[0] . $product_type[0] . $rru_away[0] . $site_district_type[0] . $sys_height[0] .
            $tower_type[0] . $elec_introduced_type[0];
        return $code;
    }

    public function addInfoSiteNew(Request $request)
    {
        //插入站址属性信息
        $sysNum = $request->get('sysNum');
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }

        $siteIsExist = DB::table('site_info')
            ->where('site_code', $request->get('siteCode'))
            ->where('is_valid', 1)->get();
        if (empty($siteIsExist)) {
            $insSiteInfo = DB::table('site_info')->insert([
                'site_code' => $request->get('siteCode'),
                'region_name' => $request->get('region'),
                'region_id' => transRegion($request->get('region')),
                'product_type' => transProductType($request->get('productType')),
                'share_num_tower' => transShareType($request->get('shareType_tower')),
                'share_num_house' => transShareType($request->get('shareType_house')),
                'share_num_support' => transShareType($request->get('shareType_supporting')),
                'share_num_maintain' => transShareType($request->get('shareType_maintainence')),
                'share_num_site' => transShareType($request->get('shareType_site')),
                'share_num_import' => transShareType($request->get('shareType_import')),
                'established_time' => $request->get('establishedTime'),
                'effective_date' => date('Y-m-d', time()),
                'is_new_tower' => transIsNewTower('是'),
                'is_newly_added' => transIsNewlyAdded('否'),
                'is_rru_away' => transIsRRUAway($request->get('rruAway')),
                'sys_num' => $request->get('sysNum'),
                'sys1_height' => transSysHeight($sysHeight1),
                'sys2_height' => transSysHeight($sysHeight2),
                'sys3_height' => transSysHeight($sysHeight3),
                'sys4_height' => transSysHeight($sysHeight4),
                'sys5_height' => transSysHeight($sysHeight5),
                'is_co_opetition' => transIsCoOpetition($request->get('isCoOpetition')),
                'is_valid' => 1,
                'site_district_type' => transSiteDistType($request->get('siteDistType')),
                'tower_type' => transTowerType($request->get('towerType')),
                'land_form' => transLandForm($request->get('landForm')),
                'user_type' => transUserType($request->get('userType')),
                'elec_introduced_type' => transElecType($request->get('elecIntroType')),

            ]);
            $feeWlan = $request->get('feeWlan');
            $feeMicwav = $request->get('feeMicwav');
            $feeAdd = $request->get('feeAdd');
            $feeBat = $request->get('feeBat');
            $feeBbu = $request->get('feeBbu');
            if ($sysHeight1 != null) {
                $fee_tower1 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight1)
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_tower');
                $fee_house1 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_house');
                $fee_support1 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_support');
                $fee_maintain1 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_maintain');
                $tower_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_tower')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
                $house_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_house')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
                $support_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_supporting')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 0)
                    ->pluck('discount_basic');
                $maintain_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_maintainence')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
                $tower_share_discount1 = null;
                $house_share_discount1 = null;
                $support_share_discount1 = null;
                $maintain_share_discount1 = null;
            }
            if ($sysHeight2 != null) {
                $fee_tower2 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight2)
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_tower');
                $fee_house2 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_house');
                $fee_support2 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_support');
                $fee_maintain2 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_maintain');

            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if ($sysHeight3 != null) {
                $fee_tower3 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight3)
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_tower');
                $fee_house3 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_house');
                $fee_support3 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_support');
                $fee_maintain3 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_maintain');
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }
            if ($sysHeight4 != null) {
                $fee_tower4 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight4)
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_tower');
                $fee_house4 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_house');
                $fee_support4 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_support');
                $fee_maintain4 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_maintain');
            } else {
                $fee_tower4 = 0;
                $fee_house4 = 0;
                $fee_support4 = 0;
                $fee_maintain4 = 0;
            }
            if ($sysHeight5 != null) {
                $fee_tower5 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight5)
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_tower');
                $fee_house5 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_house');
                $fee_support5 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_support');
                $fee_maintain5 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->pluck('fee_maintain');
            } else {
                $fee_tower5 = 0;
                $fee_house5 = 0;
                $fee_support5 = 0;
                $fee_maintain5 = 0;
            }
            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                $tower_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_tower')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
                $house_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_house')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
                $support_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_supporting')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 0)
                    ->pluck('discount_basic');
                $maintain_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', transIsNewTower('是'))
                    ->where('share_num', transShareType($request->get('shareType_maintainence')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded('否'))
                    ->pluck('discount_basic');
            } else {
                $tower_share_discount_other = null;
                $house_share_discount_other = null;
                $support_share_discount_other = null;
                $maintain_share_discount_other = null;
            }

            $fee_site = DB::table('fee_site_std')
                ->where('region_id', transRegion($request->get('region')))
                ->where('site_district_type', transSiteDistType($request->get('siteDistType')))
                ->where('is_rru_away', transIsRRUAway($request->get('rruAway')))
                ->pluck('fee_site');
            $fee_import = DB::table('fee_import_std')
                ->where('region_id', transRegion($request->get('region')))
                ->where('elec_introduced_type', transElecType($request->get('elecIntroType')))
                ->pluck('fee_import');

            $site_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower('是'))
                ->where('share_num', transShareType($request->get('shareType_site')))
                ->where('user_type', transUserType($request->get('userType')))
                ->where('is_newly_added', transIsNewlyAdded('否'))
                ->pluck('discount_site');
            $import_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower('是'))
                ->where('share_num', transShareType($request->get('shareType_import')))
                ->where('user_type', transUserType($request->get('userType')))
                ->where('is_newly_added', transIsNewlyAdded('否'))
                ->pluck('discount_import');
            $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
            $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
            $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
            $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
            $fee_site_discounted = $fee_site[0] * $site_share_discount[0];
            $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
            $site_price = DB::table('fee_out_site_price')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_valid', 1)
                ->get();
            if (empty($site_price)) {
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tower1' => $fee_tower1[0],
                        'fee_house1' => $fee_house1[0],
                        'fee_support1' => $fee_support1[0],
                        'fee_maintain1' => $fee_maintain1[0],
                        'fee_tower2' => $fee_tower2[0] * 0.3,
                        'fee_house2' => $fee_house2[0] * 0.3,
                        'fee_support2' => $fee_support2[0] * 0.3,
                        'fee_maintain2' => $fee_maintain2[0] * 0.3,
                        'fee_tower3' => $fee_tower3[0] * 0.3,
                        'fee_house3' => $fee_house3[0] * 0.3,
                        'fee_support3' => $fee_support3[0] * 0.3,
                        'fee_maintain3' => $fee_maintain3[0] * 0.3,
                        'fee_tower4' => $fee_tower4[0] * 0.3,
                        'fee_house4' => $fee_house4[0] * 0.3,
                        'fee_support4' => $fee_support4[0] * 0.3,
                        'fee_maintain4' => $fee_maintain4[0] * 0.3,
                        'fee_tower5' => $fee_tower5[0] * 0.3,
                        'fee_house5' => $fee_house5[0] * 0.3,
                        'fee_support5' => $fee_support5[0] * 0.3,
                        'fee_maintain5' => $fee_maintain5[0] * 0.3,
                        'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                        'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                        'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                        'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                        'fee_wlan' => $feeWlan,
                        'fee_microwave' => $feeMicwav,
                        'fee_add' => $feeAdd,
                        'fee_battery' => $feeBat,
                        'fee_bbu' => $feeBbu,
                        'tower_share_discount1' => $tower_share_discount1[0],
                        'house_share_discount1' => $house_share_discount1[0],
                        'support_share_discount1' => $support_share_discount1[0],
                        'maintain_share_discount1' => $maintain_share_discount1[0],
                        'tower_share_discount_other' => $tower_share_discount_other[0],
                        'house_share_discount_other' => $house_share_discount_other[0],
                        'support_share_discount_other' => $support_share_discount_other[0],
                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                        'fee_tower_discounted' => $fee_tower_discounted,
                        'fee_house_discounted' => $fee_house_discounted,
                        'fee_support_discounted' => $fee_support_discounted,
                        'fee_maintain_discounted' => $fee_maintain_discounted,
                        'fee_site' => $fee_site[0],
                        'site_share_discount' => $site_share_discount[0],
                        'fee_site_discounted' => $fee_site_discounted,
                        'fee_import' => $fee_import[0],
                        'import_share_discount' => $import_share_discount[0],
                        'fee_import_discounted' => $fee_import_discounted,
                        'is_valid' => 1,
                        'effective_date' => $request->get('establishedTime'),
                        'region_name' => $request->get('region'),
                        'region_id' => transRegion($request->get('region'))
                    ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_valid', 1)
                    ->update([
                        'is_valid' => 0,
//                        'updated_at' => date('Y-m-d h:i:s',time())
                    ]);
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tower1' => $fee_tower1[0],
                        'fee_house1' => $fee_house1[0],
                        'fee_support1' => $fee_support1[0],
                        'fee_maintain1' => $fee_maintain1[0],
                        'fee_tower2' => $fee_tower2[0],
                        'fee_house2' => $fee_house2[0],
                        'fee_support2' => $fee_support2[0],
                        'fee_maintain2' => $fee_maintain2[0],
                        'fee_tower3' => $fee_tower3[0],
                        'fee_house3' => $fee_house3[0],
                        'fee_support3' => $fee_support3[0],
                        'fee_maintain3' => $fee_maintain3[0],
                        'fee_tower4' => $fee_tower4[0],
                        'fee_house4' => $fee_house4[0],
                        'fee_support4' => $fee_support4[0],
                        'fee_maintain4' => $fee_maintain4[0],
                        'fee_tower5' => $fee_tower5[0],
                        'fee_house5' => $fee_house5[0],
                        'fee_support5' => $fee_support5[0],
                        'fee_maintain5' => $fee_maintain5[0],
                        'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                        'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                        'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                        'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                        'fee_wlan' => $feeWlan,
                        'fee_microwave' => $feeMicwav,
                        'fee_add' => $feeAdd,
                        'fee_battery' => $feeBat,
                        'fee_bbu' => $feeBbu,
                        'tower_share_discount1' => $tower_share_discount1[0],
                        'house_share_discount1' => $house_share_discount1[0],
                        'support_share_discount1' => $support_share_discount1[0],
                        'maintain_share_discount1' => $maintain_share_discount1[0],
                        'tower_share_discount_other' => $tower_share_discount_other[0],
                        'house_share_discount_other' => $house_share_discount_other[0],
                        'support_share_discount_other' => $support_share_discount_other[0],
                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                        'fee_tower_discounted' => $fee_tower_discounted,
                        'fee_house_discounted' => $fee_house_discounted,
                        'fee_support_discounted' => $fee_support_discounted,
                        'fee_maintain_discounted' => $fee_maintain_discounted,
                        'fee_site' => $fee_site[0],
                        'site_share_discount' => $site_share_discount[0],
                        'fee_site_discounted' => $fee_site_discounted,
                        'fee_import' => $fee_import[0],
                        'import_share_discount' => $import_share_discount[0],
                        'fee_import_discounted' => $fee_import_discounted,
                        'is_valid' => 1,
                        'effective_date' => date('Y-m-d h:i:s', time()),
                        'region_name' => $request->get('region'),
                        'region_id' => transRegion($request->get('region'))
                    ]);
            }
            return Array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return Array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteOld(Request $request)
    {
        //插入站址属性信息
        $sysNum = $request->get('sysNum');
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }

        $siteIsExist = DB::table('site_info')->where('site_code', $request->get('siteCode'))->where('is_valid', 1)->get();
        if (empty($siteIsExist)) {
            $insSiteInfo = DB::table('site_info')->insert(
                ['site_code' => $request->get('siteCode'),
                    'region_name' => $request->get('region'),
                    'region_id' => transRegion($request->get('region')),
                    'product_type' => transProductType($request->get('productType')),
                    'share_num_tower' => transShareType($request->get('shareType_tower')),
                    'share_num_house' => transShareType($request->get('shareType_house')),
                    'share_num_support' => transShareType($request->get('shareType_supporting')),
                    'share_num_maintain' => transShareType($request->get('shareType_maintainence')),
                    'share_num_site' => transShareType($request->get('shareType_site')),
                    'share_num_import' => transShareType($request->get('shareType_import')),
                    'is_new_tower' => 0,
                    'is_newly_added' => transIsNewlyAdded($request->get('isNewlyAdded')),
                    'is_rru_away' => null,
                    'established_time' => $request->get('establishedTime'),
                    'effective_date' => date('Y-m-d', time()),
                    'sys_num' => $request->get('sysNum'),
                    'sys1_height' => transSysHeight($sysHeight1),
                    'sys2_height' => transSysHeight($sysHeight2),
                    'sys3_height' => transSysHeight($sysHeight3),
                    'sys4_height' => transSysHeight($sysHeight4),
                    'sys5_height' => transSysHeight($sysHeight5),
                    'is_co_opetition' => transIsCoOpetition($request->get('isCoOpetition')),
                    'is_valid' => 1,
                    'site_district_type' => null,
                    'tower_type' => transTowerType($request->get('towerType')),
                    'land_form' => transLandForm($request->get('landForm')),
                    'user_type' => transUserType($request->get('userType')),
                    'elec_introduced_type' => null,

                ]);
            $feeWlan = $request->get('feeWlan');
            $feeMicwav = $request->get('feeMicwav');
            $feeAdd = $request->get('feeAdd');
            $feeBat = $request->get('feeBat');
            $feeBbu = $request->get('feeBbu');
            if ($sysHeight1 != null) {
                $fee_tower1 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight1)
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
                $fee_house1 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_house');
                $fee_support1 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_support');
                $fee_maintain1 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_maintain');
                $tower_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_tower')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_basic');
                $house_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_house')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_basic');
                $support_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_supporting')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_basic');
                $maintain_share_discount1 = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_maintainence')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_basic');
            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
                $tower_share_discount1 = null;
                $house_share_discount1 = null;
                $support_share_discount1 = null;
                $maintain_share_discount1 = null;
            }
            if ($sysHeight2 != null) {
                $fee_tower2 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight2)
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
                $fee_house2 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_house');
                $fee_support2 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_support');
                $fee_maintain2 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_maintain');

            } else {
                $fee_tower2 = 0;
                $fee_house2 = 0;
                $fee_support2 = 0;
                $fee_maintain2 = 0;
            }
            if ($sysHeight3 != null) {
                $fee_tower3 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight3)
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
                $fee_house3 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_house');
                $fee_support3 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_support');
                $fee_maintain3 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_maintain');
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }
            if ($sysHeight4 != null) {
                $fee_tower4 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight4)
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
                $fee_house4 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_house');
                $fee_support4 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_support');
                $fee_maintain4 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_maintain');
            } else {
                $fee_tower4 = 0;
                $fee_house4 = 0;
                $fee_support4 = 0;
                $fee_maintain4 = 0;
            }
            if ($sysHeight5 != null) {
                $fee_tower5 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('sys_height', $sysHeight5)
                    ->where('is_new_tower', 0)
                    ->pluck('fee_tower');
                $fee_house5 = DB::table('fee_house_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_house');
                $fee_support5 = DB::table('fee_support_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_support');
                $fee_maintain5 = DB::table('fee_maintain_std')
                    ->where('tower_type', transTowerType($request->get('towerType')))
                    ->where('product_type', transProductType($request->get('productType')))
                    ->where('is_new_tower', 0)
                    ->pluck('fee_maintain');
            } else {
                $fee_tower5 = 0;
                $fee_house5 = 0;
                $fee_support5 = 0;
                $fee_maintain5 = 0;
            }
            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                $tower_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_tower')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 1)
                    ->pluck('discount_basic');
                $house_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_house')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 1)
                    ->pluck('discount_basic');
                $support_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_supporting')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 1)
                    ->pluck('discount_basic');
                $maintain_share_discount_other = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_maintainence')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 1)
                    ->pluck('discount_basic');
            } else {
                $tower_share_discount_other = null;
                $house_share_discount_other = null;
                $support_share_discount_other = null;
                $maintain_share_discount_other = null;
            }

            $fee_site = $request->get('feeSiteOld');
            $fee_import = 0;

            $site_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', 0)
                ->where('share_num', transShareType($request->get('shareType_site')))
                ->where('user_type', transUserType($request->get('userType')))
                ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                ->pluck('discount_site');
            $import_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', 0)
                ->where('share_num', transShareType($request->get('shareType_import')))
                ->where('user_type', transUserType($request->get('userType')))
                ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                ->pluck('discount_import');
            $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
            $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
            $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
            $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
            $fee_site_discounted = $fee_site * $site_share_discount[0];
            $fee_import_discounted = $fee_import * $import_share_discount[0];
            $site_price = DB::table('fee_out_site_price')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_valid', 1)
                ->get();
            if (empty($site_price)) {
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tower1' => $fee_tower1[0],
                        'fee_house1' => $fee_house1[0],
                        'fee_support1' => $fee_support1[0],
                        'fee_maintain1' => $fee_maintain1[0],
                        'fee_tower2' => $fee_tower2[0] * 0.3,
                        'fee_house2' => $fee_house2[0] * 0.3,
                        'fee_support2' => $fee_support2[0] * 0.3,
                        'fee_maintain2' => $fee_maintain2[0] * 0.3,
                        'fee_tower3' => $fee_tower3[0] * 0.3,
                        'fee_house3' => $fee_house3[0] * 0.3,
                        'fee_support3' => $fee_support3[0] * 0.3,
                        'fee_maintain3' => $fee_maintain3[0] * 0.3,
                        'fee_tower4' => $fee_tower4[0] * 0.3,
                        'fee_house4' => $fee_house4[0] * 0.3,
                        'fee_support4' => $fee_support4[0] * 0.3,
                        'fee_maintain4' => $fee_maintain4[0] * 0.3,
                        'fee_tower5' => $fee_tower5[0] * 0.3,
                        'fee_house5' => $fee_house5[0] * 0.3,
                        'fee_support5' => $fee_support5[0] * 0.3,
                        'fee_maintain5' => $fee_maintain5[0] * 0.3,
                        'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                        'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                        'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                        'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                        'fee_wlan' => $feeWlan,
                        'fee_microwave' => $feeMicwav,
                        'fee_add' => $feeAdd,
                        'fee_battery' => $feeBat,
                        'fee_bbu' => $feeBbu,
                        'tower_share_discount1' => $tower_share_discount1[0],
                        'house_share_discount1' => $house_share_discount1[0],
                        'support_share_discount1' => $support_share_discount1[0],
                        'maintain_share_discount1' => $maintain_share_discount1[0],
                        'tower_share_discount_other' => $tower_share_discount_other[0],
                        'house_share_discount_other' => $house_share_discount_other[0],
                        'support_share_discount_other' => $support_share_discount_other[0],
                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                        'fee_tower_discounted' => $fee_tower_discounted,
                        'fee_house_discounted' => $fee_house_discounted,
                        'fee_support_discounted' => $fee_support_discounted,
                        'fee_maintain_discounted' => $fee_maintain_discounted,
                        'fee_site' => $fee_site,
                        'site_share_discount' => $site_share_discount[0],
                        'fee_site_discounted' => $fee_site_discounted,
                        'fee_import' => $fee_import,
                        'import_share_discount' => $import_share_discount[0],
                        'fee_import_discounted' => $fee_import_discounted,
                        'is_valid' => 1,
                        'effective_date' => $request->get('establishedTime'),
                        'region_name' => $request->get('region'),
                        'region_id' => transRegion($request->get('region'))
                    ]);
            } else {
                $updSitePrice = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_valid', 1)
                    ->update([
                        'is_valid' => 0,
//                        'updated_at' => date('Y-m-d h:i:s',time())
                    ]);
                $insSitePrice = DB::table('fee_out_site_price')
                    ->insert([
                        'site_code' => $request->get('siteCode'),
                        'fee_tower1' => $fee_tower1[0],
                        'fee_house1' => $fee_house1[0],
                        'fee_support1' => $fee_support1[0],
                        'fee_maintain1' => $fee_maintain1[0],
                        'fee_tower2' => $fee_tower2[0],
                        'fee_house2' => $fee_house2[0],
                        'fee_support2' => $fee_support2[0],
                        'fee_maintain2' => $fee_maintain2[0],
                        'fee_tower3' => $fee_tower3[0],
                        'fee_house3' => $fee_house3[0],
                        'fee_support3' => $fee_support3[0],
                        'fee_maintain3' => $fee_maintain3[0],
                        'fee_tower4' => $fee_tower4[0],
                        'fee_house4' => $fee_house4[0],
                        'fee_support4' => $fee_support4[0],
                        'fee_maintain4' => $fee_maintain4[0],
                        'fee_tower5' => $fee_tower5[0],
                        'fee_house5' => $fee_house5[0],
                        'fee_support5' => $fee_support5[0],
                        'fee_maintain5' => $fee_maintain5[0],
                        'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                        'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                        'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                        'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                        'fee_wlan' => $feeWlan,
                        'fee_microwave' => $feeMicwav,
                        'fee_add' => $feeAdd,
                        'fee_battery' => $feeBat,
                        'fee_bbu' => $feeBbu,
                        'tower_share_discount1' => $tower_share_discount1[0],
                        'house_share_discount1' => $house_share_discount1[0],
                        'support_share_discount1' => $support_share_discount1[0],
                        'maintain_share_discount1' => $maintain_share_discount1[0],
                        'tower_share_discount_other' => $tower_share_discount_other[0],
                        'house_share_discount_other' => $house_share_discount_other[0],
                        'support_share_discount_other' => $support_share_discount_other[0],
                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                        'fee_tower_discounted' => $fee_tower_discounted,
                        'fee_house_discounted' => $fee_house_discounted,
                        'fee_support_discounted' => $fee_support_discounted,
                        'fee_maintain_discounted' => $fee_maintain_discounted,
                        'fee_site' => $fee_site,
                        'site_share_discount' => $site_share_discount[0],
                        'fee_site_discounted' => $fee_site_discounted,
                        'fee_import' => $fee_import[0],
                        'import_share_discount' => $import_share_discount[0],
                        'fee_import_discounted' => $fee_import_discounted,
                        'is_valid' => 1,
                        'effective_date' => date('Y-m-d h:i:s', time()),
                        'region_name' => $request->get('region'),
                        'region_id' => transRegion($request->get('region'))
                    ]);
            }
            return Array($siteIsExist, $insSiteInfo, $insSitePrice);
        } else {
            return Array($siteIsExist, false, false);
        }

    }

    public function addInfoSiteByArray(Array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            for ($i = 1; $i < count($infoSites); $i++) {
                $origInfoSiteID = DB::table('site_info')
                    ->where('site_code', $infoSites[$i][3])
                    ->where('is_valid', 1)
                    ->pluck('id');
                if (empty($origInfoSiteID)) {
                    DB::table('site_info')
                        ->insert([
                            'site_code' => $infoSites[$i][3],
                            'region_name' => $infoSites[$i][1],
                            'site_name' => $infoSites[$i][2],
                            'req_code' => $infoSites[$i][4],
                            'business_code' => $infoSites[$i][0],
                            'region_id' => transRegion($infoSites[$i][1]),
                            'product_type' => transProductType($infoSites[$i][5]),
                            'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                            'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                            'tower_type' => transTowerType($infoSites[$i][8]),
                            'sys_num' => $infoSites[$i][9],
                            'sys1_height' => transSysHeight($infoSites[$i][10]),
                            'sys1_height' => transSysHeight($infoSites[$i][11]),
                            'sys3_height' => transSysHeight($infoSites[$i][12]),
                            'sys4_height' => transSysHeight($infoSites[$i][13]),
                            'sys5_height' => transSysHeight($infoSites[$i][14]),
                            'land_form' => transLandForm($infoSites[$i][15]),
                            'is_co_opetition' => transIsCoOpetition($infoSites[$i][16]),
                            'share_num_house' => $infoSites[$i][17],
                            'share_num_tower' => $infoSites[$i][18],
                            'share_num_support' => $infoSites[$i][19],
                            'share_num_maintain' => $infoSites[$i][20],
                            'share_num_site' => $infoSites[$i][21],
                            'share_num_import' => $infoSites[$i][22],
                            'site_district_type' => transSiteDistType($infoSites[$i][23]),
                            'is_rru_away' => transIsRRUAway($infoSites[$i][24]),
                            'user_type' => transUserType($infoSites[$i][25]),
                            'elec_introduced_type' => transElecType($infoSites[$i][26]),
                            'established_time' => $infoSites[$i][33],
                            'is_valid' => 1,
                        ]);

                    //插入对应的新建站的服务费用
                    if (transIsNewTower($infoSites[$i][6]) == 1) {
                        $sysNum = $infoSites[$i][9];
                        $sysHeight1 = transSysHeight($infoSites[$i][10]);
                        $sysHeight2 = transSysHeight($infoSites[$i][11]);
                        $sysHeight3 = transSysHeight($infoSites[$i][12]);
                        $sysHeight4 = transSysHeight($infoSites[$i][13]);
                        $sysHeight5 = transSysHeight($infoSites[$i][14]);
                        if ($sysNum == '1') {
                            $sysHeight2 = null;
                            $sysHeight3 = null;
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '2') {
                            $sysHeight3 = null;
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '3') {
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '4') {
                            $sysHeight5 = null;
                        }
                        $feeWlan = $infoSites[$i][27];
                        $feeMicwav = $infoSites[$i][28];
                        $feeAdd = $infoSites[$i][29];
                        $feeBat = $infoSites[$i][30];
                        $feeBbu = $infoSites[$i][31];
                        if ($sysHeight1 != null) {
                            $fee_tower1 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight1)
                                ->where('is_new_tower', 1)
                                ->pluck('fee_tower');
                            $fee_house1 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_house');
                            $fee_support1 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_support');
                            $fee_maintain1 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_maintain');
                            $tower_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][18])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $house_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][17])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $support_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][19])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $maintain_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][20])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                        } else {
                            $fee_tower1 = 0;
                            $fee_house1 = 0;
                            $fee_support1 = 0;
                            $fee_maintain1 = 0;
                            $tower_share_discount1 = null;
                            $house_share_discount1 = null;
                            $support_share_discount1 = null;
                            $maintain_share_discount1 = null;
                        }
                        if ($sysHeight2 != null) {
                            $fee_tower2 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight2)
                                ->where('is_new_tower', 1)
                                ->pluck('fee_tower');
                            $fee_house2 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_house');
                            $fee_support2 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_support');
                            $fee_maintain2 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_maintain');

                        } else {
                            $fee_tower2 = 0;
                            $fee_house2 = 0;
                            $fee_support2 = 0;
                            $fee_maintain2 = 0;
                        }
                        if ($sysHeight3 != null) {
                            $fee_tower3 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight3)
                                ->where('is_new_tower', 1)
                                ->pluck('fee_tower');
                            $fee_house3 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_house');
                            $fee_support3 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_support');
                            $fee_maintain3 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower3 = 0;
                            $fee_house3 = 0;
                            $fee_support3 = 0;
                            $fee_maintain3 = 0;
                        }
                        if ($sysHeight4 != null) {
                            $fee_tower4 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight4)
                                ->where('is_new_tower', 1)
                                ->pluck('fee_tower');
                            $fee_house4 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_house');
                            $fee_support4 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_support');
                            $fee_maintain4 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower4 = 0;
                            $fee_house4 = 0;
                            $fee_support4 = 0;
                            $fee_maintain4 = 0;
                        }
                        if ($sysHeight5 != null) {
                            $fee_tower5 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight5)
                                ->where('is_new_tower', 1)
                                ->pluck('fee_tower');
                            $fee_house5 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_house');
                            $fee_support5 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_support');
                            $fee_maintain5 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 1)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower5 = 0;
                            $fee_house5 = 0;
                            $fee_support5 = 0;
                            $fee_maintain5 = 0;
                        }
                        if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                            $tower_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][18])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $house_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][17])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $support_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][19])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                            $maintain_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][20])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_basic');
                        } else {
                            $tower_share_discount_other = null;
                            $house_share_discount_other = null;
                            $support_share_discount_other = null;
                            $maintain_share_discount_other = null;
                        }

                        $fee_site = DB::table('fee_site_std')
                            ->where('region_id', transRegion($infoSites[$i][1]))
                            ->where('site_district_type', transSiteDistType($infoSites[$i][23]))
                            ->where('is_rru_away', transIsRRUAway($infoSites[$i][24]))
                            ->pluck('fee_site');
                        $fee_import = DB::table('fee_import_std')
                            ->where('region_id', transRegion($infoSites[$i][1]))
                            ->where('elec_introduced_type', transElecType($infoSites[$i][26]))
                            ->pluck('fee_import');

                        $site_share_discount = DB::table('share_discount_std')
                            ->where('is_new_tower', 1)
                            ->where('share_num', $infoSites[$i][21])
                            ->where('user_type', transUserType($infoSites[$i][25]))
                            ->where('is_newly_added', 0)
                            ->pluck('discount_site');
                        $import_share_discount = DB::table('share_discount_std')
                            ->where('is_new_tower', 1)
                            ->where('share_num', $infoSites[$i][22])
                            ->where('user_type', transUserType($infoSites[$i][25]))
                            ->where('is_newly_added', 0)
                            ->pluck('discount_import');
                        $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                            ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                        $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                            ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                        $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                            ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                        $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                            ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                        $fee_site_discounted = $fee_site[0] * $site_share_discount[0];
                        $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
                        $site_price = DB::table('fee_out_site_price')
                            ->where('site_code', $infoSites[$i][3])
                            ->where('is_valid', 1)
                            ->get();
                        if (empty($site_price)) {
                            $insSitePrice = DB::table('fee_out_site_price')
                                ->insert([
                                    'site_code' => $infoSites[$i][3],
                                    'fee_tower1' => $fee_tower1[0],
                                    'fee_house1' => $fee_house1[0],
                                    'fee_support1' => $fee_support1[0],
                                    'fee_maintain1' => $fee_maintain1[0],
                                    'fee_tower2' => $fee_tower2[0] * 0.3,
                                    'fee_house2' => $fee_house2[0] * 0.3,
                                    'fee_support2' => $fee_support2[0] * 0.3,
                                    'fee_maintain2' => $fee_maintain2[0] * 0.3,
                                    'fee_tower3' => $fee_tower3[0] * 0.3,
                                    'fee_house3' => $fee_house3[0] * 0.3,
                                    'fee_support3' => $fee_support3[0] * 0.3,
                                    'fee_maintain3' => $fee_maintain3[0] * 0.3,
                                    'fee_tower4' => $fee_tower4[0] * 0.3,
                                    'fee_house4' => $fee_house4[0] * 0.3,
                                    'fee_support4' => $fee_support4[0] * 0.3,
                                    'fee_maintain4' => $fee_maintain4[0] * 0.3,
                                    'fee_tower5' => $fee_tower5[0] * 0.3,
                                    'fee_house5' => $fee_house5[0] * 0.3,
                                    'fee_support5' => $fee_support5[0] * 0.3,
                                    'fee_maintain5' => $fee_maintain5[0] * 0.3,
                                    'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                                    'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                                    'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                                    'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                                    'fee_wlan' => $feeWlan,
                                    'fee_microwave' => $feeMicwav,
                                    'fee_add' => $feeAdd,
                                    'fee_battery' => $feeBat,
                                    'fee_bbu' => $feeBbu,
                                    'tower_share_discount1' => $tower_share_discount1[0],
                                    'house_share_discount1' => $house_share_discount1[0],
                                    'support_share_discount1' => $support_share_discount1[0],
                                    'maintain_share_discount1' => $maintain_share_discount1[0],
                                    'tower_share_discount_other' => $tower_share_discount_other[0],
                                    'house_share_discount_other' => $house_share_discount_other[0],
                                    'support_share_discount_other' => $support_share_discount_other[0],
                                    'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                    'fee_tower_discounted' => $fee_tower_discounted,
                                    'fee_house_discounted' => $fee_house_discounted,
                                    'fee_support_discounted' => $fee_support_discounted,
                                    'fee_maintain_discounted' => $fee_maintain_discounted,
                                    'fee_site' => $fee_site[0],
                                    'site_share_discount' => $site_share_discount[0],
                                    'fee_site_discounted' => $fee_site_discounted,
                                    'fee_import' => $fee_import[0],
                                    'import_share_discount' => $import_share_discount[0],
                                    'fee_import_discounted' => $fee_import_discounted,
                                    'is_valid' => 1,
                                    'effective_date' => $infoSites[$i][33],
                                    'region_name' => $infoSites[$i][0],
                                    'region_id' => transRegion($infoSites[$i][1])
                                ]);
                        } else {
                            $updSitePrice = DB::table('fee_out_site_price')
                                ->where('site_code', $infoSites[$i][3])
                                ->where('is_valid', 1)
                                ->update([
                                    'is_valid' => 0,
//                        'updated_at' => date('Y-m-d h:i:s',time())
                                ]);
                            $insSitePrice = DB::table('fee_out_site_price')
                                ->insert([
                                    'site_code' => $infoSites[$i][3],
                                    'fee_tower1' => $fee_tower1[0],
                                    'fee_house1' => $fee_house1[0],
                                    'fee_support1' => $fee_support1[0],
                                    'fee_maintain1' => $fee_maintain1[0],
                                    'fee_tower2' => $fee_tower2[0],
                                    'fee_house2' => $fee_house2[0],
                                    'fee_support2' => $fee_support2[0],
                                    'fee_maintain2' => $fee_maintain2[0],
                                    'fee_tower3' => $fee_tower3[0],
                                    'fee_house3' => $fee_house3[0],
                                    'fee_support3' => $fee_support3[0],
                                    'fee_maintain3' => $fee_maintain3[0],
                                    'fee_tower4' => $fee_tower4[0],
                                    'fee_house4' => $fee_house4[0],
                                    'fee_support4' => $fee_support4[0],
                                    'fee_maintain4' => $fee_maintain4[0],
                                    'fee_tower5' => $fee_tower5[0],
                                    'fee_house5' => $fee_house5[0],
                                    'fee_support5' => $fee_support5[0],
                                    'fee_maintain5' => $fee_maintain5[0],
                                    'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                                    'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                                    'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                                    'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                                    'fee_wlan' => $feeWlan,
                                    'fee_microwave' => $feeMicwav,
                                    'fee_add' => $feeAdd,
                                    'fee_battery' => $feeBat,
                                    'fee_bbu' => $feeBbu,
                                    'tower_share_discount1' => $tower_share_discount1[0],
                                    'house_share_discount1' => $house_share_discount1[0],
                                    'support_share_discount1' => $support_share_discount1[0],
                                    'maintain_share_discount1' => $maintain_share_discount1[0],
                                    'tower_share_discount_other' => $tower_share_discount_other[0],
                                    'house_share_discount_other' => $house_share_discount_other[0],
                                    'support_share_discount_other' => $support_share_discount_other[0],
                                    'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                    'fee_tower_discounted' => $fee_tower_discounted,
                                    'fee_house_discounted' => $fee_house_discounted,
                                    'fee_support_discounted' => $fee_support_discounted,
                                    'fee_maintain_discounted' => $fee_maintain_discounted,
                                    'fee_site' => $fee_site[0],
                                    'site_share_discount' => $site_share_discount[0],
                                    'fee_site_discounted' => $fee_site_discounted,
                                    'fee_import' => $fee_import[0],
                                    'import_share_discount' => $import_share_discount[0],
                                    'fee_import_discounted' => $fee_import_discounted,
                                    'is_valid' => 1,
                                    'effective_date' => $infoSites[$i][33],
                                    'region_name' => $infoSites[$i][0],
                                    'region_id' => transRegion($infoSites[$i][1])
                                ]);
                        }
                    } else {
                        $sysNum = $infoSites[$i][9];
                        $sysHeight1 = transSysHeight($infoSites[$i][10]);
                        $sysHeight2 = transSysHeight($infoSites[$i][11]);
                        $sysHeight3 = transSysHeight($infoSites[$i][12]);
                        $sysHeight4 = transSysHeight($infoSites[$i][13]);
                        $sysHeight5 = transSysHeight($infoSites[$i][14]);
                        if ($sysNum == '1') {
                            $sysHeight2 = null;
                            $sysHeight3 = null;
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '2') {
                            $sysHeight3 = null;
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '3') {
                            $sysHeight4 = null;
                            $sysHeight5 = null;
                        }
                        if ($sysNum == '4') {
                            $sysHeight5 = null;
                        }
                        $feeWlan = $infoSites[$i][27];
                        $feeMicwav = $infoSites[$i][28];
                        $feeAdd = $infoSites[$i][29];
                        $feeBat = $infoSites[$i][30];
                        $feeBbu = $infoSites[$i][31];
                        if ($sysHeight1 != null) {
                            $fee_tower1 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight1)
                                ->where('is_new_tower', 0)
                                ->pluck('fee_tower');
                            $fee_house1 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_house');
                            $fee_support1 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_support');
                            $fee_maintain1 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_maintain');
                            $tower_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][18])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $house_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][17])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $support_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][19])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $maintain_share_discount1 = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][20])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                        } else {
                            $fee_tower1 = 0;
                            $fee_house1 = 0;
                            $fee_support1 = 0;
                            $fee_maintain1 = 0;
                            $tower_share_discount1 = null;
                            $house_share_discount1 = null;
                            $support_share_discount1 = null;
                            $maintain_share_discount1 = null;
                        }
                        if ($sysHeight2 != null) {
                            $fee_tower2 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight2)
                                ->where('is_new_tower', 0)
                                ->pluck('fee_tower');
                            $fee_house2 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_house');
                            $fee_support2 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_support');
                            $fee_maintain2 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_maintain');

                        } else {
                            $fee_tower2 = 0;
                            $fee_house2 = 0;
                            $fee_support2 = 0;
                            $fee_maintain2 = 0;
                        }
                        if ($sysHeight3 != null) {
                            $fee_tower3 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight3)
                                ->where('is_new_tower', 0)
                                ->pluck('fee_tower');
                            $fee_house3 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_house');
                            $fee_support3 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_support');
                            $fee_maintain3 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower3 = 0;
                            $fee_house3 = 0;
                            $fee_support3 = 0;
                            $fee_maintain3 = 0;
                        }
                        if ($sysHeight4 != null) {
                            $fee_tower4 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight4)
                                ->where('is_new_tower', 0)
                                ->pluck('fee_tower');
                            $fee_house4 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_house');
                            $fee_support4 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_support');
                            $fee_maintain4 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower4 = 0;
                            $fee_house4 = 0;
                            $fee_support4 = 0;
                            $fee_maintain4 = 0;
                        }
                        if ($sysHeight5 != null) {
                            $fee_tower5 = DB::table('fee_tower_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('sys_height', $sysHeight5)
                                ->where('is_new_tower', 0)
                                ->pluck('fee_tower');
                            $fee_house5 = DB::table('fee_house_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_house');
                            $fee_support5 = DB::table('fee_support_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_support');
                            $fee_maintain5 = DB::table('fee_maintain_std')
                                ->where('tower_type', transTowerType($infoSites[$i][8]))
                                ->where('product_type', transProductType($infoSites[$i][5]))
                                ->where('is_new_tower', 0)
                                ->pluck('fee_maintain');
                        } else {
                            $fee_tower5 = 0;
                            $fee_house5 = 0;
                            $fee_support5 = 0;
                            $fee_maintain5 = 0;
                        }
                        if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                            $tower_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][18])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $house_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][17])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $support_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][19])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                            $maintain_share_discount_other = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][20])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_basic');
                        } else {
                            $tower_share_discount_other = null;
                            $house_share_discount_other = null;
                            $support_share_discount_other = null;
                            $maintain_share_discount_other = null;
                        }

                        $fee_site = $infoSites[$i][32];
                        $fee_import = 0;

                        $site_share_discount = DB::table('share_discount_std')
                            ->where('is_new_tower', 0)
                            ->where('share_num', $infoSites[$i][21])
                            ->where('user_type', transUserType($infoSites[$i][25]))
                            ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                            ->pluck('discount_site');
                        $import_share_discount = DB::table('share_discount_std')
                            ->where('is_new_tower', 0)
                            ->where('share_num', $infoSites[$i][22])
                            ->where('user_type', transUserType($infoSites[$i][25]))
                            ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                            ->pluck('discount_import');
                        $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                            ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                        $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                            ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                        $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                            ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                        $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                            ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                        $fee_site_discounted = $fee_site * $site_share_discount[0];
                        $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
                        $site_price = DB::table('fee_out_site_price')
                            ->where('site_code', $infoSites[$i][3])
                            ->where('is_valid', 1)
                            ->get();
                        if (empty($site_price)) {
                            $insSitePrice = DB::table('fee_out_site_price')
                                ->insert([
                                    'site_code' => $infoSites[$i][3],
                                    'fee_tower1' => $fee_tower1[0],
                                    'fee_house1' => $fee_house1[0],
                                    'fee_support1' => $fee_support1[0],
                                    'fee_maintain1' => $fee_maintain1[0],
                                    'fee_tower2' => $fee_tower2[0] * 0.3,
                                    'fee_house2' => $fee_house2[0] * 0.3,
                                    'fee_support2' => $fee_support2[0] * 0.3,
                                    'fee_maintain2' => $fee_maintain2[0] * 0.3,
                                    'fee_tower3' => $fee_tower3[0] * 0.3,
                                    'fee_house3' => $fee_house3[0] * 0.3,
                                    'fee_support3' => $fee_support3[0] * 0.3,
                                    'fee_maintain3' => $fee_maintain3[0] * 0.3,
                                    'fee_tower4' => $fee_tower4[0] * 0.3,
                                    'fee_house4' => $fee_house4[0] * 0.3,
                                    'fee_support4' => $fee_support4[0] * 0.3,
                                    'fee_maintain4' => $fee_maintain4[0] * 0.3,
                                    'fee_tower5' => $fee_tower5[0] * 0.3,
                                    'fee_house5' => $fee_house5[0] * 0.3,
                                    'fee_support5' => $fee_support5[0] * 0.3,
                                    'fee_maintain5' => $fee_maintain5[0] * 0.3,
                                    'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                                    'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                                    'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                                    'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                                    'fee_wlan' => $feeWlan,
                                    'fee_microwave' => $feeMicwav,
                                    'fee_add' => $feeAdd,
                                    'fee_battery' => $feeBat,
                                    'fee_bbu' => $feeBbu,
                                    'tower_share_discount1' => $tower_share_discount1[0],
                                    'house_share_discount1' => $house_share_discount1[0],
                                    'support_share_discount1' => $support_share_discount1[0],
                                    'maintain_share_discount1' => $maintain_share_discount1[0],
                                    'tower_share_discount_other' => $tower_share_discount_other[0],
                                    'house_share_discount_other' => $house_share_discount_other[0],
                                    'support_share_discount_other' => $support_share_discount_other[0],
                                    'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                    'fee_tower_discounted' => $fee_tower_discounted,
                                    'fee_house_discounted' => $fee_house_discounted,
                                    'fee_support_discounted' => $fee_support_discounted,
                                    'fee_maintain_discounted' => $fee_maintain_discounted,
                                    'fee_site' => $fee_site,
                                    'site_share_discount' => $site_share_discount[0],
                                    'fee_site_discounted' => $fee_site_discounted,
                                    'fee_import' => $fee_import[0],
                                    'import_share_discount' => $import_share_discount[0],
                                    'fee_import_discounted' => $fee_import_discounted,
                                    'is_valid' => 1,
                                    'effective_date' => $infoSites[$i][33],
                                    'region_name' => $infoSites[$i][0],
                                    'region_id' => transRegion($infoSites[$i][1])
                                ]);
                        } else {
                            $updSitePrice = DB::table('fee_out_site_price')
                                ->where('site_code', $infoSites[$i][3])
                                ->where('is_valid', 1)
                                ->update([
                                    'is_valid' => 0,
                                ]);
                            $insSitePrice = DB::table('fee_out_site_price')
                                ->insert([
                                    'site_code' => $infoSites[$i][3],
                                    'fee_tower1' => $fee_tower1[0],
                                    'fee_house1' => $fee_house1[0],
                                    'fee_support1' => $fee_support1[0],
                                    'fee_maintain1' => $fee_maintain1[0],
                                    'fee_tower2' => $fee_tower2[0],
                                    'fee_house2' => $fee_house2[0],
                                    'fee_support2' => $fee_support2[0],
                                    'fee_maintain2' => $fee_maintain2[0],
                                    'fee_tower3' => $fee_tower3[0],
                                    'fee_house3' => $fee_house3[0],
                                    'fee_support3' => $fee_support3[0],
                                    'fee_maintain3' => $fee_maintain3[0],
                                    'fee_tower4' => $fee_tower4[0],
                                    'fee_house4' => $fee_house4[0],
                                    'fee_support4' => $fee_support4[0],
                                    'fee_maintain4' => $fee_maintain4[0],
                                    'fee_tower5' => $fee_tower5[0],
                                    'fee_house5' => $fee_house5[0],
                                    'fee_support5' => $fee_support5[0],
                                    'fee_maintain5' => $fee_maintain5[0],
                                    'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                                    'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                                    'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                                    'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                                    'fee_wlan' => $feeWlan,
                                    'fee_microwave' => $feeMicwav,
                                    'fee_add' => $feeAdd,
                                    'fee_battery' => $feeBat,
                                    'fee_bbu' => $feeBbu,
                                    'tower_share_discount1' => $tower_share_discount1[0],
                                    'house_share_discount1' => $house_share_discount1[0],
                                    'support_share_discount1' => $support_share_discount1[0],
                                    'maintain_share_discount1' => $maintain_share_discount1[0],
                                    'tower_share_discount_other' => $tower_share_discount_other[0],
                                    'house_share_discount_other' => $house_share_discount_other[0],
                                    'support_share_discount_other' => $support_share_discount_other[0],
                                    'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                    'fee_tower_discounted' => $fee_tower_discounted,
                                    'fee_house_discounted' => $fee_house_discounted,
                                    'fee_support_discounted' => $fee_support_discounted,
                                    'fee_maintain_discounted' => $fee_maintain_discounted,
                                    'fee_site' => $fee_site,
                                    'site_share_discount' => $site_share_discount[0],
                                    'fee_site_discounted' => $fee_site_discounted,
                                    'fee_import' => $fee_import[0],
                                    'import_share_discount' => $import_share_discount[0],
                                    'fee_import_discounted' => $fee_import_discounted,
                                    'is_valid' => 1,
                                    'effective_date' => $infoSites[$i][33],
                                    'region_name' => $infoSites[$i][0],
                                    'region_id' => transRegion($infoSites[$i][1])
                                ]);
                        }
                    }


                } else {
                    DB::table('import_site_exception')
                        ->insert([
                            'site_code' => $infoSites[$i][3],
                            'region_name' => $infoSites[$i][0],
                            'region_id' => transRegion($infoSites[$i][1]),
                            'product_type' => transProductType($infoSites[$i][5]),
                            'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                            'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                            'tower_type' => transTowerType($infoSites[$i][8]),
                            'sys_num' => $infoSites[$i][9],
                            'sys1_height' => transSysHeight($infoSites[$i][10]),
                            'sys1_height' => transSysHeight($infoSites[$i][11]),
                            'sys3_height' => transSysHeight($infoSites[$i][12]),
                            'sys4_height' => transSysHeight($infoSites[$i][13]),
                            'sys5_height' => transSysHeight($infoSites[$i][14]),
                            'land_form' => transLandForm($infoSites[$i][15]),
                            'is_co_opetition' => transIsCoOpetition($infoSites[$i][16]),
                            'share_num_house' => $infoSites[$i][17],
                            'share_num_tower' => $infoSites[$i][18],
                            'share_num_support' => $infoSites[$i][19],
                            'share_num_maintain' => $infoSites[$i][20],
                            'share_num_site' => $infoSites[$i][21],
                            'share_num_import' => $infoSites[$i][22],
                            'site_district_type' => transSiteDistType($infoSites[$i][23]),
                            'is_rru_away' => transIsRRUAway($infoSites[$i][24]),
                            'user_type' => transUserType($infoSites[$i][25]),
                            'elec_introduced_type' => transElecType($infoSites[$i][26]),
                            'site_info_id' => $origInfoSiteID[0],
                            'check_status' => 0
                        ]);
                }


            }
        } else {
            for ($i = 1; $i < count($infoSites); $i++) {
                if ($infoSites[$i][0] == $area_level) {
                    $origInfoSiteID = DB::table('site_info')
                        ->where('site_code', $infoSites[$i][3])
                        ->where('is_valid', 1)
                        ->pluck('id');
                    if (empty($origInfoSiteID)) {
                        DB::table('site_info')
                            ->insert([
                                'site_code' => $infoSites[$i][3],
                                'region_name' => $infoSites[$i][0],
                                'region_id' => transRegion($infoSites[$i][1]),
                                'product_type' => transProductType($infoSites[$i][5]),
                                'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                                'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                                'tower_type' => transTowerType($infoSites[$i][8]),
                                'sys_num' => $infoSites[$i][9],
                                'sys1_height' => transSysHeight($infoSites[$i][10]),
                                'sys1_height' => transSysHeight($infoSites[$i][11]),
                                'sys3_height' => transSysHeight($infoSites[$i][12]),
                                'sys4_height' => transSysHeight($infoSites[$i][13]),
                                'sys5_height' => transSysHeight($infoSites[$i][14]),
                                'land_form' => transLandForm($infoSites[$i][15]),
                                'is_co_opetition' => transIsCoOpetition($infoSites[$i][16]),
                                'share_num_house' => $infoSites[$i][17],
                                'share_num_tower' => $infoSites[$i][18],
                                'share_num_support' => $infoSites[$i][19],
                                'share_num_maintain' => $infoSites[$i][20],
                                'share_num_site' => $infoSites[$i][21],
                                'share_num_import' => $infoSites[$i][22],
                                'site_district_type' => transSiteDistType($infoSites[$i][23]),
                                'is_rru_away' => transIsRRUAway($infoSites[$i][24]),
                                'user_type' => transUserType($infoSites[$i][25]),
                                'elec_introduced_type' => transElecType($infoSites[$i][26]),
                                'established_time' => $infoSites[$i][33],
                                'is_valid' => 1,
                            ]);

                        //插入对应的新建站的服务费用
                        if (transIsNewTower($infoSites[$i][6]) == 1) {
                            $sysNum = $infoSites[$i][9];
                            $sysHeight1 = transSysHeight($infoSites[$i][10]);
                            $sysHeight2 = transSysHeight($infoSites[$i][11]);
                            $sysHeight3 = transSysHeight($infoSites[$i][12]);
                            $sysHeight4 = transSysHeight($infoSites[$i][13]);
                            $sysHeight5 = transSysHeight($infoSites[$i][14]);
                            if ($sysNum == '1') {
                                $sysHeight2 = null;
                                $sysHeight3 = null;
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '2') {
                                $sysHeight3 = null;
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '3') {
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '4') {
                                $sysHeight5 = null;
                            }
                            $feeWlan = $infoSites[$i][27];
                            $feeMicwav = $infoSites[$i][28];
                            $feeAdd = $infoSites[$i][29];
                            $feeBat = $infoSites[$i][30];
                            $feeBbu = $infoSites[$i][31];
                            if ($sysHeight1 != null) {
                                $fee_tower1 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight1)
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_tower');
                                $fee_house1 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_house');
                                $fee_support1 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_support');
                                $fee_maintain1 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_maintain');
                                $tower_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][18])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $house_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][17])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $support_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][19])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $maintain_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][20])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                            } else {
                                $fee_tower1 = 0;
                                $fee_house1 = 0;
                                $fee_support1 = 0;
                                $fee_maintain1 = 0;
                                $tower_share_discount1 = null;
                                $house_share_discount1 = null;
                                $support_share_discount1 = null;
                                $maintain_share_discount1 = null;
                            }
                            if ($sysHeight2 != null) {
                                $fee_tower2 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight2)
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_tower');
                                $fee_house2 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_house');
                                $fee_support2 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_support');
                                $fee_maintain2 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_maintain');

                            } else {
                                $fee_tower2 = 0;
                                $fee_house2 = 0;
                                $fee_support2 = 0;
                                $fee_maintain2 = 0;
                            }
                            if ($sysHeight3 != null) {
                                $fee_tower3 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight3)
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_tower');
                                $fee_house3 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_house');
                                $fee_support3 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_support');
                                $fee_maintain3 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower3 = 0;
                                $fee_house3 = 0;
                                $fee_support3 = 0;
                                $fee_maintain3 = 0;
                            }
                            if ($sysHeight4 != null) {
                                $fee_tower4 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight4)
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_tower');
                                $fee_house4 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_house');
                                $fee_support4 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_support');
                                $fee_maintain4 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower4 = 0;
                                $fee_house4 = 0;
                                $fee_support4 = 0;
                                $fee_maintain4 = 0;
                            }
                            if ($sysHeight5 != null) {
                                $fee_tower5 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight5)
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_tower');
                                $fee_house5 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_house');
                                $fee_support5 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_support');
                                $fee_maintain5 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 1)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower5 = 0;
                                $fee_house5 = 0;
                                $fee_support5 = 0;
                                $fee_maintain5 = 0;
                            }
                            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                                $tower_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][18])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $house_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][17])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $support_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][19])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                                $maintain_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 1)
                                    ->where('share_num', $infoSites[$i][20])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', 0)
                                    ->pluck('discount_basic');
                            } else {
                                $tower_share_discount_other = null;
                                $house_share_discount_other = null;
                                $support_share_discount_other = null;
                                $maintain_share_discount_other = null;
                            }

                            $fee_site = DB::table('fee_site_std')
                                ->where('region_id', transRegion($infoSites[$i][1]))
                                ->where('site_district_type', transSiteDistType($infoSites[$i][23]))
                                ->where('is_rru_away', transIsRRUAway($infoSites[$i][24]))
                                ->pluck('fee_site');
                            $fee_import = DB::table('fee_import_std')
                                ->where('region_id', transRegion($infoSites[$i][1]))
                                ->where('elec_introduced_type', transElecType($infoSites[$i][26]))
                                ->pluck('fee_import');

                            $site_share_discount = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][21])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_site');
                            $import_share_discount = DB::table('share_discount_std')
                                ->where('is_new_tower', 1)
                                ->where('share_num', $infoSites[$i][22])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', 0)
                                ->pluck('discount_import');
                            $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                                ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                            $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                                ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                            $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                                ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                            $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                                ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                            $fee_site_discounted = $fee_site[0] * $site_share_discount[0];
                            $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
                            $site_price = DB::table('fee_out_site_price')
                                ->where('site_code', $infoSites[$i][3])
                                ->where('is_valid', 1)
                                ->get();
                            if (empty($site_price)) {
                                $insSitePrice = DB::table('fee_out_site_price')
                                    ->insert([
                                        'site_code' => $infoSites[$i][3],
                                        'fee_tower1' => $fee_tower1[0],
                                        'fee_house1' => $fee_house1[0],
                                        'fee_support1' => $fee_support1[0],
                                        'fee_maintain1' => $fee_maintain1[0],
                                        'fee_tower2' => $fee_tower2[0] * 0.3,
                                        'fee_house2' => $fee_house2[0] * 0.3,
                                        'fee_support2' => $fee_support2[0] * 0.3,
                                        'fee_maintain2' => $fee_maintain2[0] * 0.3,
                                        'fee_tower3' => $fee_tower3[0] * 0.3,
                                        'fee_house3' => $fee_house3[0] * 0.3,
                                        'fee_support3' => $fee_support3[0] * 0.3,
                                        'fee_maintain3' => $fee_maintain3[0] * 0.3,
                                        'fee_tower4' => $fee_tower4[0] * 0.3,
                                        'fee_house4' => $fee_house4[0] * 0.3,
                                        'fee_support4' => $fee_support4[0] * 0.3,
                                        'fee_maintain4' => $fee_maintain4[0] * 0.3,
                                        'fee_tower5' => $fee_tower5[0] * 0.3,
                                        'fee_house5' => $fee_house5[0] * 0.3,
                                        'fee_support5' => $fee_support5[0] * 0.3,
                                        'fee_maintain5' => $fee_maintain5[0] * 0.3,
                                        'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                                        'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                                        'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                                        'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                                        'fee_wlan' => $feeWlan,
                                        'fee_microwave' => $feeMicwav,
                                        'fee_add' => $feeAdd,
                                        'fee_battery' => $feeBat,
                                        'fee_bbu' => $feeBbu,
                                        'tower_share_discount1' => $tower_share_discount1[0],
                                        'house_share_discount1' => $house_share_discount1[0],
                                        'support_share_discount1' => $support_share_discount1[0],
                                        'maintain_share_discount1' => $maintain_share_discount1[0],
                                        'tower_share_discount_other' => $tower_share_discount_other[0],
                                        'house_share_discount_other' => $house_share_discount_other[0],
                                        'support_share_discount_other' => $support_share_discount_other[0],
                                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                        'fee_tower_discounted' => $fee_tower_discounted,
                                        'fee_house_discounted' => $fee_house_discounted,
                                        'fee_support_discounted' => $fee_support_discounted,
                                        'fee_maintain_discounted' => $fee_maintain_discounted,
                                        'fee_site' => $fee_site[0],
                                        'site_share_discount' => $site_share_discount[0],
                                        'fee_site_discounted' => $fee_site_discounted,
                                        'fee_import' => $fee_import[0],
                                        'import_share_discount' => $import_share_discount[0],
                                        'fee_import_discounted' => $fee_import_discounted,
                                        'is_valid' => 1,
                                        'effective_date' => $infoSites[$i][33],
                                        'region_name' => $infoSites[$i][0],
                                        'region_id' => transRegion($infoSites[$i][1])
                                    ]);
                            } else {
                                $updSitePrice = DB::table('fee_out_site_price')
                                    ->where('site_code', $infoSites[$i][3])
                                    ->where('is_valid', 1)
                                    ->update([
                                        'is_valid' => 0,
                                    ]);
                                $insSitePrice = DB::table('fee_out_site_price')
                                    ->insert([
                                        'site_code' => $infoSites[$i][3],
                                        'fee_tower1' => $fee_tower1[0],
                                        'fee_house1' => $fee_house1[0],
                                        'fee_support1' => $fee_support1[0],
                                        'fee_maintain1' => $fee_maintain1[0],
                                        'fee_tower2' => $fee_tower2[0],
                                        'fee_house2' => $fee_house2[0],
                                        'fee_support2' => $fee_support2[0],
                                        'fee_maintain2' => $fee_maintain2[0],
                                        'fee_tower3' => $fee_tower3[0],
                                        'fee_house3' => $fee_house3[0],
                                        'fee_support3' => $fee_support3[0],
                                        'fee_maintain3' => $fee_maintain3[0],
                                        'fee_tower4' => $fee_tower4[0],
                                        'fee_house4' => $fee_house4[0],
                                        'fee_support4' => $fee_support4[0],
                                        'fee_maintain4' => $fee_maintain4[0],
                                        'fee_tower5' => $fee_tower5[0],
                                        'fee_house5' => $fee_house5[0],
                                        'fee_support5' => $fee_support5[0],
                                        'fee_maintain5' => $fee_maintain5[0],
                                        'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                                        'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                                        'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                                        'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                                        'fee_wlan' => $feeWlan,
                                        'fee_microwave' => $feeMicwav,
                                        'fee_add' => $feeAdd,
                                        'fee_battery' => $feeBat,
                                        'fee_bbu' => $feeBbu,
                                        'tower_share_discount1' => $tower_share_discount1[0],
                                        'house_share_discount1' => $house_share_discount1[0],
                                        'support_share_discount1' => $support_share_discount1[0],
                                        'maintain_share_discount1' => $maintain_share_discount1[0],
                                        'tower_share_discount_other' => $tower_share_discount_other[0],
                                        'house_share_discount_other' => $house_share_discount_other[0],
                                        'support_share_discount_other' => $support_share_discount_other[0],
                                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                        'fee_tower_discounted' => $fee_tower_discounted,
                                        'fee_house_discounted' => $fee_house_discounted,
                                        'fee_support_discounted' => $fee_support_discounted,
                                        'fee_maintain_discounted' => $fee_maintain_discounted,
                                        'fee_site' => $fee_site[0],
                                        'site_share_discount' => $site_share_discount[0],
                                        'fee_site_discounted' => $fee_site_discounted,
                                        'fee_import' => $fee_import[0],
                                        'import_share_discount' => $import_share_discount[0],
                                        'fee_import_discounted' => $fee_import_discounted,
                                        'is_valid' => 1,
                                        'effective_date' => $infoSites[$i][33],
                                        'region_name' => $infoSites[$i][0],
                                        'region_id' => transRegion($infoSites[$i][1])
                                    ]);
                            }
                        } else {
                            $sysNum = $infoSites[$i][9];
                            $sysHeight1 = transSysHeight($infoSites[$i][10]);
                            $sysHeight2 = transSysHeight($infoSites[$i][11]);
                            $sysHeight3 = transSysHeight($infoSites[$i][12]);
                            $sysHeight4 = transSysHeight($infoSites[$i][13]);
                            $sysHeight5 = transSysHeight($infoSites[$i][14]);
                            if ($sysNum == '1') {
                                $sysHeight2 = null;
                                $sysHeight3 = null;
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '2') {
                                $sysHeight3 = null;
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '3') {
                                $sysHeight4 = null;
                                $sysHeight5 = null;
                            }
                            if ($sysNum == '4') {
                                $sysHeight5 = null;
                            }
                            $feeWlan = $infoSites[$i][27];
                            $feeMicwav = $infoSites[$i][28];
                            $feeAdd = $infoSites[$i][29];
                            $feeBat = $infoSites[$i][30];
                            $feeBbu = $infoSites[$i][31];
                            if ($sysHeight1 != null) {
                                $fee_tower1 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight1)
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_tower');
                                $fee_house1 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_house');
                                $fee_support1 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_support');
                                $fee_maintain1 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_maintain');
                                $tower_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][18])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $house_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][17])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $support_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][19])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $maintain_share_discount1 = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][20])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                            } else {
                                $fee_tower1 = 0;
                                $fee_house1 = 0;
                                $fee_support1 = 0;
                                $fee_maintain1 = 0;
                                $tower_share_discount1 = null;
                                $house_share_discount1 = null;
                                $support_share_discount1 = null;
                                $maintain_share_discount1 = null;
                            }
                            if ($sysHeight2 != null) {
                                $fee_tower2 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight2)
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_tower');
                                $fee_house2 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_house');
                                $fee_support2 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_support');
                                $fee_maintain2 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_maintain');

                            } else {
                                $fee_tower2 = 0;
                                $fee_house2 = 0;
                                $fee_support2 = 0;
                                $fee_maintain2 = 0;
                            }
                            if ($sysHeight3 != null) {
                                $fee_tower3 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight3)
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_tower');
                                $fee_house3 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_house');
                                $fee_support3 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_support');
                                $fee_maintain3 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower3 = 0;
                                $fee_house3 = 0;
                                $fee_support3 = 0;
                                $fee_maintain3 = 0;
                            }
                            if ($sysHeight4 != null) {
                                $fee_tower4 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight4)
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_tower');
                                $fee_house4 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_house');
                                $fee_support4 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_support');
                                $fee_maintain4 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower4 = 0;
                                $fee_house4 = 0;
                                $fee_support4 = 0;
                                $fee_maintain4 = 0;
                            }
                            if ($sysHeight5 != null) {
                                $fee_tower5 = DB::table('fee_tower_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('sys_height', $sysHeight5)
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_tower');
                                $fee_house5 = DB::table('fee_house_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_house');
                                $fee_support5 = DB::table('fee_support_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_support');
                                $fee_maintain5 = DB::table('fee_maintain_std')
                                    ->where('tower_type', transTowerType($infoSites[$i][8]))
                                    ->where('product_type', transProductType($infoSites[$i][5]))
                                    ->where('is_new_tower', 0)
                                    ->pluck('fee_maintain');
                            } else {
                                $fee_tower5 = 0;
                                $fee_house5 = 0;
                                $fee_support5 = 0;
                                $fee_maintain5 = 0;
                            }
                            if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                                $tower_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][18])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $house_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][17])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $support_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][19])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                                $maintain_share_discount_other = DB::table('share_discount_std')
                                    ->where('is_new_tower', 0)
                                    ->where('share_num', $infoSites[$i][20])
                                    ->where('user_type', transUserType($infoSites[$i][25]))
                                    ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                    ->pluck('discount_basic');
                            } else {
                                $tower_share_discount_other = null;
                                $house_share_discount_other = null;
                                $support_share_discount_other = null;
                                $maintain_share_discount_other = null;
                            }

                            $fee_site = $infoSites[$i][32];
                            $fee_import = 0;

                            $site_share_discount = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][21])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_site');
                            $import_share_discount = DB::table('share_discount_std')
                                ->where('is_new_tower', 0)
                                ->where('share_num', $infoSites[$i][22])
                                ->where('user_type', transUserType($infoSites[$i][25]))
                                ->where('is_newly_added', transIsNewlyAdded($infoSites[$i][7]))
                                ->pluck('discount_import');
                            $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                                ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                            $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                                ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                            $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                                ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                            $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                                ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                            $fee_site_discounted = $fee_site * $site_share_discount[0];
                            $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
                            $site_price = DB::table('fee_out_site_price')
                                ->where('site_code', $infoSites[$i][3])
                                ->where('is_valid', 1)
                                ->get();
                            if (empty($site_price)) {
                                $insSitePrice = DB::table('fee_out_site_price')
                                    ->insert([
                                        'site_code' => $infoSites[$i][3],
                                        'fee_tower1' => $fee_tower1[0],
                                        'fee_house1' => $fee_house1[0],
                                        'fee_support1' => $fee_support1[0],
                                        'fee_maintain1' => $fee_maintain1[0],
                                        'fee_tower2' => $fee_tower2[0] * 0.3,
                                        'fee_house2' => $fee_house2[0] * 0.3,
                                        'fee_support2' => $fee_support2[0] * 0.3,
                                        'fee_maintain2' => $fee_maintain2[0] * 0.3,
                                        'fee_tower3' => $fee_tower3[0] * 0.3,
                                        'fee_house3' => $fee_house3[0] * 0.3,
                                        'fee_support3' => $fee_support3[0] * 0.3,
                                        'fee_maintain3' => $fee_maintain3[0] * 0.3,
                                        'fee_tower4' => $fee_tower4[0] * 0.3,
                                        'fee_house4' => $fee_house4[0] * 0.3,
                                        'fee_support4' => $fee_support4[0] * 0.3,
                                        'fee_maintain4' => $fee_maintain4[0] * 0.3,
                                        'fee_tower5' => $fee_tower5[0] * 0.3,
                                        'fee_house5' => $fee_house5[0] * 0.3,
                                        'fee_support5' => $fee_support5[0] * 0.3,
                                        'fee_maintain5' => $fee_maintain5[0] * 0.3,
                                        'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                                        'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                                        'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                                        'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                                        'fee_wlan' => $feeWlan,
                                        'fee_microwave' => $feeMicwav,
                                        'fee_add' => $feeAdd,
                                        'fee_battery' => $feeBat,
                                        'fee_bbu' => $feeBbu,
                                        'tower_share_discount1' => $tower_share_discount1[0],
                                        'house_share_discount1' => $house_share_discount1[0],
                                        'support_share_discount1' => $support_share_discount1[0],
                                        'maintain_share_discount1' => $maintain_share_discount1[0],
                                        'tower_share_discount_other' => $tower_share_discount_other[0],
                                        'house_share_discount_other' => $house_share_discount_other[0],
                                        'support_share_discount_other' => $support_share_discount_other[0],
                                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                        'fee_tower_discounted' => $fee_tower_discounted,
                                        'fee_house_discounted' => $fee_house_discounted,
                                        'fee_support_discounted' => $fee_support_discounted,
                                        'fee_maintain_discounted' => $fee_maintain_discounted,
                                        'fee_site' => $fee_site,
                                        'site_share_discount' => $site_share_discount[0],
                                        'fee_site_discounted' => $fee_site_discounted,
                                        'fee_import' => $fee_import[0],
                                        'import_share_discount' => $import_share_discount[0],
                                        'fee_import_discounted' => $fee_import_discounted,
                                        'is_valid' => 1,
                                        'effective_date' => $infoSites[$i][33],
                                        'region_name' => $infoSites[$i][0],
                                        'region_id' => transRegion($infoSites[$i][1])
                                    ]);
                            } else {
                                $updSitePrice = DB::table('fee_out_site_price')
                                    ->where('site_code', $infoSites[$i][3])
                                    ->where('is_valid', 1)
                                    ->update([
                                        'is_valid' => 0,
                                    ]);
                                $insSitePrice = DB::table('fee_out_site_price')
                                    ->insert([
                                        'site_code' => $infoSites[$i][3],
                                        'fee_tower1' => $fee_tower1[0],
                                        'fee_house1' => $fee_house1[0],
                                        'fee_support1' => $fee_support1[0],
                                        'fee_maintain1' => $fee_maintain1[0],
                                        'fee_tower2' => $fee_tower2[0],
                                        'fee_house2' => $fee_house2[0],
                                        'fee_support2' => $fee_support2[0],
                                        'fee_maintain2' => $fee_maintain2[0],
                                        'fee_tower3' => $fee_tower3[0],
                                        'fee_house3' => $fee_house3[0],
                                        'fee_support3' => $fee_support3[0],
                                        'fee_maintain3' => $fee_maintain3[0],
                                        'fee_tower4' => $fee_tower4[0],
                                        'fee_house4' => $fee_house4[0],
                                        'fee_support4' => $fee_support4[0],
                                        'fee_maintain4' => $fee_maintain4[0],
                                        'fee_tower5' => $fee_tower5[0],
                                        'fee_house5' => $fee_house5[0],
                                        'fee_support5' => $fee_support5[0],
                                        'fee_maintain5' => $fee_maintain5[0],
                                        'fee_tower' => $fee_tower1[0] + $fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0],
                                        'fee_house' => $fee_house1[0] + $fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house4[0],
                                        'fee_support' => $fee_support1[0] + $fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0],
                                        'fee_maintain' => $fee_maintain1[0] + $fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0],
                                        'fee_wlan' => $feeWlan,
                                        'fee_microwave' => $feeMicwav,
                                        'fee_add' => $feeAdd,
                                        'fee_battery' => $feeBat,
                                        'fee_bbu' => $feeBbu,
                                        'tower_share_discount1' => $tower_share_discount1[0],
                                        'house_share_discount1' => $house_share_discount1[0],
                                        'support_share_discount1' => $support_share_discount1[0],
                                        'maintain_share_discount1' => $maintain_share_discount1[0],
                                        'tower_share_discount_other' => $tower_share_discount_other[0],
                                        'house_share_discount_other' => $house_share_discount_other[0],
                                        'support_share_discount_other' => $support_share_discount_other[0],
                                        'maintain_share_discount_other' => $maintain_share_discount_other[0],
                                        'fee_tower_discounted' => $fee_tower_discounted,
                                        'fee_house_discounted' => $fee_house_discounted,
                                        'fee_support_discounted' => $fee_support_discounted,
                                        'fee_maintain_discounted' => $fee_maintain_discounted,
                                        'fee_site' => $fee_site[0],
                                        'site_share_discount' => $site_share_discount[0],
                                        'fee_site_discounted' => $fee_site_discounted,
                                        'fee_import' => $fee_import[0],
                                        'import_share_discount' => $import_share_discount[0],
                                        'fee_import_discounted' => $fee_import_discounted,
                                        'is_valid' => 1,
                                        'effective_date' => $infoSites[$i][33],
                                        'region_name' => $infoSites[$i][0],
                                        'region_id' => transRegion($infoSites[$i][1])
                                    ]);
                            }
                        }


                    } else {
                        DB::table('import_site_exception')
                            ->insert([
                                'site_code' => $infoSites[$i][3],
                                'region_name' => $infoSites[$i][0],
                                'region_id' => transRegion($infoSites[$i][1]),
                                'product_type' => transProductType($infoSites[$i][5]),
                                'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                                'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                                'tower_type' => transTowerType($infoSites[$i][8]),
                                'sys_num' => $infoSites[$i][9],
                                'sys1_height' => transSysHeight($infoSites[$i][10]),
                                'sys1_height' => transSysHeight($infoSites[$i][11]),
                                'sys3_height' => transSysHeight($infoSites[$i][12]),
                                'sys4_height' => transSysHeight($infoSites[$i][13]),
                                'sys5_height' => transSysHeight($infoSites[$i][14]),
                                'land_form' => transLandForm($infoSites[$i][15]),
                                'is_co_opetition' => transIsCoOpetition($infoSites[$i][16]),
                                'share_num_house' => $infoSites[$i][17],
                                'share_num_tower' => $infoSites[$i][18],
                                'share_num_support' => $infoSites[$i][19],
                                'share_num_maintain' => $infoSites[$i][20],
                                'share_num_site' => $infoSites[$i][21],
                                'share_num_import' => $infoSites[$i][22],
                                'site_district_type' => transSiteDistType($infoSites[$i][23]),
                                'is_rru_away' => transIsRRUAway($infoSites[$i][24]),
                                'user_type' => transUserType($infoSites[$i][25]),
                                'elec_introduced_type' => transElecType($infoSites[$i][26]),
                                'site_info_id' => $origInfoSiteID[0],
                                'check_status' => 0
                            ]);
                    }
                }
            }
        }

    }

    public
    function updateInfoSiteByArray(Array $infoSites, $area_level)
    {
        if ($area_level == 'admin' || $area_level == '湖北省') {
            for ($i = 1; $i < count($infoSites); $i++) {
                $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][3])->where('is_valid', 1)->get();
                if (empty($infoSite)) {
                    DB::table('site_info')->insert([
                        'site_code' => $infoSites[$i][3],
                        'region_name' => $infoSites[$i][0],
                        'product_type' => transProductType($infoSites[$i][5]),
                        'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                        'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                        'tower_type' => transTowerType($infoSites[$i][8]),
                        'sys_num' => $infoSites[$i][9],
                        'sys1_height' => transSysHeight($infoSites[$i][10]),
                        'land_form' => transSysHeight($infoSites[$i][14]),
                        'share_num' => transSysHeight($infoSites[$i][12]),
                        'is_co_opetition' => transSysHeight($infoSites[$i][13]),
                        'site_district_type' => transSysHeight($infoSites[$i][14]),
                        'is_rru_away' => transLandForm($infoSites[$i][15]),
                        'user_type' => transIsCoOpetition($infoSites[$i][16]),
                        'elec_introduced_type' => $infoSites[$i][17],
                        'is_valid' => 1,
                    ]);
                } else {
                    DB::table('site_info')->where('id', $infoSite[0]->id)->update([
                        'is_valid' => 0
                    ]);
                    DB::table('site_info')->insert([
                        'site_code' => $infoSites[$i][3],
                        'region_name' => $infoSites[$i][0],
                        'product_type' => transProductType($infoSites[$i][5]),
                        'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                        'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                        'tower_type' => transTowerType($infoSites[$i][8]),
                        'sys_num' => $infoSites[$i][9],
                        'sys1_height' => transSysHeight($infoSites[$i][10]),
                        'land_form' => transSysHeight($infoSites[$i][14]),
                        'share_num' => transSysHeight($infoSites[$i][12]),
                        'is_co_opetition' => transSysHeight($infoSites[$i][13]),
                        'site_district_type' => transSysHeight($infoSites[$i][14]),
                        'is_rru_away' => transLandForm($infoSites[$i][15]),
                        'user_type' => transIsCoOpetition($infoSites[$i][16]),
                        'elec_introduced_type' => $infoSites[$i][17],
                        'is_valid' => 1,
                    ]);
                }

            }
        } else {
            for ($i = 1; $i < count($infoSites); $i++) {
                if ($infoSites[$i][0] == $area_level) {
                    $infoSite = DB::table('site_info')->where('site_code', $infoSites[$i][3])->where('is_valid', 1)->where('region_name', $area_level)->get();
                    if (empty($infoSite)) {
                        DB::table('site_info')->insert([
                            'site_code' => $infoSites[$i][3],
                            'region_name' => $infoSites[$i][0],
                            'product_type' => transProductType($infoSites[$i][5]),
                            'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                            'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                            'tower_type' => transTowerType($infoSites[$i][8]),
                            'sys_num' => $infoSites[$i][9],
                            'sys1_height' => transSysHeight($infoSites[$i][10]),
                            'land_form' => transSysHeight($infoSites[$i][14]),
                            'share_num' => transSysHeight($infoSites[$i][12]),
                            'is_co_opetition' => transSysHeight($infoSites[$i][13]),
                            'site_district_type' => transSysHeight($infoSites[$i][14]),
                            'is_rru_away' => transLandForm($infoSites[$i][15]),
                            'user_type' => transIsCoOpetition($infoSites[$i][16]),
                            'elec_introduced_type' => $infoSites[$i][17],
                            'is_valid' => 1,
                        ]);
                    } else {
                        DB::table('site_info')->where('id', $infoSite[0]->id)->update([
                            'is_valid' => 0
                        ]);
                        DB::table('site_info')->insert([
                            'site_code' => $infoSites[$i][3],
                            'region_name' => $infoSites[$i][0],
                            'product_type' => transProductType($infoSites[$i][5]),
                            'is_new_tower' => transIsNewTower($infoSites[$i][6]),
                            'is_newly_added' => transIsNewlyAdded($infoSites[$i][7]),
                            'tower_type' => transTowerType($infoSites[$i][8]),
                            'sys_num' => $infoSites[$i][9],
                            'sys1_height' => transSysHeight($infoSites[$i][10]),
                            'land_form' => transSysHeight($infoSites[$i][14]),
                            'share_num' => transSysHeight($infoSites[$i][12]),
                            'is_co_opetition' => transSysHeight($infoSites[$i][13]),
                            'site_district_type' => transSysHeight($infoSites[$i][14]),
                            'is_rru_away' => transLandForm($infoSites[$i][15]),
                            'user_type' => transIsCoOpetition($infoSites[$i][16]),
                            'elec_introduced_type' => $infoSites[$i][17],
                            'is_valid' => 1,
                        ]);
                    }
                }

            }
        }

    }

    public
    function addSiteMonthlyRent(Request $request)
    {
        $code = $this->searchCode($request);

        //根据code查询服务费用
        $site_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('site_fee');
        $elec_introduced_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('elec_introduced_fee');
        $sys_basic_fee = DB::table('dict_site_std_rent')
            ->where('code', '=', $code)
            ->pluck('basic_fee');

        //插入服务费用信息
        $bool2 = DB::table('fee_site_monthly_rent')->insert(
            ['site_code' => $request->get('siteCode'),
                'site_fee' => $site_fee[0],
                'sys1_basic_fee' => $sys_basic_fee[0],
                'elec_introduced_fee' => $elec_introduced_fee[0]]
        );
    }

    public
    function searchInfoSiteById($id)
    {
        $query = DB::table('site_info')
            ->where('id', $id)
            ->where('is_valid', 1);
        return $query->get();
    }

    public
    function searchInfoSite($region, $stationCode = '')
    {
        if ($region != '湖北省') {
            $query = DB::table('site_info')
                ->where('site_info.region_id', transRegion($region))
                ->where('site_info.is_valid', 1)
                ->where('site_info.site_code', 'like', '%' . $stationCode . '%')
                ->join('fee_out_site_price', 'site_info.site_code', '=', 'fee_out_site_price.site_code')
                ->where('fee_out_site_price.is_valid', 1)
                ->select('site_info.*', 'fee_out_site_price.*');
        } else {
            $query = DB::table('site_info')
                ->where('site_info.is_valid', 1)
                ->where('site_info.site_code', 'like', '%' . $stationCode . '%')
                ->join('fee_out_site_price', 'site_info.site_code', '=', 'fee_out_site_price.site_code')
                ->where('fee_out_site_price.is_valid', 1)
                ->select('site_info.*', 'fee_out_site_price.*');
        }
        return $query;
    }

    public
    function updateDB(Request $request)
    {
        $fee_tower1 = 1;
        $fee_tower2 = 1;
        $fee_tower3 = 1;
        $fee_tower4 = 1;
        $fee_tower5 = 1;
        $sysHeight1 = $request->get('sysHeight1');
        $sysHeight2 = $request->get('sysHeight2');
        $sysHeight3 = $request->get('sysHeight3');
        $sysHeight4 = $request->get('sysHeight4');
        $sysHeight5 = $request->get('sysHeight5');
        if ($sysHeight1 != '无') {
            $fee_tower1 = DB::table('fee_tower_std')
                ->where('tower_type', transTowerType($request->get('towerType')))
                ->where('sys_height', $sysHeight1)
                ->where('is_new_tower', 1)
                ->pluck('fee_tower');
        }
        if ($sysHeight2 != '无') {
            $fee_tower2 = DB::table('fee_tower_std')
                ->where('tower_type', transTowerType($request->get('towerType')))
                ->where('sys_height', $sysHeight2)
                ->where('is_new_tower', 1)
                ->pluck('fee_tower');
        }
        if ($sysHeight3 != '无') {
            $fee_tower3 = DB::table('fee_tower_std')
                ->where('tower_type', transTowerType($request->get('towerType')))
                ->where('sys_height', $sysHeight3)
                ->where('is_new_tower', 1)
                ->pluck('fee_tower');
        }
        if ($sysHeight4 != '无') {
            $fee_tower4 = DB::table('fee_tower_std')
                ->where('tower_type', transTowerType($request->get('towerType')))
                ->where('sys_height', $sysHeight4)
                ->where('is_new_tower', 1)
                ->pluck('fee_tower');
        }
        if ($sysHeight5 != '无') {
            $fee_tower5 = DB::table('fee_tower_std')
                ->where('tower_type', transTowerType($request->get('towerType')))
                ->where('sys_height', $sysHeight5)
                ->where('is_new_tower', 1)
                ->pluck('fee_tower');
        }
        if (empty($fee_tower1)) {
            return 'error1';
        }
        if (empty($fee_tower2)) {
            return 'error2';
        }
        if (empty($fee_tower3)) {
            return 'error3';
        }
        if (empty($fee_tower4)) {
            return 'error4';
        }
        if (empty($fee_tower5)) {
            return 'error5';
        }
        $sysNum = $request->get('sysNum');

        if ($sysNum == '1') {
            $sysHeight2 = null;
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '2') {
            $sysHeight3 = null;
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '3') {
            $sysHeight4 = null;
            $sysHeight5 = null;
        }
        if ($sysNum == '4') {
            $sysHeight5 = null;
        }
        $fee_tower1 = DB::table('fee_tower_std')
            ->where('tower_type', transTowerType($request->get('towerType')))
            ->where('sys_height', $sysHeight1)
            ->where('is_new_tower', 1)
            ->pluck('fee_tower');
        if ($fee_tower1) {
            $establishedTime = DB::table('site_info')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_valid', 1)
                ->pluck('established_time');
            $updSiteInfo = DB::table('site_info')
                ->where('site_code', $request->get('siteCode'))
                ->where('is_valid', 1)
                ->update(['is_valid' => 0
                ]);


            if ($request->get('isNewTower') == '是') {
                $insSiteInfo = DB::table('site_info')->insert(
                    ['site_code' => $request->get('siteCode'),
                        'region_name' => $request->get('region'),
                        'product_type' => transProductType($request->get('productType')),
                        'share_num_tower' => transShareType($request->get('shareType_tower')),
                        'share_num_house' => transShareType($request->get('shareType_house')),
                        'share_num_support' => transShareType($request->get('shareType_supporting')),
                        'share_num_maintain' => transShareType($request->get('shareType_maintainence')),
                        'share_num_site' => transShareType($request->get('shareType_site')),
                        'share_num_import' => transShareType($request->get('shareType_import')),
                        'is_new_tower' => '是',
                        'is_newly_added' => '否',
                        'established_time' => $establishedTime[0],
                        'effective_date' => $request->get('modifyTime'),
                        'is_rru_away' => $request->get('rruAway'),
                        'sys_num' => $request->get('sysNum'),
                        'sys1_height' => transSysHeight($sysHeight1),
                        'sys2_height' => transSysHeight($sysHeight2),
                        'sys3_height' => transSysHeight($sysHeight3),
                        'sys4_height' => transSysHeight($sysHeight4),
                        'sys5_height' => transSysHeight($sysHeight5),
                        'is_co_opetition' => transIsCoOpetition($request->get('isCoOpetition')),
                        'is_valid' => 1,
                        'site_district_type' => $request->get('siteDistType'),
                        'tower_type' => transTowerType($request->get('towerType')),
                        'land_form' => transLandForm($request->get('landForm')),
                        'user_type' => transUserType($request->get('userType')),
                        'elec_introduced_type' => $request->get('elecIntroType'),

                    ]);

                $feeWlan = $request->get('feeWlan');
                $feeMicwav = $request->get('feeMicwav');
                $feeAdd = $request->get('feeAdd');
                $feeBat = $request->get('feeBat');
                $feeBbu = $request->get('feeBbu');
                if ($sysHeight1 != null) {
                    $fee_tower1 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight1)
                        ->where('is_new_tower', 1)
                        ->pluck('fee_tower');
                    $fee_house1 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_house');
                    $fee_support1 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_support');
                    $fee_maintain1 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_maintain');
                    $tower_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_tower')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $house_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_house')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $support_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_supporting')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $maintain_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_maintainence')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                } else {
                    $fee_tower1 = 0;
                    $fee_house1 = 0;
                    $fee_support1 = 0;
                    $fee_maintain1 = 0;
                    $tower_share_discount1 = null;
                    $house_share_discount1 = null;
                    $support_share_discount1 = null;
                    $maintain_share_discount1 = null;
                }
                if ($sysHeight2 != null) {
                    $fee_tower2 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight2)
                        ->where('is_new_tower', 1)
                        ->pluck('fee_tower');
                    $fee_house2 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_house');
                    $fee_support2 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_support');
                    $fee_maintain2 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_maintain');

                } else {
                    $fee_tower2 = 0;
                    $fee_house2 = 0;
                    $fee_support2 = 0;
                    $fee_maintain2 = 0;
                }
                if ($sysHeight3 != null) {
                    $fee_tower3 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight3)
                        ->where('is_new_tower', 1)
                        ->pluck('fee_tower');
                    $fee_house3 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_house');
                    $fee_support3 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_support');
                    $fee_maintain3 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower3 = 0;
                    $fee_house3 = 0;
                    $fee_support3 = 0;
                    $fee_maintain3 = 0;
                }
                if ($sysHeight4 != null) {
                    $fee_tower4 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight4)
                        ->where('is_new_tower', 1)
                        ->pluck('fee_tower');
                    $fee_house4 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_house');
                    $fee_support4 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_support');
                    $fee_maintain4 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower4 = 0;
                    $fee_house4 = 0;
                    $fee_support4 = 0;
                    $fee_maintain4 = 0;
                }
                if ($sysHeight5 != null) {
                    $fee_tower5 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight5)
                        ->where('is_new_tower', 1)
                        ->pluck('fee_tower');
                    $fee_house5 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_house');
                    $fee_support5 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_support');
                    $fee_maintain5 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 1)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower5 = 0;
                    $fee_house5 = 0;
                    $fee_support5 = 0;
                    $fee_maintain5 = 0;
                }
                if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                    $tower_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_tower')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $house_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_house')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $support_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_supporting')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                    $maintain_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 1)
                        ->where('share_num', transShareType($request->get('shareType_maintainence')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', 0)
                        ->pluck('discount_basic');
                } else {
                    $tower_share_discount_other = null;
                    $house_share_discount_other = null;
                    $support_share_discount_other = null;
                    $maintain_share_discount_other = null;
                }

                $fee_site = DB::table('fee_site_std')
                    ->where('region_name', $request->get('region'))
                    ->where('site_district_type', $request->get('siteDistType'))
                    ->where('is_rru_away', $request->get('rruAway'))
                    ->pluck('fee_site');
                $fee_import = DB::table('fee_import_std')
                    ->where('region_name', $request->get('region'))
                    ->where('elec_introduced_type', $request->get('elecIntroType'))
                    ->pluck('fee_import');

                $site_share_discount = DB::table('share_discount_std')
                    ->where('is_new_tower', 1)
                    ->where('share_num', transShareType($request->get('shareType_site')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 0)
                    ->pluck('discount_site');
                $import_share_discount = DB::table('share_discount_std')
                    ->where('is_new_tower', 1)
                    ->where('share_num', transShareType($request->get('shareType_import')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', 0)
                    ->pluck('discount_import');

                $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                    ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                    ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                    ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                    ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                $fee_site_discounted = $fee_site[0] * $site_share_discount[0];
                $fee_import_discounted = $fee_import[0] * $import_share_discount[0];
                $site_price = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_valid', 1)
                    ->get();
                if (empty($site_price)) {
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tower1' => $fee_tower1[0],
                            'fee_house1' => $fee_house1[0],
                            'fee_support1' => $fee_support1[0],
                            'fee_maintain1' => $fee_maintain1[0],
                            'fee_tower2' => $fee_tower2[0] * 0.3,
                            'fee_house2' => $fee_house2[0] * 0.3,
                            'fee_support2' => $fee_support2[0] * 0.3,
                            'fee_maintain2' => $fee_maintain2[0] * 0.3,
                            'fee_tower3' => $fee_tower3[0] * 0.3,
                            'fee_house3' => $fee_house3[0] * 0.3,
                            'fee_support3' => $fee_support3[0] * 0.3,
                            'fee_maintain3' => $fee_maintain3[0] * 0.3,
                            'fee_tower4' => $fee_tower4[0] * 0.3,
                            'fee_house4' => $fee_house4[0] * 0.3,
                            'fee_support4' => $fee_support4[0] * 0.3,
                            'fee_maintain4' => $fee_maintain4[0] * 0.3,
                            'fee_tower5' => $fee_tower5[0] * 0.3,
                            'fee_house5' => $fee_house5[0] * 0.3,
                            'fee_support5' => $fee_support5[0] * 0.3,
                            'fee_maintain5' => $fee_maintain5[0] * 0.3,
                            'fee_wlan' => $feeWlan,
                            'fee_microwave' => $feeMicwav,
                            'fee_add' => $feeAdd,
                            'fee_battery' => $feeBat,
                            'fee_bbu' => $feeBbu,
                            'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                            'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                            'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                            'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                            'tower_share_discount1' => $tower_share_discount1[0],
                            'house_share_discount1' => $house_share_discount1[0],
                            'support_share_discount1' => $support_share_discount1[0],
                            'maintain_share_discount1' => $maintain_share_discount1[0],
                            'tower_share_discount_other' => $tower_share_discount_other[0],
                            'house_share_discount_other' => $house_share_discount_other[0],
                            'support_share_discount_other' => $support_share_discount_other[0],
                            'maintain_share_discount_other' => $maintain_share_discount_other[0],
                            'fee_tower_discounted' => $fee_tower_discounted,
                            'fee_house_discounted' => $fee_house_discounted,
                            'fee_support_discounted' => $fee_support_discounted,
                            'fee_maintain_discounted' => $fee_maintain_discounted,
                            'fee_site' => $fee_site[0],
                            'site_share_discount' => $site_share_discount[0],
                            'fee_site_discounted' => $fee_site_discounted,
                            'fee_import' => $fee_import[0],
                            'import_share_discount' => $import_share_discount[0],
                            'fee_import_discounted' => $fee_import_discounted,
                            'is_valid' => 1,
                            'effective_date' => $request->get('modifyTime'),
                            'region_name' => $request->get('region')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, false, $insSitePrice);
                } else {
                    $updSitePrice = DB::table('fee_out_site_price')
                        ->where('site_code', $request->get('siteCode'))
                        ->where('is_valid', 1)
                        ->update([
                            'is_valid' => 0,
//                        'updated_at' => date('Y-m-d h:i:s',time())
                        ]);
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tower1' => $fee_tower1[0],
                            'fee_house1' => $fee_house1[0],
                            'fee_support1' => $fee_support1[0],
                            'fee_maintain1' => $fee_maintain1[0],
                            'fee_tower2' => $fee_tower2[0] * 0.3,
                            'fee_house2' => $fee_house2[0] * 0.3,
                            'fee_support2' => $fee_support2[0] * 0.3,
                            'fee_maintain2' => $fee_maintain2[0] * 0.3,
                            'fee_tower3' => $fee_tower3[0] * 0.3,
                            'fee_house3' => $fee_house3[0] * 0.3,
                            'fee_support3' => $fee_support3[0] * 0.3,
                            'fee_maintain3' => $fee_maintain3[0] * 0.3,
                            'fee_tower4' => $fee_tower4[0] * 0.3,
                            'fee_house4' => $fee_house4[0] * 0.3,
                            'fee_support4' => $fee_support4[0] * 0.3,
                            'fee_maintain4' => $fee_maintain4[0] * 0.3,
                            'fee_tower5' => $fee_tower5[0] * 0.3,
                            'fee_house5' => $fee_house5[0] * 0.3,
                            'fee_support5' => $fee_support5[0] * 0.3,
                            'fee_maintain5' => $fee_maintain5[0] * 0.3,
                            'fee_wlan' => $feeWlan,
                            'fee_microwave' => $feeMicwav,
                            'fee_add' => $feeAdd,
                            'fee_battery' => $feeBat,
                            'fee_bbu' => $feeBbu,
                            'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                            'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                            'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                            'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                            'tower_share_discount1' => $tower_share_discount1[0],
                            'house_share_discount1' => $house_share_discount1[0],
                            'support_share_discount1' => $support_share_discount1[0],
                            'maintain_share_discount1' => $maintain_share_discount1[0],
                            'tower_share_discount_other' => $tower_share_discount_other[0],
                            'house_share_discount_other' => $house_share_discount_other[0],
                            'support_share_discount_other' => $support_share_discount_other[0],
                            'maintain_share_discount_other' => $maintain_share_discount_other[0],
                            'fee_tower_discounted' => $fee_tower_discounted,
                            'fee_house_discounted' => $fee_house_discounted,
                            'fee_support_discounted' => $fee_support_discounted,
                            'fee_maintain_discounted' => $fee_maintain_discounted,
                            'fee_site' => $fee_site[0],
                            'site_share_discount' => $site_share_discount[0],
                            'fee_site_discounted' => $fee_site_discounted,
                            'fee_import' => $fee_import[0],
                            'import_share_discount' => $import_share_discount[0],
                            'fee_import_discounted' => $fee_import_discounted,
                            'is_valid' => 1,
                            'effective_date' => $request->get('modifyTime'),
                            'region_name' => $request->get('region')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, $updSitePrice, $insSitePrice);
                }

            }
            if ($request->get('isNewTower') == '否') {
                $insSiteInfo = DB::table('site_info')->insert(
                    ['site_code' => $request->get('siteCode'),
                        'region_name' => $request->get('region'),
                        'product_type' => transProductType($request->get('productType')),
                        'share_num_tower' => transShareType($request->get('shareType_tower')),
                        'share_num_house' => transShareType($request->get('shareType_house')),
                        'share_num_support' => transShareType($request->get('shareType_supporting')),
                        'share_num_maintain' => transShareType($request->get('shareType_maintainence')),
                        'share_num_site' => transShareType($request->get('shareType_site')),
                        'share_num_import' => transShareType($request->get('shareType_import')),
                        'is_new_tower' => 0,
                        'is_newly_added' => transIsNewlyAdded($request->get('isNewlyAdded')),
                        'is_rru_away' => null,
                        'sys_num' => $request->get('sysNum'),
                        'sys1_height' => transSysHeight($sysHeight1),
                        'sys2_height' => transSysHeight($sysHeight2),
                        'sys3_height' => transSysHeight($sysHeight3),
                        'sys4_height' => transSysHeight($sysHeight4),
                        'sys5_height' => transSysHeight($sysHeight5),
                        'is_co_opetition' => transIsCoOpetition($request->get('isCoOpetition')),
                        'is_valid' => 1,
                        'site_district_type' => null,
                        'tower_type' => transTowerType($request->get('towerType')),
                        'land_form' => transLandForm($request->get('landForm')),
                        'user_type' => transUserType($request->get('userType')),
                        'elec_introduced_type' => null,
                        'established_time' => $establishedTime[0],
                        'effective_date' => $request->get('modifyTime'),

                    ]);
                if ($sysHeight1 != null) {
                    $fee_tower1 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight1)
                        ->where('is_new_tower', 0)
                        ->pluck('fee_tower');
                    $fee_house1 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_house');
                    $fee_support1 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_support');
                    $fee_maintain1 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_maintain');
                    $tower_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_tower')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $house_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_house')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $support_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_supporting')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $maintain_share_discount1 = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_maintainence')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                } else {
                    $fee_tower1 = 0;
                    $fee_house1 = 0;
                    $fee_support1 = 0;
                    $fee_maintain1 = 0;
                    $tower_share_discount1 = null;
                    $house_share_discount1 = null;
                    $support_share_discount1 = null;
                    $maintain_share_discount1 = null;
                }
                if ($sysHeight2 != null) {
                    $fee_tower2 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight2)
                        ->where('is_new_tower', 0)
                        ->pluck('fee_tower');
                    $fee_house2 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_house');
                    $fee_support2 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_support');
                    $fee_maintain2 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_maintain');

                } else {
                    $fee_tower2 = 0;
                    $fee_house2 = 0;
                    $fee_support2 = 0;
                    $fee_maintain2 = 0;
                }
                if ($sysHeight3 != null) {
                    $fee_tower3 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight3)
                        ->where('is_new_tower', 0)
                        ->pluck('fee_tower');
                    $fee_house3 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_house');
                    $fee_support3 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_support');
                    $fee_maintain3 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower3 = 0;
                    $fee_house3 = 0;
                    $fee_support3 = 0;
                    $fee_maintain3 = 0;
                }
                if ($sysHeight4 != null) {
                    $fee_tower4 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight4)
                        ->where('is_new_tower', 0)
                        ->pluck('fee_tower');
                    $fee_house4 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_house');
                    $fee_support4 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_support');
                    $fee_maintain4 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower4 = 0;
                    $fee_house4 = 0;
                    $fee_support4 = 0;
                    $fee_maintain4 = 0;
                }
                if ($sysHeight5 != null) {
                    $fee_tower5 = DB::table('fee_tower_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('sys_height', $sysHeight5)
                        ->where('is_new_tower', 0)
                        ->pluck('fee_tower');
                    $fee_house5 = DB::table('fee_house_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_house');
                    $fee_support5 = DB::table('fee_support_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_support');
                    $fee_maintain5 = DB::table('fee_maintain_std')
                        ->where('tower_type', transTowerType($request->get('towerType')))
                        ->where('product_type', transProductType($request->get('productType')))
                        ->where('is_new_tower', 0)
                        ->pluck('fee_maintain');
                } else {
                    $fee_tower5 = 0;
                    $fee_house5 = 0;
                    $fee_support5 = 0;
                    $fee_maintain5 = 0;
                }
                if ($sysHeight2 != null || $sysHeight3 != null || $sysHeight4 != null || $sysHeight5 != null) {
                    $tower_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_tower')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $house_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_house')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $support_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_supporting')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                    $maintain_share_discount_other = DB::table('share_discount_std')
                        ->where('is_new_tower', 0)
                        ->where('share_num', transShareType($request->get('shareType_maintainence')))
                        ->where('user_type', transUserType($request->get('userType')))
                        ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                        ->pluck('discount_basic');
                } else {
                    $tower_share_discount_other = null;
                    $house_share_discount_other = null;
                    $support_share_discount_other = null;
                    $maintain_share_discount_other = null;
                }

                $fee_site = $request->get('feeSiteOld');
                $fee_import = 0;

                $site_share_discount = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_site')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_site');
                $import_share_discount = DB::table('share_discount_std')
                    ->where('is_new_tower', 0)
                    ->where('share_num', transShareType($request->get('shareType_import')))
                    ->where('user_type', transUserType($request->get('userType')))
                    ->where('is_newly_added', transIsNewlyAdded($request->get('isNewlyAdded')))
                    ->pluck('discount_import');
                $fee_tower_discounted = $fee_tower1[0] * $tower_share_discount1[0] +
                    ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * $tower_share_discount_other[0] * 0.3;
                $fee_house_discounted = $fee_house1[0] * $house_share_discount1[0] +
                    ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * $house_share_discount_other[0] * 0.3;
                $fee_support_discounted = $fee_support1[0] * $support_share_discount1[0] +
                    ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * $support_share_discount_other[0] * 0.3;
                $fee_maintain_discounted = $fee_maintain1[0] * $maintain_share_discount1[0] +
                    ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * $maintain_share_discount_other[0] * 0.3;
                $fee_site_discounted = $fee_site * $site_share_discount[0];
                $fee_import_discounted = $fee_import * $import_share_discount[0];
                $site_price = DB::table('fee_out_site_price')
                    ->where('site_code', $request->get('siteCode'))
                    ->where('is_valid', 1)
                    ->get();
                if (empty($site_price)) {
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tower1' => $fee_tower1[0],
                            'fee_house1' => $fee_house1[0],
                            'fee_support1' => $fee_support1[0],
                            'fee_maintain1' => $fee_maintain1[0],
                            'fee_tower2' => $fee_tower2[0] * 0.3,
                            'fee_house2' => $fee_house2[0] * 0.3,
                            'fee_support2' => $fee_support2[0] * 0.3,
                            'fee_maintain2' => $fee_maintain2[0] * 0.3,
                            'fee_tower3' => $fee_tower3[0] * 0.3,
                            'fee_house3' => $fee_house3[0] * 0.3,
                            'fee_support3' => $fee_support3[0] * 0.3,
                            'fee_maintain3' => $fee_maintain3[0] * 0.3,
                            'fee_tower4' => $fee_tower4[0] * 0.3,
                            'fee_house4' => $fee_house4[0] * 0.3,
                            'fee_support4' => $fee_support4[0] * 0.3,
                            'fee_maintain4' => $fee_maintain4[0] * 0.3,
                            'fee_tower5' => $fee_tower5[0] * 0.3,
                            'fee_house5' => $fee_house5[0] * 0.3,
                            'fee_support5' => $fee_support5[0] * 0.3,
                            'fee_maintain5' => $fee_maintain5[0] * 0.3,
                            'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                            'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                            'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                            'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                            'tower_share_discount1' => $tower_share_discount1[0],
                            'house_share_discount1' => $house_share_discount1[0],
                            'support_share_discount1' => $support_share_discount1[0],
                            'maintain_share_discount1' => $maintain_share_discount1[0],
                            'tower_share_discount_other' => $tower_share_discount_other[0],
                            'house_share_discount_other' => $house_share_discount_other[0],
                            'support_share_discount_other' => $support_share_discount_other[0],
                            'maintain_share_discount_other' => $maintain_share_discount_other[0],
                            'fee_tower_discounted' => $fee_tower_discounted,
                            'fee_house_discounted' => $fee_house_discounted,
                            'fee_support_discounted' => $fee_support_discounted,
                            'fee_maintain_discounted' => $fee_maintain_discounted,
                            'fee_site' => $fee_site,
                            'site_share_discount' => $site_share_discount[0],
                            'fee_site_discounted' => $fee_site_discounted,
                            'fee_import' => $fee_import,
                            'import_share_discount' => $import_share_discount[0],
                            'fee_import_discounted' => $fee_import_discounted,
                            'is_valid' => 1,
                            'effective_date' => $request->get('modifyTime'),
                            'region_name' => $request->get('region')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, false, $insSitePrice);
                } else {
                    $updSitePrice = DB::table('fee_out_site_price')
                        ->where('site_code', $request->get('siteCode'))
                        ->where('is_valid', 1)
                        ->update([
                            'is_valid' => 0,
//                        'updated_at' => date('Y-m-d h:i:s',time())
                        ]);
                    $insSitePrice = DB::table('fee_out_site_price')
                        ->insert([
                            'site_code' => $request->get('siteCode'),
                            'fee_tower1' => $fee_tower1[0],
                            'fee_house1' => $fee_house1[0],
                            'fee_support1' => $fee_support1[0],
                            'fee_maintain1' => $fee_maintain1[0],
                            'fee_tower2' => $fee_tower2[0] * 0.3,
                            'fee_house2' => $fee_house2[0] * 0.3,
                            'fee_support2' => $fee_support2[0] * 0.3,
                            'fee_maintain2' => $fee_maintain2[0] * 0.3,
                            'fee_tower3' => $fee_tower3[0] * 0.3,
                            'fee_house3' => $fee_house3[0] * 0.3,
                            'fee_support3' => $fee_support3[0] * 0.3,
                            'fee_maintain3' => $fee_maintain3[0] * 0.3,
                            'fee_tower4' => $fee_tower4[0] * 0.3,
                            'fee_house4' => $fee_house4[0] * 0.3,
                            'fee_support4' => $fee_support4[0] * 0.3,
                            'fee_maintain4' => $fee_maintain4[0] * 0.3,
                            'fee_tower5' => $fee_tower5[0] * 0.3,
                            'fee_house5' => $fee_house5[0] * 0.3,
                            'fee_support5' => $fee_support5[0] * 0.3,
                            'fee_maintain5' => $fee_maintain5[0] * 0.3,
                            'fee_tower' => $fee_tower1[0] + ($fee_tower2[0] + $fee_tower3[0] + $fee_tower4[0] + $fee_tower5[0]) * 0.3,
                            'fee_house' => $fee_house1[0] + ($fee_house2[0] + $fee_house3[0] + $fee_house4[0] + $fee_house5[0]) * 0.3,
                            'fee_support' => $fee_support1[0] + ($fee_support2[0] + $fee_support3[0] + $fee_support4[0] + $fee_support5[0]) * 0.3,
                            'fee_maintain' => $fee_maintain1[0] + ($fee_maintain2[0] + $fee_maintain3[0] + $fee_maintain4[0] + $fee_maintain5[0]) * 0.3,
                            'tower_share_discount1' => $tower_share_discount1[0],
                            'house_share_discount1' => $house_share_discount1[0],
                            'support_share_discount1' => $support_share_discount1[0],
                            'maintain_share_discount1' => $maintain_share_discount1[0],
                            'tower_share_discount_other' => $tower_share_discount_other[0],
                            'house_share_discount_other' => $house_share_discount_other[0],
                            'support_share_discount_other' => $support_share_discount_other[0],
                            'maintain_share_discount_other' => $maintain_share_discount_other[0],
                            'fee_tower_discounted' => $fee_tower_discounted,
                            'fee_house_discounted' => $fee_house_discounted,
                            'fee_support_discounted' => $fee_support_discounted,
                            'fee_maintain_discounted' => $fee_maintain_discounted,
                            'fee_site' => $fee_site,
                            'site_share_discount' => $site_share_discount[0],
                            'fee_site_discounted' => $fee_site_discounted,
                            'fee_import' => $fee_import,
                            'import_share_discount' => $import_share_discount[0],
                            'fee_import_discounted' => $fee_import_discounted,
                            'is_valid' => 1,
                            'effective_date' => $request->get('modifyTime'),
                            'region_name' => $request->get('region')
                        ]);
                    return array($updSiteInfo, $insSiteInfo, $updSitePrice, $insSitePrice);
                }
            }
        } else {
            echo "<script language=javascript>alert('系统高度和铁塔类型不匹配！');history.back();</script>";
        }


    }

}

