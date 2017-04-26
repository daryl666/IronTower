<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\FeeOut;
use Log;
use DB;

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
        if($outStatus == 0){
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
        $region = $request->input('region','');
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
        $outId = $request->input('out_id','0');
        $regionID = DB::table('fee_out')
            ->where('id',$outId)
            ->pluck('region_id');
        $month = DB::table('fee_out')
            ->where('id',$outId)
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
        $region = $request->input('region','');
        $beginDate = $request->input('beginDate','');
        $endDate = $request->input('endDate','');

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
        $outId = $request->input('out_id','0');
        $region_id = DB::table('fee_out')
            ->where('id',$outId)
            ->pluck('region_id');
        $region = transRegion($region_id[0]);
        $month = DB::table('fee_out')
            ->where('id',$outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);
        //$sites = $feeOutDB->getBillSites($outId);
        $sites = $feeOutDB->getBillSites($region, $month)
        ->paginate(15);
        return view('backend/servBill/site')->with('sites', $sites)->with('bill', $bill)->with('region',$region);
    }

    public function viewDeduction1Page(Request $request)
    {
        $outId = $request->input('out_id','0');
        $region = DB::table('fee_out')
            ->where('id',$outId)
            ->pluck('region_name');
        $month = DB::table('fee_out')
            ->where('id',$outId)
            ->pluck('month');
        $feeOutDB = new FeeOut();
        $bill = FeeOut::find($outId);
        //$sites = $feeOutDB->getBillSites($outId);
        $deduction1 = $feeOutDB->getDeduction1($region, $month);
        return view('backend/servBill/deduction1')->with('deduction1', $deduction1)->with('bill', $bill)->with('region',$region);
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
        $outId = $request->input('out_id','0');
        $feeOutDB = new FeeOut();

        DB::beginTransaction();
        $bill = FeeOut::find($outId);
        $bill->is_out = 1;
        $bill->operator = $request->user()->id;
        $bill->update();

        DB::commit();

        return response()->json(['code' => 0]);
    }
}
