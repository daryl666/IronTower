<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class IronTowerBillDetail extends Model
{
    protected $table = 'irontower_bill_detail';
    protected $guarded = ['id'];


    public function store($siteInfo)
    {
        dd($siteInfo[23]);
        $year = substr($siteInfo[0], 0, 4);
        $month = substr($siteInfo[0], 4, 2);
        $siteInfoDB = $this->firstOrNew(['month' => $year . '-' . $month, 'business_code' => $siteInfo[1]]);
        $siteInfoDB->month = $year . '-' . $month;
        $siteInfoDB->business_code = $siteInfo[1];
        $siteInfoDB->region_id = transRegion($siteInfo[3]);
        $siteInfoDB->region_name = $siteInfo[3];
        $siteInfoDB->site_name = $siteInfo[6];
        $siteInfoDB->site_code = $siteInfo[7];
        $siteInfoDB->req_code = $siteInfo[8];
        $siteInfoDB->established_time = $siteInfo[10];
        $siteInfoDB->tower_type = transTowerType($siteInfo[11]);
        $siteInfoDB->product_type = transProductType($siteInfo[12]);
        $siteInfoDB->fee_electricity = $siteInfo[13];
        $siteInfoDB->fee_gnr_allincharge = $siteInfo[15];
        $siteInfoDB->fee_add = $siteInfo[16];
        $siteInfoDB->fee_battery = $siteInfo[17];
        $siteInfoDB->fee_wlan = $siteInfo[81];
        $siteInfoDB->fee_microwave = $siteInfo[82];
        $siteInfoDB->fee_bbu = $siteInfo[57];
        $siteInfoDB->sys_num1 = $siteInfo[18];
        $siteInfoDB->sys1_height = transSysHeight($siteInfo[19]);
        $siteInfoDB->fee_tower1 = $siteInfo[22];
        $siteInfoDB->sys_num2 = $siteInfo[23];
        $siteInfoDB->sys2_height = transSysHeight($siteInfo[24]);
        $siteInfoDB->fee_tower2 = $siteInfo[27];
        $siteInfoDB->sys_num3 = $siteInfo[28];
        $siteInfoDB->sys3_height = transSysHeight($siteInfo[29]);
        $siteInfoDB->fee_tower3 = $siteInfo[32];
        $siteInfoDB->share_num_tower = $siteInfo[33];
        $siteInfoDB->user1_rent_tower_date = $siteInfo[34];
        $siteInfoDB->user2_rent_tower_date = $siteInfo[36];
        $siteInfoDB->share_discount_tower_after_user1 = $siteInfo[35];
        $siteInfoDB->share_discount_tower_after_user2 = $siteInfo[37];
        $siteInfoDB->fee_tower_discounted = $siteInfo[38];
        $siteInfoDB->fee_house1 = $siteInfo[39];
        $siteInfoDB->fee_house2 = $siteInfo[40];
        $siteInfoDB->fee_house3 = $siteInfo[41];
        $siteInfoDB->share_num_house = $siteInfo[42];
        $siteInfoDB->user1_rent_house_date = $siteInfo[43];
        $siteInfoDB->user2_rent_house_date = $siteInfo[45];
        $siteInfoDB->share_discount_house_after_user1 = $siteInfo[44];
        $siteInfoDB->share_discount_house_after_user2 = $siteInfo[46];
        $siteInfoDB->fee_house_discounted = $siteInfo[47];
        $siteInfoDB->fee_support1 = $siteInfo[48];
        $siteInfoDB->fee_support2 = $siteInfo[49];
        $siteInfoDB->fee_support3 = $siteInfo[50];
        $siteInfoDB->share_num_support = $siteInfo[51];
        $siteInfoDB->user1_rent_support_date = $siteInfo[52];
        $siteInfoDB->user2_rent_support_date = $siteInfo[54];
        $siteInfoDB->share_discount_support_after_user1 = $siteInfo[53];
        $siteInfoDB->share_discount_support_after_user2 = $siteInfo[55];
        $siteInfoDB->fee_support_discounted = $siteInfo[56];
        $siteInfoDB->fee_maintain1 = $siteInfo[58];
        $siteInfoDB->fee_maintain2 = $siteInfo[59];
        $siteInfoDB->fee_maintain3 = $siteInfo[60];
        $siteInfoDB->share_num_maintain = $siteInfo[61];
        $siteInfoDB->user1_rent_maintain_date = $siteInfo[62];
        $siteInfoDB->user2_rent_maintain_date = $siteInfo[64];
        $siteInfoDB->share_discount_maintain_after_user1 = $siteInfo[63];
        $siteInfoDB->share_discount_maintain_after_user2 = $siteInfo[65];
        $siteInfoDB->fee_maintain_discounted = $siteInfo[66];
        $siteInfoDB->fee_site = $siteInfo[67];
        $siteInfoDB->share_num_site = $siteInfo[68];
        $siteInfoDB->user1_rent_site_date = $siteInfo[69];
        $siteInfoDB->user2_rent_site_date = $siteInfo[71];
        $siteInfoDB->share_discount_site_after_user1 = $siteInfo[70];
        $siteInfoDB->share_discount_site_after_user2 = $siteInfo[72];
        $siteInfoDB->fee_site_discounted = $siteInfo[73];
        $siteInfoDB->fee_import = $siteInfo[74];
        $siteInfoDB->share_num_import = $siteInfo[75];
        $siteInfoDB->user1_rent_import_date = $siteInfo[76];
        $siteInfoDB->user2_rent_import_date = $siteInfo[78];
        $siteInfoDB->share_discount_import_after_user1 = $siteInfo[77];
        $siteInfoDB->share_discount_import_after_user2 = $siteInfo[79];
        $siteInfoDB->fee_import_discounted = $siteInfo[80];
        $siteInfoDB->is_new_tower = 1;
        $siteInfoDB->fee_service = $siteInfo[84] - $siteInfo[15];
        $siteInfoDB->fee_total = $siteInfo[84];
        $siteInfoDB->save();
    }

    public function getSiteStats($region, $beginDate, $endDate, $shareType)
    {
        $date = explode('-', $endDate);
        $year = $date[0];

        $isBillExist = $this->whereBetween('month', [$beginDate, $endDate])
            ->get();
        if ($isBillExist->isEmpty()) {
            return false;
        } else {
            if ($region == '湖北省') {
                $site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_share_num_stats = $this->select(DB::raw('tower_type, sys1_height,' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('is_new_tower', 0)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('is_new_tower', 0)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_share_num_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->where('established_time', '>=', $beginDate . '-01')
                    ->get();
                $new_site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_num_delivered_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', ($year - 1) . '-12-31')
                    ->get();


                $new_site_share_num_delivered_stats = $this->select(DB::raw('tower_type, sys1_height,' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('established_time', '<=', ($year - 1) . '-12-31')
                    ->get();
                $site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . ' month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_share_num_fee_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . 'month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('is_new_tower', 0)
                    ->groupBy('month')
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $total_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, sum(fee_gnr_allincharge) fee_gnr_allincharge, sum(fee_total) fee_total, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('month', '>=', $beginDate)
                    ->where('month', '<=', $endDate)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
            } else {
                $site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_share_num_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 0)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 0)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_share_num_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->where('established_time', '>=', $beginDate . '-01')
                    ->get();
                $new_site_num_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_num_delivered_stats = $this->select(DB::raw('tower_type, sys1_height,month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 1)
                    ->where('established_time', '<=', ($year - 1) . '-12-31')
                    ->get();


                $new_site_share_num_delivered_stats = $this->select(DB::raw('tower_type, sys1_height,' . "{$shareType}," . 'month,count(distinct site_code) count'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->where('region_id', transRegion($region))
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('established_time', '<=', ($year - 1) . '-12-31')
                    ->get();
                $site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . ' month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $new_site_share_num_fee_stats = $this->select(DB::raw('tower_type, sys1_height, ' . "{$shareType}," . 'month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->groupBy($shareType)
                    ->where('is_new_tower', 1)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $old_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, month,sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,
                sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('is_new_tower', 0)
                    ->groupBy('month')
                    ->where('region_id', transRegion($region))
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
                $total_site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, sum(fee_gnr_allincharge) fee_gnr_allincharge, sum(fee_total) fee_total, sum(fee_service) fee_service'))
                    ->groupBy('sys1_height')
                    ->groupBy('tower_type')
                    ->where('region_id', transRegion($region))
                    ->where('month', '>=', $beginDate)
                    ->where('month', '<=', $endDate)
                    ->where('established_time', '<=', $endDate . '-31')
                    ->get();
            }

            $site_infos = [[1, 2], [1, 5], [1, 6], [1, 7], [1, 8], [2, 1], [2, 3], [2, 4], [2, 5], [2, 6], [3, 1], [4, 9], [5, 9]];
            $tower_type_num = 0;
            $siteStats = array(array());
            for ($i = 0; $i < 13; $i++) {
                for ($j = 0; $j < 30; $j++) {
                    $siteStats[$i][$j] = 0;
                }
            }
            foreach ($site_infos as $site_info) {
                foreach ($old_site_num_stats as $old_site_num_stat) {
                    if ($old_site_num_stat->month == $endDate) {
                        if ($old_site_num_stat->tower_type == $site_info[0] && $old_site_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][0] = $old_site_num_stat->count;
                        }
                    }

                }
                foreach ($old_site_share_num_stats as $old_site_share_num_stat) {
                    if ($old_site_share_num_stat->month == $endDate) {
                        if ($old_site_share_num_stat->{$shareType} == 3 && $old_site_share_num_stat->tower_type == $site_info[0] && $old_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][1] = $old_site_share_num_stat->count;
                        }
                        if ($old_site_share_num_stat->{$shareType} == 2 && $old_site_share_num_stat->tower_type == $site_info[0] && $old_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][2] = $old_site_share_num_stat->count;
                        }
                        if ($old_site_share_num_stat->{$shareType} == 1 && $old_site_share_num_stat->tower_type == $site_info[0] && $old_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][3] = $old_site_share_num_stat->count;
                            $siteStats[$tower_type_num][4] = 1 - $siteStats[$tower_type_num][3] / $siteStats[$tower_type_num][0];
                        }
                    }

                }
                foreach ($new_site_num_stats as $new_site_num_stat) {
                    if ($new_site_num_stat->month == $endDate) {
                        if ($new_site_num_stat->tower_type == $site_info[0] && $new_site_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][5] = $new_site_num_stat->count;
                        }
                    }

                }
                foreach ($new_site_share_num_stats as $new_site_share_num_stat) {
                    if ($new_site_share_num_stat->month == $endDate) {
                        if ($new_site_share_num_stat->{$shareType} == 3 && $new_site_share_num_stat->tower_type == $site_info[0] && $new_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][6] = $new_site_share_num_stat->count;

                        }
                        if ($new_site_share_num_stat->{$shareType} == 2 && $new_site_share_num_stat->tower_type == $site_info[0] && $new_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][7] = $new_site_share_num_stat->count;
                        }
                        if ($new_site_share_num_stat->{$shareType} == 1 && $new_site_share_num_stat->tower_type == $site_info[0] && $new_site_share_num_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][8] = $new_site_share_num_stat->count;
                        }
                        if (($siteStats[$tower_type_num][6] + $siteStats[$tower_type_num][7]) == 0) {
                            $siteStats[$tower_type_num][9] = 0;
                        } else {
                            $siteStats[$tower_type_num][9] = 1 - $siteStats[$tower_type_num][8] / ($siteStats[$tower_type_num][6] + $siteStats[$tower_type_num][7] + $siteStats[$tower_type_num][8]);
                        }
                    }

                }
                if (empty($siteStats[$tower_type_num][8])) {
                    $siteStats[$tower_type_num][8] = 0;
                }
                foreach ($new_site_num_delivered_stats as $new_site_num_delivered_stat) {
                    if ($new_site_num_delivered_stat->month == $endDate) {
                        if ($new_site_num_delivered_stat->tower_type == $site_info[0] && $new_site_num_delivered_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][10] = $new_site_num_delivered_stat->count;
                        }
                    }

                }
                foreach ($new_site_share_num_delivered_stats as $new_site_share_num_delivered_stat) {
                    if ($new_site_share_num_delivered_stat->month == $endDate) {
                        if ($new_site_share_num_delivered_stat->{$shareType} == 3 && $new_site_share_num_delivered_stat->tower_type == $site_info[0] && $new_site_share_num_delivered_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][11] = $new_site_share_num_delivered_stat->count;
                        }
                        if ($new_site_share_num_delivered_stat->{$shareType} == 2 && $new_site_share_num_delivered_stat->tower_type == $site_info[0] && $new_site_share_num_delivered_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][12] = $new_site_share_num_delivered_stat->count;
                        }
                        if ($new_site_share_num_delivered_stat->{$shareType} == 1 && $new_site_share_num_delivered_stat->tower_type == $site_info[0] && $new_site_share_num_delivered_stat->sys1_height == $site_info[1]) {
                            $siteStats[$tower_type_num][13] = $new_site_share_num_delivered_stat->count;
                        }
                        if ($siteStats[$tower_type_num][10] == 0) {
                            $siteStats[$tower_type_num][14] = 0;
                        } else {
                            $siteStats[$tower_type_num][14] = 1 - $siteStats[$tower_type_num][13] / $siteStats[$tower_type_num][10];
                        }


                    }


                }

                // //计算当年新建共享率
                // foreach ($new_site_share_num_stats as $new_site_share_num_stat) {
                //     if ($new_site_share_num_stat->{$shareType} == 1 && $new_site_share_num_stat->tower_type == $site_info[0] && $new_site_share_num_stat->sys1_height == $site_info[1] && $new_site_share_num_stat->month == $endDate) {
                //         $new_site_share_1_num = $new_site_share_num_stat->count;
                //         foreach ($new_site_num_stats as $new_site_num_stat) {
                //             if ($new_site_num_stat->tower_type == $site_info[0] && $new_site_num_stat->sys1_height == $site_info[1] && $new_site_num_stat->month == $endDate) {
                //                 $new_site_num = $new_site_num_stat->count;
                //             }
                //         }
                //         if (empty($new_site_num)) {
                //             $siteStats[$tower_type_num][14] = 0;
                //         }else{
                //             $siteStats[$tower_type_num][14] = 1 - $new_site_share_1_num/$new_site_num;
                //         }
                //     }

                // }

                // 对每个月的详单计算单塔平均服务费
                $month_temp = $beginDate;
                $month_num = 0;
                $siteStats[$tower_type_num][15] = 0;
                $siteStats[$tower_type_num][16] = 0;
                $siteStats[$tower_type_num][17] = 0;
                $siteStats[$tower_type_num][18] = 0;
                $siteStats[$tower_type_num][19] = 0;
                $siteStats[$tower_type_num][20] = 0;
                $siteStats[$tower_type_num][21] = 0;
                $siteStats[$tower_type_num][22] = 0;
                $siteStats[$tower_type_num][23] = 0;
                $siteStats[$tower_type_num][24] = 0;
                while (strtotime($month_temp) <= strtotime($endDate)) {
                    foreach ($new_site_share_num_fee_stats as $new_site_share_num_fee_stat) {
                        if ($new_site_share_num_fee_stat->tower_type == $site_info[0] && $new_site_share_num_fee_stat->sys1_height == $site_info[1] && $new_site_share_num_fee_stat->month == '2017-03') {
                            if ($new_site_share_num_fee_stat->{$shareType} == 1 || $new_site_share_num_fee_stat->{$shareType} == 0) {
                                foreach ($new_site_share_num_stats as $new_site_share_num_stat) {
                                    if ($new_site_share_num_stat->tower_type == $site_info[0] && $new_site_share_num_stat->sys1_height == $site_info[1] && $new_site_share_num_stat->month == $month_temp) {
                                        if ($new_site_share_num_stat->{$shareType} == 1) {
                                            $new_site_share_1_num = $new_site_share_num_stat->count;
                                        }
                                        if ($new_site_share_num_stat->{$shareType} == 2) {
                                            $new_site_share_2_num = $new_site_share_num_stat->count;
                                        }
                                        if ($new_site_share_num_stat->{$shareType} == 3) {
                                            $new_site_share_3_num = $new_site_share_num_stat->count;
                                        }

                                    }
                                }
                                if (empty($new_site_share_1_num)) {
                                    $siteStats[$tower_type_num][15] += 0;
                                    $siteStats[$tower_type_num][16] += 0;
                                    $siteStats[$tower_type_num][17] += 0;
                                    $siteStats[$tower_type_num][18] += 0;
                                    $siteStats[$tower_type_num][19] += 0;
                                    $siteStats[$tower_type_num][20] += 0;
                                } else {
                                    $siteStats[$tower_type_num][15] += $new_site_share_num_fee_stat->fee_service / $new_site_share_1_num;
                                    $siteStats[$tower_type_num][16] += $new_site_share_num_fee_stat->fee_tower / $new_site_share_1_num;
                                    $siteStats[$tower_type_num][17] += $new_site_share_num_fee_stat->fee_site / $new_site_share_1_num;
                                    $siteStats[$tower_type_num][18] += $new_site_share_num_fee_stat->fee_import / $new_site_share_1_num;
                                    $siteStats[$tower_type_num][19] += $new_site_share_num_fee_stat->fee_maintain / $new_site_share_1_num;
                                    $siteStats[$tower_type_num][20] += ($new_site_share_num_fee_stat->fee_house + $new_site_share_num_fee_stat->fee_support) / $new_site_share_1_num;
                                }

                            }
                            if ($new_site_share_num_fee_stat->{$shareType} == 3) {
                                if (empty($new_site_share_3_num)) {
                                    $siteStats[$tower_type_num][23] += 0;
                                } else {
                                    $siteStats[$tower_type_num][23] += $new_site_share_num_fee_stat->fee_service / $new_site_share_3_num;
                                }

                            }
                            if ($new_site_share_num_fee_stat->{$shareType} == 2) {

                                if (empty($new_site_share_2_num)) {
                                    $siteStats[$tower_type_num][24] += 0;
                                } else {
                                    $siteStats[$tower_type_num][24] += $new_site_share_num_fee_stat->fee_service / $new_site_share_2_num;

                                }
                            }


                        }

                    }
                    foreach ($old_site_fee_stats as $old_site_fee_stat) {
                        if ($old_site_fee_stat->tower_type == $site_info[0] && $old_site_fee_stat->sys1_height == $site_info[1] && $old_site_fee_stat->month == $month_temp) {
                            foreach ($old_site_num_stats as $old_site_num_stat) {
                                if ($old_site_num_stat->tower_type == $site_info[0] && $old_site_num_stat->sys1_height == $site_info[1] && $old_site_num_stat->month == $month_temp) {
                                    $old_site_num = $old_site_num_stat->count;
                                }
                            }
                            if (empty($old_site_num)) {
                                $siteStats[$tower_type_num][21] += 0;
                            } else {
                                $siteStats[$tower_type_num][21] += $old_site_fee_stat->fee_service / $old_site_num;
                            }

                        }


                    }
                    foreach ($new_site_fee_stats as $new_site_fee_stat) {
                        if ($new_site_fee_stat->tower_type == $site_info[0] && $new_site_fee_stat->sys1_height == $site_info[1] && $new_site_fee_stat->month == $month_temp) {
                            foreach ($new_site_num_stats as $new_site_num_stat) {
                                if ($new_site_num_stat->tower_type == $site_info[0] && $new_site_num_stat->sys1_height == 2 && $new_site_num_stat->month == $month_temp) {
                                    $new_site_num = $new_site_num_stat->count;
                                }
                            }
                            if (empty($new_site_num)) {
                                $siteStats[$tower_type_num][22] += 0;
                            } else {
                                $siteStats[$tower_type_num][22] += $new_site_fee_stat->fee_service / $new_site_num;
                            }

                        }
                    }
                    $month_temp = date("Y-m", strtotime("+1 months", strtotime($month_temp)));
                    $month_num++;

                }
                $siteStats[$tower_type_num][15] /= $month_num;
                $siteStats[$tower_type_num][16] /= $month_num;
                $siteStats[$tower_type_num][17] /= $month_num;
                $siteStats[$tower_type_num][18] /= $month_num;
                $siteStats[$tower_type_num][19] /= $month_num;
                $siteStats[$tower_type_num][20] /= $month_num;
                $siteStats[$tower_type_num][21] /= $month_num;
                $siteStats[$tower_type_num][22] /= $month_num;
                $siteStats[$tower_type_num][23] /= $month_num;
                $siteStats[$tower_type_num][24] /= $month_num;
                foreach ($total_site_fee_stats as $total_site_fee_stat) {
                    if ($total_site_fee_stat->tower_type == $site_info[0] && $total_site_fee_stat->sys1_height == $site_info[1]) {
                        $siteStats[$tower_type_num][25] = $total_site_fee_stat->fee_total;
                        $siteStats[$tower_type_num][26] = $total_site_fee_stat->fee_service;
                        $siteStats[$tower_type_num][27] = 0;
                        $siteStats[$tower_type_num][28] = $total_site_fee_stat->fee_gnr_allincharge;
                        $siteStats[$tower_type_num][29] = 0;
                    }
                }
                $tower_type_num++;
            }
            $siteStats[13][0] = 0;
            $siteStats[13][1] = 0;
            $siteStats[13][2] = 0;
            $siteStats[13][3] = 0;
            $siteStats[13][5] = 0;
            $siteStats[13][6] = 0;
            $siteStats[13][7] = 0;
            $siteStats[13][8] = 0;
            $siteStats[13][10] = 0;
            $siteStats[13][11] = 0;
            $siteStats[13][12] = 0;
            $siteStats[13][13] = 0;
            $siteStats[13][15] = 0;
            $siteStats[13][16] = 0;
            $siteStats[13][17] = 0;
            $siteStats[13][18] = 0;
            $siteStats[13][19] = 0;
            $siteStats[13][20] = 0;
            $siteStats[13][21] = 0;
            $siteStats[13][22] = 0;
            $siteStats[13][23] = 0;
            $siteStats[13][24] = 0;
            $siteStats[13][25] = 0;
            $siteStats[13][26] = 0;
            $siteStats[13][27] = 0;
            $siteStats[13][28] = 0;
            $siteStats[13][29] = 0;

            foreach ($siteStats as $siteStat) {
                $siteStats[13][0] += $siteStat[0];
                $siteStats[13][1] += $siteStat[1];
                $siteStats[13][2] += $siteStat[2];
                $siteStats[13][3] += $siteStat[3];
                $siteStats[13][5] += $siteStat[5];
                $siteStats[13][6] += $siteStat[6];
                $siteStats[13][7] += $siteStat[7];
                $siteStats[13][8] += $siteStat[8];
                $siteStats[13][10] += $siteStat[10];
                $siteStats[13][11] += $siteStat[11];
                $siteStats[13][12] += $siteStat[12];
                $siteStats[13][13] += $siteStat[13];
                $siteStats[13][15] += $siteStat[15];
                $siteStats[13][16] += $siteStat[16];
                $siteStats[13][17] += $siteStat[17];
                $siteStats[13][18] += $siteStat[18];
                $siteStats[13][19] += $siteStat[19];
                $siteStats[13][20] += $siteStat[20];
                $siteStats[13][21] += $siteStat[21];
                $siteStats[13][22] += $siteStat[22];
                $siteStats[13][23] += $siteStat[23];
                $siteStats[13][24] += $siteStat[24];
                $siteStats[13][25] += $siteStat[25];
                $siteStats[13][26] += $siteStat[26];
                $siteStats[13][27] += $siteStat[27];
                $siteStats[13][28] += $siteStat[28];
                $siteStats[13][29] += $siteStat[29];
            }
            if ($siteStats[13][0] == 0) {
                $siteStats[13][4] = 0;
            } else {
                $siteStats[13][4] = ($siteStats[13][1] + $siteStats[13][2]) / $siteStats[13][0];
            }
            if ($siteStats[13][5] == 0) {
                $siteStats[13][9] = 0;
            } else {
                $siteStats[13][9] = ($siteStats[13][6] + $siteStats[13][7]) / $siteStats[13][5];
            }
            if ($siteStats[13][10] == 0) {
                $siteStats[13][14] = 0;
            } else {
                $siteStats[13][14] = ($siteStats[13][11] + $siteStats[13][12]) / $siteStats[13][10];
            }
            return $siteStats;
        }

    }

    /**
     * @return array
     * 何龙临时要求统计站址数据
     */
    public function getSiteStatsTemp()
    {
//        $site_fee_stats = $this->select(DB::raw('tower_type, sys1_height, region_id, sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
//            ->groupBy('region_id')
//            ->groupBy('sys1_height')
//            ->groupBy('tower_type')
//            ->where('month', '2017-04')
//            ->where('is_new_tower', 0)
//            ->whereIn('region_id', ['420700', '421100', '420200', '421200'])
//            ->get();
        $site_fee_stats = DB::table('irontower_bill_detail_rru')->select(DB::raw('tower_type, sys1_height, region_id, sum(fee_tower_discounted) fee_tower, sum(fee_house_discounted) fee_house,sum(fee_support_discounted) fee_support, sum(fee_maintain_discounted) fee_maintain, sum(fee_site_discounted) fee_site, sum(fee_import_discounted) fee_import, sum(fee_service) fee_service'))
            ->groupBy('region_id')
            ->groupBy('sys1_height')
            ->groupBy('tower_type')
            ->where('month', '2017-04')
            ->where('is_new_tower', 0)
            ->whereIn('region_id', ['420700', '421100', '420200', '421200'])
            ->get();
        $site_infos = [[1, 2], [1, 5], [1, 6], [1, 7], [1, 8], [2, 1], [2, 3], [2, 4], [2, 5], [2, 6], [3, 1], [4, 9], [5, 9]];
        $siteStats = array(array());
        for ($i = 0; $i < 13; $i++) {
            for ($j = 0; $j < 24; $j++) {
                $siteStats[$i][$j] = 0;
            }
        }
        foreach ($site_infos as $index => $site_info) {
            foreach ($site_fee_stats as $site_fee_stat) {
                if ($site_fee_stat->tower_type == $site_info[0] && $site_fee_stat->sys1_height == $site_info[1]) {
                    if ($site_fee_stat->region_id == '420700') {
                        $siteStats[$index][0] = $site_fee_stat->fee_tower;
                        $siteStats[$index][1] = $site_fee_stat->fee_house;
                        $siteStats[$index][2] = $site_fee_stat->fee_support;
                        $siteStats[$index][3] = $site_fee_stat->fee_site;
                        $siteStats[$index][4] = $site_fee_stat->fee_maintain;
                        $siteStats[$index][5] = $site_fee_stat->fee_import;
                    }
                    if ($site_fee_stat->region_id == '421100') {
                        $siteStats[$index][6] = $site_fee_stat->fee_tower;
                        $siteStats[$index][7] = $site_fee_stat->fee_house;
                        $siteStats[$index][8] = $site_fee_stat->fee_support;
                        $siteStats[$index][9] = $site_fee_stat->fee_site;
                        $siteStats[$index][10] = $site_fee_stat->fee_maintain;
                        $siteStats[$index][11] = $site_fee_stat->fee_import;
                    }
                    if ($site_fee_stat->region_id == '420200') {
                        $siteStats[$index][12] = $site_fee_stat->fee_tower;
                        $siteStats[$index][13] = $site_fee_stat->fee_house;
                        $siteStats[$index][14] = $site_fee_stat->fee_support;
                        $siteStats[$index][15] = $site_fee_stat->fee_site;
                        $siteStats[$index][16] = $site_fee_stat->fee_maintain;
                        $siteStats[$index][17] = $site_fee_stat->fee_import;
                    }
                    if ($site_fee_stat->region_id == '421200') {
                        $siteStats[$index][18] = $site_fee_stat->fee_tower;
                        $siteStats[$index][19] = $site_fee_stat->fee_house;
                        $siteStats[$index][20] = $site_fee_stat->fee_support;
                        $siteStats[$index][21] = $site_fee_stat->fee_site;
                        $siteStats[$index][22] = $site_fee_stat->fee_maintain;
                        $siteStats[$index][23] = $site_fee_stat->fee_import;
                    }

                }
            }
        }

        return $siteStats;
    }

    /**
     * 将2017-04铁塔账单中的存量塔机房全部转换成 RRU 拉远
     */
    public function toRRU()
    {
        $bills = $this->where('month', '2017-04')
            ->where('is_new_tower', 0)
            ->whereIn('region_id', ['420700', '421100', '420200', '421200'])
            ->get();
        foreach ($bills as $bill) {
            if ($bill->product_type == 4) {
                DB::table('irontower_bill_detail_rru')
                    ->insert([
                        'month' => $bill->month,
                        'business_code' => $bill->business_code,
                        'region_id' => $bill->region_id,
                        'region_name' => $bill->region_name,
                        'tower_type' => $bill->tower_type,
                        'product_type' => $bill->product_type,
                        'fee_electricity' => $bill->fee_electricity,
                        'fee_gnr_allincharge' => $bill->fee_gnr_allincharge,
                        'fee_add' => $bill->fee_add,
                        'fee_battery' => $bill->fee_battery,
                        'fee_wlan' => $bill->fee_wlan,
                        'fee_microwave' => $bill->fee_microwave,
                        'fee_bbu' => $bill->fee_bbu,
                        'sys_num1' => $bill->sys_num1,
                        'sys1_height' => $bill->sys1_height,
                        'fee_tower_discounted' => $bill->fee_tower_discounted,
                        'fee_house_discounted' => $bill->fee_house_discounted,
                        'fee_support_discounted' => $bill->fee_support_discounted,
                        'fee_maintain_discounted' => $bill->fee_maintain_discounted,
                        'fee_site_discounted' => $bill->fee_site_discounted,
                        'fee_import_discounted' => $bill->fee_import_discounted,
                        'is_new_tower' => $bill->is_new_tower,
                    ]);
            } else {
                $fee_house = FeeHouseStd::where('tower_type', $bill->tower_type)
                    ->where('product_type', 4)
                    ->where('is_new_tower', $bill->is_new_tower)
                    ->value('fee_house');
                $fee_support = FeeSupportStd::where('tower_type', $bill->tower_type)
                    ->where('product_type', 4)
                    ->where('is_new_tower', $bill->is_new_tower)
                    ->value('fee_support');
                $fee_maintain = FeeMaintainStd::where('tower_type', $bill->tower_type)
                    ->where('product_type', 4)
                    ->where('is_new_tower', $bill->is_new_tower)
                    ->value('fee_maintain');
                $share_discount_house = transShareDisc($bill->share_discount_house_after_user1, $bill->share_discount_house_after_user2);
                $share_discount_maintain = transShareDisc($bill->share_discount_maintain_after_user1, $bill->share_discount_maintain_after_user2);
                $share_discount_support = transShareDisc($bill->share_discount_support_after_user1, $bill->share_discount_support_after_user2);
                DB::table('irontower_bill_detail_rru')
                    ->insert([
                        'month' => $bill->month,
                        'business_code' => $bill->business_code,
                        'region_id' => $bill->region_id,
                        'region_name' => $bill->region_name,
                        'tower_type' => $bill->tower_type,
                        'product_type' => 4,
                        'fee_electricity' => $bill->fee_electricity,
                        'fee_gnr_allincharge' => $bill->fee_gnr_allincharge,
                        'fee_add' => $bill->fee_add,
                        'fee_battery' => $bill->fee_battery,
                        'fee_wlan' => $bill->fee_wlan,
                        'fee_microwave' => $bill->fee_microwave,
                        'fee_bbu' => $bill->fee_bbu,
                        'sys_num1' => $bill->sys_num1,
                        'sys1_height' => $bill->sys1_height,
                        'fee_tower_discounted' => $bill->fee_tower_discounted,
                        'fee_house_discounted' => $fee_house * $share_discount_house,
                        'fee_support_discounted' => $fee_support * $share_discount_support,
                        'fee_maintain_discounted' => $fee_maintain * $share_discount_maintain,
                        'fee_site_discounted' => $bill->fee_site_discounted,
                        'fee_import_discounted' => $bill->fee_import_discounted,
                        'is_new_tower' => $bill->is_new_tower,
                    ]);

            }


        }


    }


}
