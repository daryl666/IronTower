<?php

namespace App\Http\Controllers\Backend;

use App\Models\ServCost;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ServCostController extends Controller
{
    public function indexPage(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if ($request->get('region') != null) {
                $filter = $request->all();
                $region = $request->input('region', '');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $servCostDB = new ServCost();
                $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
                foreach ($servCosts as $servCost) {
                    $servCost->beginDate = $beginDate;
                    $servCost->endDate = $endDate;
                }
                return view('backend/servCost/index')->with('servCosts', $servCosts)
                    ->with('filter', $filter);
            } elseif ($request->get('region') == null) {
                return view('backend/servCost/index');
            }

        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {

            if (!empty(session('servCosts'))) {
                $servCosts = $request->session()->pull('servCosts');
                if ($servCosts == 1) {
                    $servCosts = null;
                }
                $filter = $request->session()->pull('filter');
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language=javascript>alert('提交成功！');</script>";
                }
                if ($flag == 'delete') {
                    echo "<script language=javascript>alert('删除成功！');</script>";
                }
                if ($flag == 'update') {
                    echo "<script language=javascript>alert('修改成功！');</script>";
                }
                return view('backend/servCost/index')->with('servCosts', $servCosts)
                    ->with('filter', $filter);
            } else {
                return view('backend/servCost/index');
            }
        }

    }

    function editPage($id, $region, Request $request)
    {
        $servCost = DB::table('fee_service')->where('id', $id)->get();
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $monthOld = $servCost[0]->month;
        return view('backend/servCost/edit')
            ->with('servCost', $servCost[0])
            ->with('region', $region)
            ->with('beginDate', $beginDate)
            ->with('endDate', $endDate)
            ->with('monthOld',$monthOld);
    }

    function update($id, Request $request)
    {
        $month = $request->get('month');
        $is_out = DB::table('fee_out')
            ->where('start_day',$request->get('monthOld'))
            ->pluck('is_out');
        if(!$is_out[0]){
            $delSuccess = DB::table('fee_service')->where('id', $id)->delete();
            $filter = $request->all();
            $region = $request->input('region', '');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $isSuccess = DB::statement('call region_fee_service(?,?,?)', array($region, $month, $month));
            $servCostDB = new ServCost();
            if ($isSuccess == true) {
                $servCostDB = new ServCost();
                $region = $request->get('region_0');
                $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
                return redirect('backend/servCost')
                    ->with('servCosts', $servCosts)
                    ->with('filter', $filter)
                    ->with('flag', 'update');
            } else {
                echo "<script language=javascript>alert('修改失败！');history.back();</script>";
            }
        }else{
            echo "<script language=javascript>alert('该月账单已出，无法修改！');history.back();</script>";
        }



    }

    public
    function delete($id, Request $request)
    {
        $is_out = DB::table('fee_out')
            ->where('start_day',$request->get('monthOld'))
            ->pluck('is_out');
        if(!$is_out[0]){
            $isSuccess = DB::table('fee_service')->where('id', $id)->delete();
            $filter = $request->all();
            if ($isSuccess == true) {
                $servCostDB = new ServCost();
                $region = $request->get('region');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
                if (!empty($servCosts)) {
                    foreach ($servCosts as $servCost) {
                        $servCost->beginDate = $beginDate;
                        $servCost->endDate = $endDate;
                    }
                } else {
                    $servCosts = 1;
                }
                return redirect('backend/servCost')
                    ->with('servCosts', $servCosts)
                    ->with('filter', $filter)
                    ->with('flag', 'delete');

            } else {
                echo "<script language=javascript>alert('删除失败！');history.back();</script>";
            }
        }else{
            echo "<script language=javascript>alert('该月账单已出，无法删除！');history.back();</script>";
        }


    }

    public
    function back(Request $request)
    {

        $filter = $request->all();
        $servCostDB = new ServCost();
        $region = $request->get('region_0');
        $filter['region'] = $region;
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
        foreach ($servCosts as $servCost) {
            $servCost->beginDate = $beginDate;
            $servCost->endDate = $endDate;
        }
        return view('backend/servCost/index')->with('servCosts', $servCosts)
            ->with('filter', $filter);

    }

    public
    function addPage(Request $request)
    {
        $region = $request->get('region');
        $beginData = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $latestDate = DB::table('fee_service')->where('region_name', $region)->max('month');
//        $siteInfos = DB::table('fee_out_site_price')->where('region_name', $region)->get();
//        $servPrices[0] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_basic');
//        $servPrices[1] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_basic_taxed');
//        $servPrices[2] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_site');
//        $servPrices[3] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_site_taxed');
//        $servPrices[4] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_import');
//        $servPrices[5] = DB::table('fee_out_site_price')->where('region_name', $region)->sum('fee_import_taxed');
//        $siteNum = count($siteInfos);
        if (!empty($latestDate)) {
            $latestDate_arr = explode('-', $latestDate);
            if ($latestDate_arr[1] == 12) {
                $beginYear = $latestDate_arr[0] + 1;
                $beginMonth = str_pad('1', 2, '0', STR_PAD_LEFT);
                $newDate = $beginYear . '-' . $beginMonth;
            } else {
                $beginYear = $latestDate_arr[0];
                $beginMonth = $latestDate_arr[1] + 1;
                $beginMonth = str_pad($beginMonth, 2, '0', STR_PAD_LEFT);
                $newDate = $beginYear . '-' . $beginMonth;
            }
            return view('backend/servCost/add')->with('region', $region)
                ->with('beginDate', $beginData)
                ->with('endDate', $endDate)
//                ->with('siteNum', $siteNum)
//                ->with('servPrices', $servPrices)
//                ->with('latestMonth', $latestDate)
                ->with('newDate', $newDate);
        } else {
            return view('backend/servCost/add')->with('region', $region)
                ->with('beginDate', $beginData)
                ->with('endDate', $endDate);
        }
//                ->with('siteNum', $siteNum)
//                ->with('servPrices', $servPrices);


    }

    public
    function add(Request $request)
    {
        /*$filter = $request->all();
        $region = $request->input('region', '');
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');

        $startDate = $request->get('startDate');
        $stopDate = $request->get('stopDate');

        $start_arr = explode("-", $startDate);
        $end_arr = explode("-", $stopDate);

        $start_year = intval($start_arr[0]);
        $start_month = intval($start_arr[1]);

        $end_year = intval($end_arr[0]);
        $end_month = intval($end_arr[1]);

        $diff_year = $end_year - $start_year;

        $month_arr = [];

        if ($diff_year == 0) {
            for ($month = $start_month; $month <= $end_month; $month++) {
                $month_arr[] = $start_year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            }
        } else {
            for ($year = $start_year; $year <= $end_year; $year++) {
                if ($year == $start_year) {
                    for ($month = $start_month; $month <= 12; $month++) {
                        $month_arr[] = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                    }
                } elseif ($year == $end_year) {
                    for ($month = 1; $month <= $end_month; $month++) {
                        $month_arr[] = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                    }
                } else {
                    for ($month = 1; $month <= 12; $month++) {
                        $month_arr[] = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                    }
                }
            }
        }

        $servCostDB = new ServCost();
        $isSuccess = $servCostDB->addDB($request, $month_arr);
        $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
        foreach ($servCosts as $servCost) {
            $servCost->beginDate = $beginDate;
            $servCost->endDate = $endDate;
        }
        if ($isSuccess == true) {
            $servCostDB = new ServCost();
            $region = $request->get('region_0');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            if ($beginDate != '' && $endDate != '') {
                $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
                foreach ($servCosts as $servCost) {
                    $servCost->beginDate = $beginDate;
                    $servCost->endDate = $endDate;
                }
            }
            return redirect('backend/servCost')->with('servCosts', $servCosts)->with('filter', $filter);
        } else {
            echo "<script language=javascript>alert('提交失败！');history.back();</script>";
        }

      */
        $filter = $request->all();
        $region = $request->input('region', '');
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');

        $startDate = $request->get('startDate');
        $stopDate = $request->get('stopDate');
        $isSuccess = DB::statement('call region_fee_service(?,?,?)', array($region, $startDate, $stopDate));
        $servCostDB = new ServCost();
        $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
        if ($beginDate == '' || $endDate == '') {
            $servCosts = null;
        }
        if (!empty($servCosts)) {
            foreach ($servCosts as $servCost) {
                $servCost->beginDate = $beginDate;
                $servCost->endDate = $endDate;
            }
        }

        if ($isSuccess == true) {
            $servCostDB = new ServCost();
            $region = $request->get('region_0');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            if ($beginDate != '' && $endDate != '') {
                $servCosts = $servCostDB->searchServCost($region, $beginDate, $endDate);
                foreach ($servCosts as $servCost) {
                    $servCost->beginDate = $beginDate;
                    $servCost->endDate = $endDate;
                }
            } else {
                $servCosts = $servCostDB->searchServCost('湖北省', $beginDate, $endDate);
                foreach ($servCosts as $servCost) {
                    $servCost->beginDate = $beginDate;
                    $servCost->endDate = $endDate;
                }
            }

            return redirect('backend/servCost')
                ->with('servCosts', $servCosts)
                ->with('filter', $filter)
                ->with('flag', 'add');;
        } else {
            echo "<script language=javascript>alert('提交失败！');history.back();</script>";
        }
    }


}
