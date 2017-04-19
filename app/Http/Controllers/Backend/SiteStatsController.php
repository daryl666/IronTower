<?php

namespace App\Http\Controllers\Backend;

use App\Models\SiteStats;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class SiteStatsController extends Controller
{
    function indexPage(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return view('backend.siteStats.index');
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filter = $request->all();
            $year = $request->get('year');
            if ($year == '') {
                $year = '9999';
            }
            $region = $request->get('region');
            $siteStatsDB = new SiteStats();
            list($site_num_stats,
                $old_site_share_num_stats,
                $old_site_num_stats,
                $new_site_share_num_stats,
                $new_site_num_stats,
                $new_site_num_delivered_stats,
                $site_fee_stats,
                $old_site_fee_stats,
                $new_site_fee_stats,
                $total_site_fee_stats) = $siteStatsDB->getSiteStats($region, $year);

            foreach ($old_site_num_stats as $old_site_num_stat) {
                foreach ($old_site_share_num_stats as $old_site_share_num_stat) {
                    if ($old_site_num_stat->tower_type == $old_site_share_num_stat->tower_type &&
                        $old_site_num_stat->sys1_height == $old_site_share_num_stat->sys1_height
                    ) {
                        if ($old_site_share_num_stat->share_num_site == 1) {
                            $share_num1 = $old_site_share_num_stat->count;
                            $total_num = $old_site_num_stat->count;
                            $share_rate_old = formatNumber(($total_num - $share_num1) / $total_num * 100);
                            $old_site_num_stat->share_rate = $share_rate_old;
                        }
                    }
                }
                if (empty($old_site_num_stat->share_rate)) {
                    $old_site_num_stat->share_rate = "100.00";
                }
            }


            foreach ($new_site_num_stats as $new_site_num_stat) {
                foreach ($new_site_share_num_stats as $new_site_share_num_stat) {
                    if ($new_site_num_stat->tower_type == $new_site_share_num_stat->tower_type &&
                        $new_site_num_stat->sys1_height == $new_site_share_num_stat->sys1_height
                    ) {
                        if ($new_site_share_num_stat->share_num_site == 1) {
                            $share_num1 = $new_site_share_num_stat->count;
                            $total_num = $new_site_num_stat->count;
                            $share_rate_new = formatNumber(($total_num - $share_num1) / $total_num * 100);
                            $new_site_num_stat->share_rate = $share_rate_new;
                        }
                    }
                }
                if (empty($new_site_num_stat->share_rate)) {
                    $new_site_num_stat->share_rate = "100.00";
                }
            }

            foreach ($site_fee_stats as $site_fee_stat) {
                $site_fee = $site_fee_stat->fee_tower + $site_fee_stat->fee_house + $site_fee_stat->fee_support + $site_fee_stat->fee_maintain +
                    $site_fee_stat->fee_site + $site_fee_stat->fee_import;
                foreach ($site_num_stats as $site_num_stat) {
                    if ($site_num_stat->tower_type == $site_fee_stat->tower_type &&
                        $site_num_stat->sys1_height == $site_fee_stat->sys1_height
                    ) {
                        $site_fee_stat->avg_site_fee = $site_fee / $site_num_stat->count;
                        $site_fee_stat->site_fee = $site_fee;
                        if ($region != '湖北省') {
                            $fee_gnr_allincharge_std = DB::table('fee_gnr_allincharge_std')
                                ->where('region_id', transRegion($region))
                                ->pluck('fee_gnr_allincharge');
                            $site_fee_stat->fee_gnr_allincharge = $fee_gnr_allincharge_std[0];
                        } else {
                            foreach ($total_site_fee_stats as $total_site_fee_stat) {
                                if ($total_site_fee_stat->tower_type == $site_fee_stat->tower_type &&
                                    $total_site_fee_stat->sys1_height == $site_fee_stat->sys1_height
                                ) {
                                    $site_fee_stat->fee_gnr_allincharge = $total_site_fee_stat->fee_gnr_allincharge / $site_num_stat->count;
                                }
                            }
                        }


                        $site_fee_stat->avg_fee_tower = $site_fee_stat->fee_tower / $site_num_stat->count;
                        $site_fee_stat->avg_fee_site = $site_fee_stat->fee_site / $site_num_stat->count;
                        $site_fee_stat->avg_fee_import = $site_fee_stat->fee_import / $site_num_stat->count;
                        $site_fee_stat->avg_fee_maintain = $site_fee_stat->fee_maintain / $site_num_stat->count;

                    }
                }
            }

            foreach ($old_site_fee_stats as $old_site_fee_stat) {
                $site_fee = $old_site_fee_stat->fee_tower + $old_site_fee_stat->fee_house + $old_site_fee_stat->fee_support + $old_site_fee_stat->fee_maintain +
                    $old_site_fee_stat->fee_site + $old_site_fee_stat->fee_import;
                foreach ($site_num_stats as $site_num_stat) {
                    if ($site_num_stat->tower_type == $old_site_fee_stat->tower_type &&
                        $site_num_stat->sys1_height == $old_site_fee_stat->sys1_height
                    ) {
                        $old_site_fee_stat->avg_site_fee = $site_fee / $site_num_stat->count;
                        $old_site_fee_stat->avg_fee_tower = $old_site_fee_stat->fee_tower / $site_num_stat->count;
                        $old_site_fee_stat->avg_fee_site = $old_site_fee_stat->fee_site / $site_num_stat->count;
                        $old_site_fee_stat->avg_fee_import = $old_site_fee_stat->fee_import / $site_num_stat->count;
                        $old_site_fee_stat->avg_fee_maintain = $old_site_fee_stat->fee_maintain / $site_num_stat->count;

                    }
                }
            }

            foreach ($new_site_fee_stats as $new_site_fee_stat) {
                $site_fee = $new_site_fee_stat->fee_tower + $new_site_fee_stat->fee_house + $new_site_fee_stat->fee_support + $new_site_fee_stat->fee_maintain +
                    $new_site_fee_stat->fee_site + $new_site_fee_stat->fee_import;
                foreach ($site_num_stats as $site_num_stat) {
                    if ($site_num_stat->tower_type == $new_site_fee_stat->tower_type &&
                        $site_num_stat->sys1_height == $new_site_fee_stat->sys1_height
                    ) {
                        $new_site_fee_stat->avg_site_fee = $site_fee / $site_num_stat->count;
                        $new_site_fee_stat->avg_fee_tower = $new_site_fee_stat->fee_tower / $site_num_stat->count;
                        $new_site_fee_stat->avg_fee_site = $new_site_fee_stat->fee_site / $site_num_stat->count;
                        $new_site_fee_stat->avg_fee_import = $new_site_fee_stat->fee_import / $site_num_stat->count;
                        $new_site_fee_stat->avg_fee_maintain = $new_site_fee_stat->fee_maintain / $site_num_stat->count;

                    }
                }
            }

            foreach ($total_site_fee_stats as $total_site_fee_stat) {
                $site_fee = $total_site_fee_stat->fee_tower + $total_site_fee_stat->fee_house + $total_site_fee_stat->fee_support + $total_site_fee_stat->fee_maintain +
                    $total_site_fee_stat->fee_site + $total_site_fee_stat->fee_import;
                foreach ($site_num_stats as $site_num_stat) {
                    if ($site_num_stat->tower_type == $total_site_fee_stat->tower_type &&
                        $site_num_stat->sys1_height == $total_site_fee_stat->sys1_height
                    ) {
                        if (empty($total_site_fee_stat->fee_gnr_allincharge)) {
                            $fee_gnr_allincharge_std = DB::table('fee_gnr_allincharge_std')
                                ->where('region_id', transRegion($region))
                                ->pluck('fee_gnr_allincharge');
                            $total_site_fee_stat->fee_gnr_allincharge = $fee_gnr_allincharge_std[0] * $site_num_stat->count;
                        }
                        $total_site_fee_stat->site_fee = $site_fee;
                        $total_site_fee_stat->fee_total = $total_site_fee_stat->site_fee + $total_site_fee_stat->fee_gnr_allincharge;
                    }
                }
            }

//        dd($new_site_num_stats);
            return view('backend.siteStats.index')
                ->with('old_site_share_num_stats', $old_site_share_num_stats)
                ->with('old_site_num_stats', $old_site_num_stats)
                ->with('new_site_num_stats', $new_site_num_stats)
                ->with('new_site_share_num_stats', $new_site_share_num_stats)
                ->with('new_site_num_delivered_stats', $new_site_num_delivered_stats)
                ->with('site_fee_stats', $site_fee_stats)
                ->with('new_site_fee_stats', $new_site_fee_stats)
                ->with('old_site_fee_stats', $old_site_fee_stats)
                ->with('total_site_fee_stats', $total_site_fee_stats)
                ->with('filter', $filter);
        }

    }
}
