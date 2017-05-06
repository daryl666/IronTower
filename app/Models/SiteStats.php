<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SiteStats extends Model
{
    function getSiteStats($region, $year)
    {
        if ($region != '湖北省' && $region != 'admin') {
            $site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('established_time', '<=', $year . '-12-31')
                ->where('region_id', transRegion($region))
                ->where('sys_num1', '>=', 1)
                ->get();
            $old_site_share_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height, share_num_site,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('is_new_tower', 0)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->where('region_id', transRegion($region))
                ->get();
            $old_site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 0)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->where('region_id', transRegion($region))
                ->get();
            $new_site_share_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height, share_num_site,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->where('region_id', transRegion($region))
                ->get();
            $new_site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->where('region_id', transRegion($region))
                ->get();
            $new_site_num_delivered_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', ($year - 1) . '-12-31')
                ->where('established_time', '>=', ($year - 1) . '-10-31')
                ->where('sys_num1', '>=', 1)
                ->where('region_id', transRegion($region))
                ->get();

            $site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, share_num_site, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->where('site_info.region_id', transRegion($region))
                ->get();
            $new_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->where('is_new_tower', 1)
                ->where('site_info.region_id', transRegion($region))
                ->get();
            $old_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 0)
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->where('site_info.region_id', transRegion($region))
                ->get();
            $total_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->where('site_info.region_id', transRegion($region))
                ->get();
        } else {
            $site_num_stats_regions = DB::table('site_info')
                ->select(DB::raw('region_id,tower_type, sys1_height,count(id) count'))
                ->where('sys_num1', '>=', 1)
                ->groupBy('region_id')
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('established_time', '<=', $year . '-12-31')
                ->get();
            $site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->get();
            $old_site_share_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height, share_num_site,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('is_new_tower', 0)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->get();
            $old_site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 0)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->get();
            $new_site_share_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height, share_num_site,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->get();
            $new_site_num_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', $year . '-12-31')
                ->where('sys_num1', '>=', 1)
                ->get();
            $new_site_num_delivered_stats = DB::table('site_info')
                ->select(DB::raw('tower_type, sys1_height,count(id) count'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 1)
                ->where('established_time', '<=', ($year - 1) . '-12-31')
                ->where('established_time', '>=', ($year - 1) . '-10-31')
                ->where('sys_num1', '>=', 1)
                ->get();

            $site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, share_num_site, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->groupBy('share_num_site')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->get();
            $new_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->where('is_new_tower', 1)
                ->get();
            $old_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('is_new_tower', 0)
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->get();
            $total_site_fee_stats = DB::table('fee_out_site_price')
                ->join('site_info', 'site_info.business_code', '=', 'fee_out_site_price.business_code')
                ->select(DB::raw('tower_type, sys1_height, sum(fee_tower) fee_tower, sum(fee_house) fee_house,
                sum(fee_support) fee_support, sum(fee_maintain) fee_maintain, sum(fee_site) fee_site, sum(fee_import) fee_import'))
                ->groupBy('sys1_height')
                ->groupBy('tower_type')
                ->where('site_info.established_time', '<=', ($year) . '-12-31')
                ->get();
            foreach ($total_site_fee_stats as $total_site_fee_stat) {
                $total_site_fee_stat->fee_gnr_allincharge = 0;
                foreach ($site_num_stats_regions as $site_num_stats_region) {
                    if ($total_site_fee_stat->tower_type == $site_num_stats_region->tower_type &&
                        $total_site_fee_stat->sys1_height == $site_num_stats_region->sys1_height
                    ) {
                        switch ($site_num_stats_region->region_id) {
                            case '420700':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 64;
                                break;
                            case '422800':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 184.00;
                                break;
                            case '421100':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 82.00;
                                break;
                            case '420200':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 100.00;
                                break;
                            case '429000':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 106.00;
                                break;
                            case '420800':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 96.00;
                                break;
                            case '421000':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 98.00;
                                break;
                            case '429100':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 98.00;
                                break;
                            case '420300':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 124.00;
                                break;
                            case '421300':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 97.00;
                                break;
                            case '429200':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 109.00;
                                break;
                            case '420100':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 34.00;
                                break;
                            case '421200':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 76.00;
                                break;
                            case '420600':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 75.00;
                                break;
                            case '420900':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 108.00;
                                break;
                            case '420500':
                                $total_site_fee_stat->fee_gnr_allincharge += $site_num_stats_region->count * 163.00;
                                break;
                        }
                    }
                }


            }
        }
        $site_stats[] = $site_num_stats;
        $site_stats[] = $old_site_share_num_stats;
        $site_stats[] = $old_site_num_stats;
        $site_stats[] = $new_site_share_num_stats;
        $site_stats[] = $new_site_num_stats;
        $site_stats[] = $new_site_num_delivered_stats;
        $site_stats[] = $site_fee_stats;
        $site_stats[] = $old_site_fee_stats;
        $site_stats[] = $new_site_fee_stats;
        $site_stats[] = $total_site_fee_stats;
        return $site_stats;
    }



}
