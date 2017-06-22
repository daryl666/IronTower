<?php

namespace App\Http\Controllers\Backend;

use App\Models\BillCheck;
use App\Models\BillOut;
use App\Models\BillOutSite;
use App\Models\CustomPaginator;
use App\Models\FeeOutSite;
use App\Models\FeeOutSitePrice;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FeeOut;
use Log;
use DB;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class ServBillController extends Controller
{


    public function indexPage(Request $request)
    {
        $filter = $request->all();
        $region = $request->input('region', '');
        $beginDate = $request->input('beginDate', '');
        $endDate = $request->input('endDate', '');
        $outStatus = intval($request->input('out_status', '0'));

        $feeOutDB = new FeeOut();
        if ($outStatus == 0) {
            // 未出账逻辑，查询所有未出账的发电记录
//            $feeFree = $feeOutDB->getFreeGnrFees($region, $beginDate, $endDate);
//            $feeFreeAll = $feeOutDB->getFreeGnrFees($region);
            $feeOuts = $feeOutDB->getFeeOuts($region, $beginDate, $endDate, $outStatus);
//            $dayRange = $beginDate.' - '.$endDate;
//            if($beginDate == '' && $endDate == ''){
//                $dayRange = '所有';
//            }

            return view('backend/servBill/index')
                ->with('feeouts', $feeOuts)
                ->with('filter', $filter);
        } else {
            // 已出账
            $feeOuts = $feeOutDB->getFeeOuts($region, $beginDate, $endDate, $outStatus);
            return view('backend/servBill/index-outed')->with('feeouts', $feeOuts)
                ->with('filter', $filter);
        }

//        $query = FeeOut::query();
//        if( isset($filter['beginDate']) && $filter['beginDate'] ){
//            $query->where('start_day', '>=', $filter['beginDate']);
//        }
//
//        if( isset($filter['endDate']) && $filter['endDate'] ){
//            $query->where('end_day', '<=', $filter['endDate']);
//        }
//
//        if( isset($filter['region']) && $filter['region'] ){
//            $query->where('region_id', '=', $filter['region']);
//        }

//        $list = $query->orderBy('created_at','desc')->get();

//            ->with('filter',$filter)->with('list', $list);
    }

    public function viewFreeGnrPage(Request $request)
    {
        $region = $request->input('region', '');
        $beginDate = $request->input('beginDate', '');
        $endDate = $request->input('endDate', '');
        $feeOutDB = new FeeOut();
        // TODO 仅查询时间范围内的账单
        $gnrs = $feeOutDB->getFreeGnrList($region);
        return view('backend/servBill/gnr-free')->with('gnrs', $gnrs)->with('region', $region)
            ->with('beginDate', $beginDate)->with('endDate', $endDate);
    }

    public function viewBillGnrPage(Request $request)
    {
        $outId = $request->input('out_id', '0');
        $regionID = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('region_id');
        $month = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);

        // xv
//        $gnrs = $feeOutDB->getBillGnrList($outId);
//        dd($region.$beginDate.$endDate);
        $gnrs = $feeOutDB->getBillGnrList($regionID, $month);
        return view('backend/servBill/gnr-bill')
            ->with('gnrs', $gnrs)
            ->with('bill', $bill);
    }


    public function createBill(Request $request)
    {
        $region = $request->input('region', '');
        $beginDate = $request->input('beginDate', '');
        $endDate = $request->input('endDate', '');

        DB::beginTransaction();
        $bill = new FeeOut();
        $bill->region_name = $region;
        $bill->start_day = $beginDate;
        $bill->end_day = $endDate;
        $bill->operator = $request->user()->id;
        $bill->save();
        $biilId = $bill->id;

        // 更新所有时间范围内的所有未付款账单
        $bill->attachGnrToBill($biilId, $region, $beginDate, $endDate);
        $bill->attachSiteToBill($biilId, $request->user()->id, $region, $beginDate, $endDate);
        $bill->updateBill($biilId);
        DB::commit();

        return response()->json(['code' => 0, 'bill_id' => $bill->id]);
    }

    public function viewSitePage(Request $request)
    {
        $outId = $request->input('out_id', '0');
        $region_id = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('region_id');
        $region = transRegion($region_id[0]);
        $month = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);
        //$sites = $feeOutDB->getBillSites($outId);
        $sites = $feeOutDB->getBillSites($region, $month)
            ->paginate(15);
        return view('backend/servBill/site')->with('sites', $sites)->with('bill', $bill)->with('region', $region);
    }

    public function viewDeduction1Page(Request $request)
    {
        $outId = $request->input('out_id', '0');
        $region = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('region_name');
        $month = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);
        //$sites = $feeOutDB->getBillSites($outId);
        $deduction1 = $feeOutDB->getDeduction1($region, $month);
        return view('backend/servBill/deduction1')->with('deduction1', $deduction1)->with('bill', $bill)->with('region', $region);
    }

    public function viewDeduction2Page(Request $request)
    {
        $outId = $request->input('out_id', '0');
        $region = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('region_name');
        $month = DB::table('fee_out')
            ->where('id', $outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);
        //$sites = $feeOutDB->getBillSites($outId);
        $deduction2 = $feeOutDB->getDeduction2($region, $month);
        return view('backend/servBill/deduction2')->with('deduction2', $deduction2)->with('bill', $bill)->with('region', $region);
    }


    public function doOut(Request $request)
    {
        $outId = $request->input('out_id', '0');
        $billOutDB = new BillOut();
        $billOutSiteDB = new BillOutSite();
        DB::beginTransaction();
        $bill = FeeOut::find($outId);
        $bill->is_out = 1;
        $bill->operator = $request->user()->id;
        $bill->update();
        DB::commit();
        $billOutId = $billOutDB->store($bill);
        $billOutSites = FeeOutSite::where('start_day', $bill->month)
            ->where('region_id', $bill->region_id)
            ->get();
        foreach ($billOutSites as $billOutSite) {
            $billOutSiteDB->store($billOutSite, $billOutId);
        }
        return response()->json(['code' => 0]);
    }

    public function billCheck(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return view('backend.servBill.billCheck-bill');
        } else {
            $filter = $request->all();
            $billCheckDB = new BillCheck();
            $month = $request->get('month');
            $region = $request->get('region');
            $bills = $billCheckDB->getDiffBills($month, $region);
            $ironTowerBills = $bills[0];
            $telecomBills = $bills[1];
            return view('backend.servBill.billCheck-bill')
                ->with('telecomBills', $telecomBills)
                ->with('ironTowerBills', $ironTowerBills)
                ->with('filter', $filter);
        }


    }

    public function orderCheck($id, Request $request)
    {
        $telecomBill = DB::table('fee_out')
            ->where('id', $id)
            ->get();
        $month = $telecomBill[0]->month;
        $region = $telecomBill[0]->region_id;
        $filter['month'] = $month;
        $filter['region'] = $region;
        $billCheckDB = new BillCheck();
        $ordersDiff = $billCheckDB->getDiffOrders($month, transRegion($region));
        $customPaginator = new CustomPaginator();
        $paginators = $customPaginator->paginate($request, $ordersDiff, 15);

        return view('backend.servBill.billCheck-order')
            ->with('orders', $paginators)
            ->with('filter', $filter);
    }

    public function viewOrders($id)
    {
        $ironTowerBillOrder = FeeOutSite::findOrFail($id);
        $month = $ironTowerBillOrder->start_day;
        $businessCode = $ironTowerBillOrder->business_code;
        $siteInfoDB = new SiteInfo();
        $telecomOrders = $siteInfoDB->getOrders($businessCode, $month);
        return view('backend.servBill.orders-to-edit')
            ->with('telecomOrders', $telecomOrders)
            ->with('month', $month);
    }

    public function editPage(Request $request, $id)
    {
        $month = $request->get('month');
        $telecomOrder = DB::table('site_info')
            ->where('id', $id)
            ->get();
        return view('backend.servBill.edit')
            ->with('telecomOrder', $telecomOrder[0])
            ->with('month', $month);
    }

    public function irontowerBillImportPage()
    {
        return view('backend.servBill.irontower-bill-import');
    }


    public function updateOrder(Request $request, $id)
    {
        $orderToUpdate = SiteInfo::findOrFail($id);
        $month = $request->get('month');
        $establishedTime = $orderToUpdate->established_time;
        $regionId = $orderToUpdate->region_id;
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
                echo "<script language=javascript>alert('系统1高度有错误！');window.history.go(-2)</script>";
            } elseif (empty($fee_tower2)) {
                echo "<script language=javascript>alert('系统2高度有错误！');history.back()</script>";
            } elseif (empty($fee_tower3)) {
                echo "<script language=javascript>alert('系统3高度有错误！');history.back()</script>";
            }
            $business_code = $request->get('businessCode');
            $site_code = $request->get('siteCode');
            $site_name = $request->get('siteName');
            $cdma_code = $request->get('cdmaCode');
            $lte_code = $request->get('lteCode');
            $req_code = $request->get('reqCode');
            $region_name = transRegion($regionId);
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


            /*
             * 插入价格记录
             */
            $site_price = FeeOutSitePrice::findOrFail($orderToUpdate->fee_out_site_price_table_id);

            //获取共享折扣
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
            //获取基准价格
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

            $updSitePrice = FeeOutSitePrice::whereId($orderToUpdate->fee_out_site_price_table_id)
                ->update([
                    'is_valid' => 0,
                    'is_right' => 0
                ]);
            $insSitePrice =  FeeOutSitePrice::create([
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

            $updateSiteInfo = SiteInfo::whereId($id)
                ->update([
                    'is_right' => 0,
                    'is_valid' => 0
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
                'established_time' => $establishedTime,
                'fee_out_site_price_table_id' => $insSitePrice->id

            ]);
            if ($insSitePrice && $insSiteInfo) {
                $isSuccess = DB::statement('call bill_again(?,?,?)', array(transRegion($region_name), $business_code, $month));
                echo "<script language=javascript>alert('修改成功！');history.back();</script>";
            } else {
                echo "<script language=javascript>alert('修改失败！');history.back();</script>";
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
                echo "<script language=javascript>alert('系统1高度有错误！');history.back()</script>";
            } elseif (empty($fee_tower2)) {
                echo "<script language=javascript>alert('系统2高度有错误！');history.back()</script>";
            } elseif (empty($fee_tower3)) {
                echo "<script language=javascript>alert('系统3高度有错误！');history.back()</script>";
            }
            $business_code = $request->get('businessCode');
            $site_code = $request->get('siteCode');
            $site_name = $request->get('siteName');
            $cdma_code = $request->get('cdmaCode');
            $lte_code = $request->get('lteCode');
            $req_code = $request->get('reqCode');
            $region_name = transRegion($regionId);
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
            $site_price = FeeOutSitePrice::findOrFail($orderToUpdate->fee_out_site_price_table_id);

            $tower_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->where('share_num', transShareType($share_num_tower))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_basic');
            if (!empty($tower_share_discount)) {
                $tower_share_discount = $tower_share_discount[0];
            } else {
                $tower_share_discount = 1;
            }

            $house_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->where('share_num', transShareType($share_num_house))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_basic');
            if (!empty($house_share_discount)) {
                $house_share_discount = $house_share_discount[0];
            } else {
                $house_share_discount = 1;
            }
            $support_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->where('share_num', transShareType($share_num_support))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_basic');
            if (!empty($support_share_discount)) {
                $support_share_discount = $support_share_discount[0];
            } else {
                $support_share_discount = 1;
            }
            $maintain_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', 1)
                ->where('share_num', transShareType($share_num_maintain))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_basic');
            if (!empty($maintain_share_discount)) {
                $maintain_share_discount = $maintain_share_discount[0];
            } else {
                $maintain_share_discount = 1;
            }
            $fee_house1 = DB::table('fee_house_std')
                ->where('tower_type', transTowerType($tower_type))
                ->where('product_type', transProductType($product_type))
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->pluck('fee_house');
            if (!empty($fee_house1)) {
                $fee_house1 = $fee_house1[0];
            } else {
                $fee_house1 = 0;
            }
            $fee_support1 = DB::table('fee_support_std')
                ->where('tower_type', transTowerType($tower_type))
                ->where('product_type', transProductType($product_type))
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->pluck('fee_support');
            if (!empty($fee_support1)) {
                $fee_support1 = $fee_support1[0];
            } else {
                $fee_support1 = 0;
            }
            $fee_maintain1 = DB::table('fee_maintain_std')
                ->where('tower_type', transTowerType($tower_type))
                ->where('product_type', transProductType($product_type))
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->pluck('fee_maintain');
            if (!empty($fee_maintain1)) {
                $fee_maintain1 = $fee_maintain1[0];
            } else {
                $fee_maintain1 = 0;
            }
            if (!empty($sys1_height)) {
                $fee_tower1 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($tower_type))
                    ->where('sys_height', transSysHeight($sys1_height))
                    ->where('is_new_tower', transIsNewTower($is_new_tower))
                    ->pluck('fee_tower');
                if (!empty($fee_tower1)) {
                    $fee_tower1 = $fee_tower1[0];
                } else {
                    $fee_tower1 = 0;
                }

            } else {
                $fee_tower1 = 0;
                $fee_house1 = 0;
                $fee_support1 = 0;
                $fee_maintain1 = 0;
            }
            if (!empty($sys2_height)) {
                $fee_tower2 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($tower_type))
                    ->where('sys_height', transSysHeight($sys1_height))
                    ->where('is_new_tower', transIsNewTower($is_new_tower))
                    ->pluck('fee_tower');
                if (!empty($fee_tower2)) {
                    $fee_tower2 = $fee_tower2[0];
                } else {
                    $fee_tower2 = 0;
                }
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
                $fee_tower3 = DB::table('fee_tower_std')
                    ->where('tower_type', transTowerType($tower_type))
                    ->where('sys_height', transSysHeight($sys1_height))
                    ->where('is_new_tower', transIsNewTower($is_new_tower))
                    ->pluck('fee_tower');
                if (!empty($fee_tower3)) {
                    $fee_tower3 = $fee_tower3[0];
                } else {
                    $fee_tower3 = 0;
                }
                $fee_house3 = $fee_house1;
                $fee_maintain3 = $fee_maintain1;
                $fee_support3 = $fee_support1;
            } else {
                $fee_tower3 = 0;
                $fee_house3 = 0;
                $fee_support3 = 0;
                $fee_maintain3 = 0;
            }

            $site_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->where('share_num', transShareType($share_num_site))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_site');
            if (!empty($site_share_discount)) {
                $site_share_discount = $site_share_discount[0];
            } else {
                $site_share_discount = 1;
            }
            $import_share_discount = DB::table('share_discount_std')
                ->where('is_new_tower', transIsNewTower($is_new_tower))
                ->where('share_num', transShareType($share_num_import))
                ->where('user_type', transUserType($user_type))
                ->where('is_newly_added', $is_newly_added)
                ->pluck('discount_import');
            if (!empty($import_share_discount)) {
                $import_share_discount = $import_share_discount[0];
            } else {
                $import_share_discount = 1;
            }
            if ($sys_num1 >= 1) {
                $fee_site = DB::table('fee_site_std')
                    ->where('region_id', transRegion($region_name))
                    ->where('site_district_type', transSiteDistType($site_district_type))
                    ->where('is_rru_away', transIsRRUAway($is_rru_away))
                    ->pluck('fee_site');
                if (!empty($fee_site)) {
                    $fee_site = $fee_site[0];
                } else {
                    $fee_site = 0;
                }
                $fee_import = DB::table('fee_import_std')
                    ->where('region_id', transRegion($region_name))
                    ->where('elec_introduced_type', transElecType($elec_introduced_type))
                    ->pluck('fee_import');
                if (!empty($fee_import)) {
                    $fee_import = $fee_import[0];
                } else {
                    $fee_import = 0;
                }
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

            $updSitePrice = FeeOutSitePrice::whereId($orderToUpdate->fee_out_site_price_table_id)
                ->update([
                    'is_valid' => 0,
                    'is_right' => 0
                ]);
            $insSitePrice =  FeeOutSitePrice::create([
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

            $updateSiteInfo = SiteInfo::whereId($id)
                ->update([
                    'is_valid' => 0,
                    'is_right' => 0
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
                'established_time' => $establishedTime,
                'fee_out_site_price_table_id' => $insSitePrice->id

            ]);
            if ($insSitePrice && $insSiteInfo) {
                $isSuccess = DB::statement('call bill_again(?,?,?)', array(transRegion($region_name), $business_code, $month));
                echo "<script language=javascript>alert('修改成功！');history.back();</script>";
            } else {
                echo "<script language=javascript>alert('修改失败！');history.back();</script>";
            }
        }

    }


}
