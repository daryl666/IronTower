<?php

namespace App\Http\Controllers\Backend;

use App\Models\EventLog;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SiteCheck;
use Illuminate\Support\Facades\DB;
use Auth;

class SiteCheckController extends Controller
{

    //上站记录填报首页
    function indexPage(Request $request)
    {
        $filter = $request->all();
        $siteCheckDB = new SiteCheck();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('filter'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $region = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('提交成功')</script>";
                }
                if ($flag == 'update') {
                    echo "<script language='JavaScript'>alert('填报成功')</script>";
                }
                $siteChecks = $siteCheckDB->getSiteChecks($region, $checkStatus, $beginDate, $endDate)->paginate(15);
                return view('backend/siteCheck/index')
                    ->with('siteChecks', $siteChecks)
                    ->with('filter', $filter);
            } else {
                $regionName = $request->get('region');
                $checkStatus = $request->get('checkStatus');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $siteChecks = $siteCheckDB->getSiteChecks($regionName, $checkStatus, $beginDate, $endDate)->paginate(15);
                if ($checkStatus == 0) {
                    return view('backend/siteCheck/index')
                        ->with('siteChecks', $siteChecks)
                        ->with('filter', $filter);
                } else {
                    return view('backend/siteCheck/index-handled')
                        ->with('siteChecks', $siteChecks)
                        ->with('filter', $filter);
                }

            }
        }

    }


    //上站结果填报页面
    function handlePage($id, Request $request)
    {
        $filter = $request->all();
        $siteCheck = DB::table('site_check')
            ->where('id', $id)
            ->get();
        return view('backend/siteCheck/handle')
            ->with('siteCheck', $siteCheck)
            ->with('filter', $filter);
    }


    //新增上站申请页面
    function addPage()
    {
        return view('backend/siteCheck/add');
    }


    //添加上站申请
    function add(Request $request)
    {
        $eventLogDB = new EventLog();
        $siteCode = $request->get('siteCode');
        $siteInfo = DB::table('site_info')
            ->where('site_code', $siteCode)
            ->get();
        if (empty($siteInfo)) {
            echo "<script language=javascript>alert('该站址不存在！');history.back();</script>";
        } else {
            $checkReqTime = $request->get('checkReqTime');
            $checkType = $request->get('checkType');
            $regionName = $request->get('region');
            $filter = $request->all();
            $siteCheckDB = new SiteCheck();
            $siteCheckTimeValidate = $siteCheckDB->siteCheckTimeValidate($checkReqTime, $siteCode);
            if ($siteCheckTimeValidate == false) {
                echo "<script language=javascript>alert('该站正在屏蔽中，请重新确认上站时间！');history.back();</script>";
            } else {
                $addResult = $siteCheckDB->addSiteCheck($siteCode, $checkReqTime, $checkType, $regionName);
                if (!empty($addResult)) {
                    $filter['region'] = Auth::user()->area_level;
                    $filter['beginDate'] = '';
                    $filter['endDate'] = '';
                    $filter['checkStatus'] = 0;
                    $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报上站申请',
                        'site_check', '');
                    return redirect('backend/siteCheck')
                        ->with('filter', $filter)
                        ->with('region', $filter['region'])
                        ->with('beginDate', $filter['beginDate'])
                        ->with('endDate', $filter['endDate'])
                        ->with('checkStatus', $filter['checkStatus'])
                        ->with('siteChecks', 1)
                        ->with('flag', 'add');
                } else {
                    echo "<script language=javascript>alert('添加失败！');history.back();</script>";
                }
            }
        }


    }


    //填报上站结果
    function handle(Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $id = $request->get('id');
        $checkResult = $request->get('checkResult');
        $updateResult = DB::table('site_check')
            ->where('id', $id)
            ->update([
                'check_result' => transSiteCheckResult($checkResult),
                'check_status' => 1
            ]);
        if (!empty($updateResult)) {
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报上站结果',
                'site_check', '');
            return redirect('backend/siteCheck')
                ->with('filter', $filter)
                ->with('region', $filter['region'])
                ->with('beginDate', $filter['beginDate'])
                ->with('endDate', $filter['endDate'])
                ->with('checkStatus', $filter['checkStatus'])
                ->with('siteChecks', 1)
                ->with('flag', 'update');
        } else {
            echo "<script language=javascript>alert('填报失败！');history.back();</script>";
        }
    }

}
