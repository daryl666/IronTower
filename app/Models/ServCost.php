<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class ServCost extends Model
{
    function searchServCost($region, $beginDate, $endDate)
    {
        if($region == '湖北省'){
            $query = DB::table('fee_service');
        }else{
            $query = DB::table('fee_service')->where('region_name', $region);
        }

        if ($beginDate != '') {
            $query->where('month', '>=', $beginDate);
        }
        if ($endDate != '') {
            $query->where('month', '<=', $endDate);
        }
        return $query->get();
    }

    function updateDB(Request $request)
    {
        $isExist = DB::table('fee_service')->where('month', $request->get('month'))->where('region_name',$request->get('region'))->get();
        if (empty($isExist)) {
            $isSuccess = DB::table('fee_service')->where('id', $request->get('id'))
                ->update(['month' => $request->get('month'),
                    'updated_at' => date('Y-m-d h:i:s', time())]);
            return Array(false, $isSuccess);
        } else {
            return Array(true, false);
        }


    }

    function addDB(Request $request, Array $month_arr)
    {
        $region = $request->get('region');
        $isSuccess = true;
        foreach ($month_arr as $month) {
            $sites = DB::table('fee_out_site_price')->groupBy('site_code')->where('region_name', $region)->where('month', $month)->pluck('site_code');
            foreach ($sites as $site) {
                $site_prices = DB::table('fee_out_site_price')->where('region_name', $region)->where('month', $month)->where('site_code', $site)->orderBy('updated_at', 'desc')->get();
                $date = explode('-', $site_prices[0]->updated_at);
                $day = $date[2];
                $fee_basic_cost_taxed = $site_prices[0]->additive_basic_cost + (31 - $day) * $site_prices[0]->fee_basic_taxed;
                $fee_site_cost_taxed = $site_prices[0]->additive_site_cost + (31 - $day) * $site_prices[0]->fee_site_taxed;
                $fee_import_cost_taxed = $site_prices[0]->additive_import_cost + (31 - $day) * $site_prices[0]->fee_import_taxed;
                $bool = DB::table('fee_out_site')->insert([
                    'region_name' => $region,
                    'site_code' => $site,
                    'start_day' => $month,
                    'end_day' => $month,
                    'month_num' => 1,
                    'fee_basic_taxed' => $fee_basic_cost_taxed,
                    'fee_site_taxed' => $fee_site_cost_taxed,
                    'fee_import_taxed' => $fee_import_cost_taxed,
                    'created_at' => date('Y-m-d h:i:s', time()),
                ]);
                if (!$bool) {
                    $isSuccess = false;
                }
            }
            $total_fee_basic_cost_taxed = DB::table('fee_out_site')->where('start_day', $month)->where('region_name', $region)->sum('fee_basic_taxed');
            $total_fee_site_cost_taxed = DB::table('fee_out_site')->where('start_day', $month)->where('region_name', $region)->sum('fee_site_taxed');
            $total_fee_import_cost_taxed = DB::table('fee_out_site')->where('start_day', $month)->where('region_name', $region)->sum('fee_import_taxed');
            $isExist = DB::table('fee_service')->where('month', $month)->get();
            if (!$isExist) {
                $bool = DB::table('fee_service')->insert([
                    'month' => $month,
                    'region_name' => $region,
                    'site_num' => $request->get('siteNum'),
                    'fee_import' => 0,
                    'fee_import_taxed' => $total_fee_import_cost_taxed,
                    'fee_basic' => 0,
                    'fee_basic_taxed' => $total_fee_basic_cost_taxed,
                    'fee_site' => 0,
                    'fee_site_taxed' => $total_fee_site_cost_taxed,
                    'created_at' => date('Y-m-d h:i:s', time())
                ]);
                if (!$bool) {
                    $isSuccess = false;
                }
            }

        }
        return $isSuccess;
    }

//    function addDB(Request $request, Array $month_arr)
//    {
//        $region = $request->get('region');
//        dd($month_arr);
//        foreach ($month_arr as $month) {
//            $first_month = DB::table('fee_out_site_price')->where('region_name',$region)->min('month');
//            if ($month == $first_month) {
//                $site_prices = DB::table('fee_out_site_price')->where('month', $month)->get();
//                foreach ($site_prices as $site_price) {
//                    $date = explode('-', $site_price->updated_at);
//                    $day = $date[2];
//                    $fee_basic_cost_taxed = $site_price->fee_basic_taxed * (31 - $day);
//                    $fee_site_cost_taxed = $site_price->fee_site_taxed * (31 - $day);
//                    $fee_import_cost_taxed = $site_price->fee_import_taxed * (31 - $day);
//                    DB::table('fee_out_site')->insert([
//                        'region_name' => $site_price->region_name,
//                        'site_code' => $site_price->site_code,
//                        'start_day' => $site_price->month,
//                        'end_day' => $site_price->month,
//                        'month_num' => 1,
//                        'fee_basic_taxed' => $fee_basic_cost_taxed,
//                        'fee_site_taxed' => $fee_site_cost_taxed,
//                        'fee_import_taxed' => $fee_import_cost_taxed,
//                        'created_at' => date('Y-m-d h:i:s', time()),
//                    ]);
//                }
//                $total_fee_basic_cost_taxed = DB::table('fee_out_site')->where('start_day',$month)->where('region_name',$region)->sum('fee_basic_taxed');
//                $total_fee_site_cost_taxed = DB::table('fee_out_site')->where('start_day',$month)->where('region_name',$region)->sum('fee_site_taxed');
//                $total_fee_import_cost_taxed = DB::table('fee_out_site')->where('start_day',$month)->where('region_name',$region)->sum('fee_import_taxed');
//                DB::table('fee_service')->insert([
//                    'month' => $month,
//                    'region_name' => $region,
//                    'site_num' => $request->get('siteNum'),
//                    'fee_import' => 0,
//                    'fee_import_taxed' => $total_fee_import_cost_taxed,
//                    'fee_basic' => 0,
//                    'fee_basic_taxed' => $total_fee_basic_cost_taxed,
//                    'fee_site' => 0,
//                    'fee_site_taxed' => $total_fee_site_cost_taxed,
//                    'created_at' => date('Y-m-d h:i:s',time())
//                ]);
//            }
//        }
//    }

//    function addDB(Request $request,Array $month_arr){
//
//        foreach ($month_arr as $month){
//            $isSuccess = DB::table('fee_service')->insert([
//                'month' => $month,
//                'region_name' => $request->get('region'),
//                'site_num' => $request->get('siteNum'),
//                'fee_import' => $request->get('feeImport'),
//                'fee_import_taxed' => $request->get('feeImportTaxed'),
//                'fee_basic' => $request->get('feeBasic'),
//                'fee_basic_taxed' => $request->get('feeBasicTaxed'),
//                'fee_site' => $request->get('feeSite'),
//                'fee_site_taxed' => $request->get('feeSiteTaxed'),
//                'created_at' => date('Y-m-d h:i:s',time())
//            ]);
//        }
//
//
//    }

}
