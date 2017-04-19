<?php

namespace App\Http\Controllers\Backend;

use App\Models\EventLog;
use App\Models\SiteCheck;
use App\Models\SiteShield;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class SiteShieldController extends Controller
{
    /**
     * @param Request $request
     * @return $this
     */
    function indexPage(Request $request)
    {
        $filter = $request->all();
        $siteshieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('siteShieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $request->session()->pull('siteShieldsChecking');
//                if ($siteShields == 1) {
//                    $siteShields = null;
//                }
                return view('backend/siteShield/index-shield-checking')
                    ->with('siteShields', $siteShields);
            } elseif (!empty(session('siteShieldsApproved'))) {
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $request->session()->pull('siteShieldsApproved');
//                if ($siteShields == 1) {
//                    $siteShields = null;
//                }
                return view('backend/siteShield/index-shield-approved')
                    ->with('siteShields', $siteShields);
            } elseif (!empty(session('siteUnshieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $request->session()->pull('siteUnshieldsChecking');
//                if ($siteShields == 1) {
//                    $siteShields = null;
//                }
                return view('backend/siteShield/index-unshield-checking')
                    ->with('siteShields', $siteShields);
            } else {
                $regionName = $request->get('region');
                $checkStatus = $request->get('checkStatus');
                $reqType = $request->get('reqType');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $siteShields = $siteshieldDB->getSiteShields($regionName, $checkStatus, $reqType, $beginDate, $endDate)->paginate(15);
                if ($reqType == 0) {
                    if ($checkStatus == 1) {
                        return view('backend/siteShield/index-shield-checking')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    } elseif ($checkStatus == 2) {
                        return view('backend/siteShield/index-shield-approved')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    } elseif ($checkStatus == 3) {
                        return view('backend/siteShield/index-shield-denied')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    }
                } else {
                    if ($checkStatus == 1) {
                        return view('backend/siteShield/index-unshield-checking')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    } elseif ($checkStatus == 2) {
                        return view('backend/siteShield/index-unshield-approved')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    } elseif ($checkStatus == 3) {
                        return view('backend/siteShield/index-unshield-denied')
                            ->with('siteShields', $siteShields)
                            ->with('filter', $filter);
                    }
                }
            }
        }
    }

    function addShieldPage(Request $request)
    {
        return view('backend/siteShield/add-shield');

    }

    function addUnshieldPage($id)
    {
        $siteShields = DB::table('shield_info')
            ->where('id', $id)
            ->get();
        if ($siteShields[0]->shield_reason == transShieldReason('故障')) {
            return view('backend/siteShield/add-unshield-os')
                ->with('siteShields', $siteShields);
        } elseif ($siteShields[0]->shield_reason == transShieldReason('拆迁')) {
            return view('backend/siteShield/add-unshield-dem')
                ->with('siteShields', $siteShields);
        } elseif ($siteShields[0]->shield_reason == transShieldReason('拆迁还建')) {
            return view('backend/siteShield/add-unshield-rebuilt')
                ->with('siteShields', $siteShields);
        }

    }

    function addShield(Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $filter['region'] = Auth::user()->area_level;
        $filter['beginDate'] = '';
        $filter['endDate'] = '';
        $filter['checkStatus'] = 1;
        $regionName = Auth::user()->area_level;
        $stationCode = $request->get('stationCode');
        $stationName = $request->get('stationName');
        $stationLevel = $request->get('stationLevel');
        $shieldStartTime = $request->get('shieldStartTime');
        $shieldReason = $request->get('shieldReason');
        $demStartTime = $request->get('demStartTime');
        $estDemEndTime = $request->get('estDemEndTime');
        $demReason = $request->get('demReason');
        $siteShieldDB = new SiteShield();
        $addResult = $siteShieldDB->addSiteShield($regionName, $stationCode, $stationName, $stationLevel, $shieldStartTime, $shieldReason,
            $demStartTime, $estDemEndTime, $demReason);

        if (!empty($addResult)) {
            $siteShieldsChecking = $siteShieldDB->getSiteShields($regionName, 1, 0)->paginate(15);
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/shieldPage')
                ->with('flag', 'add')
                ->with('siteShieldsChecking', 1)
                ->with('region', $regionName)
                ->with('beginDate', '')
                ->with('endDate', '')
                ->with('checkStatus', 1)
                ->with('filter', $filter);

        } else {
            echo "<script language='JavaScript'>alert('申请失败！');history.back()</script>";
        }
    }

    function addUnshield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $filter['region'] = Auth::user()->area_level;
        $filter['beginDate'] = '';
        $filter['endDate'] = '';
        $filter['checkStatus'] = 2;
        $regionName = Auth::user()->area_level;
        $siteShieldDB = new SiteShield();
        $osReason = $request->get('osReason');
        $osDetail = $request->get('osDetail');
        $respUnit = $request->get('respUnit');
        $shieldEndTime = $request->get('shieldEndTime');
        $newStationCode = $request->get('newStationCode');
        $newStationName = $request->get('newStationName');
        $newSiteCode = $request->get('newSiteCode');
        $addResult = $siteShieldDB->addSiteUnshield($id, $osReason, $osDetail, $respUnit,
            $shieldEndTime, $newStationCode, $newStationName, $newSiteCode);
        if (!empty($addResult)) {
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报解屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/shieldPage')
                ->with('siteShieldsApproved', 1)
                ->with('flag', 'add')
                ->with('region', $regionName)
                ->with('beginDate', '')
                ->with('endDate', '')
                ->with('checkStatus', 2)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('申请失败！');history.back()</script>";
        }

    }

    function withdrawShield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $regionName = Auth::user()->area_level;
        $withdrawResult = DB::table('shield_info')
            ->where('id', $id)
            ->delete();
        if (!empty($withdrawResult)) {
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $filter['region'] = Auth::user()->area_level;
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '撤回屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/shieldPage')
                ->with('siteShieldsChecking', 1)
                ->with('flag', 'withdraw')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('撤回失败！');history.back()</script>";
        }
    }

    function withdrawUnshield($id, Request $request)
    {
        $regionName = Auth::user()->area_level;
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $withdrawResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'os_reason' => null,
                'os_detail' => null,
                'response_unit' => null,
                'unshield_req_proc_state' => null,
                'shield_end_time' => null,
                'demolition_reason' => null,
                'demolition_start_time' => null,
                'new_station_code' => null,
                'new_station_name' => null,
                'new_site_code' => null,
            ]);
        if (!empty($withdrawResult)) {
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $filter['region'] = Auth::user()->area_level;
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '撤回解屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/unshieldPage')
                ->with('flag', 'withdraw')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('filter', $filter)
                ->with('siteUnshieldsChecking', 1);
        } else {
            echo "<script language='JavaScript'>alert('撤回失败！');history.back()</script>";
        }
    }

    function approveShield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $approveResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'shield_req_proc_state' => 2,
                'shield_state' => 2
            ]);
        if (!empty($approveResult)) {
            $siteShield = DB::table('shield_info')
                ->where('id', $id)
                ->get();
            $shieldReason = $siteShield[0]->shield_reason;
            $stationCode = $siteShield[0]->station_code;
            $regionName = $siteShield[0]->region_name;
            $shieldStartTime = $siteShield[0]->shield_start_time;
            if ($shieldReason == transShieldReason("拆迁") || $shieldReason == transShieldReason('拆迁还建')) {
                $siteCheckDB = new SiteCheck();
                $addSiteCheck = $siteCheckDB->addSiteCheck($stationCode, $shieldStartTime, '紧急上站', $regionName, $id);
            }
            $filter = $request->all();
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $filter['region'] = $request->get('region');
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '审核通过屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/checkShieldPage')
                ->with('flag', 'check')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('siteShieldsChecking', 1)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('审核失败！');history.back()</script>";
        }
    }

    function approveUnshield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $regionName = Auth::user()->area_level;
        $approveResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'unshield_req_proc_state' => 2,
                'shield_state' => 3
            ]);
        $siteShield = DB::table('shield_info')
            ->where('id', $id)
            ->get();
        $shieldReason = $siteShield[0]->shield_reason;
        $shieldEndTime = $siteShield[0]->shield_end_time;
        $stationCode = $siteShield[0]->station_code;
        $stationName = $siteShield[0]->station_name;
        $demTime = explode('-', $shieldEndTime);
        $month = $demTime[0] . '-' . $demTime[1];
        if ($shieldReason == transShieldReason('拆迁')) {
            DB::table('demolition_record')
                ->insert([
                    'region_name' => $siteShield[0]->region_name,
                    'month' => $month,
                    'station_code' => $stationCode,
                    'station_name' => $stationName
                ]);
        } elseif ($shieldReason == transShieldReason('故障')) {
            $currentTime = date('Y-m-d H:i:s', time());
            $currentTime = explode('-', $currentTime);
            $currentMonth = $currentTime[0] . '-' . $currentTime[1];
            $osStartTime = $siteShield[0]->shield_start_time;
            $osStartTimeArr = explode('-', $osStartTime);
            $osStartMonth = $osStartTimeArr[0] . '-' . $osStartTimeArr[1];
            $osEndTime = $siteShield[0]->shield_end_time;
            $osReason = $siteShield[0]->os_reason;
            $osDetail = $siteShield[0]->os_detail;
            $respUnit = $siteShield[0]->response_unit;
            if ($currentMonth != $osStartMonth) {
                $osStartTime = $currentMonth . '-01' . ' 00:00:00';
            }
            $isSuccess = DB::statement('call sh2os(?,?,?,?,?,?,?)', array(transRegion($siteShield[0]->region_name), $siteShield[0]->station_code,
                $siteShield[0]->station_name, $osStartTime, $osEndTime, transOsReason($osReason), transRespUnit($respUnit)));
        } elseif ($shieldReason == transShieldReason('拆迁还建')) {
            $demStartTime = $siteShield[0]->dem_start_time;
            $demStartTime = explode('-', $demStartTime);
            $demStartMonth = $demStartTime[0] . '-' . $demStartTime[1];
            $currentTime = date('Y-m-d H:i:s', time());
            $currentTime = explode('-', $currentTime);
            $currentMonth = $currentTime[0] . '-' . $currentTime[1];
            $siteCheckDB = new SiteCheck();
            $shieldStartTime = $siteShield[0]->shield_start_time;
            $addSiteCheck = $siteCheckDB->addSiteCheck($stationCode, $shieldStartTime, '紧急上站', $regionName, $id);
            if ($currentMonth != $demStartMonth) {
                $osStartTime = $currentMonth . '-01' . ' 00:00:00';
                $osEndTime = $shieldEndTime;
                $osReason = '拆迁还建';
                $demReason = $siteShield[0]->dem_reason;
                $respUnit = ($demReason == '物业纠纷') ? '铁塔' : '其他';
                $isSuccess = DB::statement('call sh2os(?,?,?,?,?,?,?)', array(transRegion($siteShield[0]->region_name), $siteShield[0]->station_code,
                    $siteShield[0]->station_name, $osStartTime, $osEndTime, transOsReason($osReason), transRespUnit($respUnit)));

            }
        }
        if (!empty($approveResult)) {
            $filter = $request->all();
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $regionName = $request->get('region');
            $filter['region'] = $request->get('region');
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '审核通过解屏蔽记录',
                'site_shield', '');
            return redirect('backend/siteShield/checkUnshieldPage')
                ->with('flag', 'check')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('siteUnshieldsChecking', 1)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('审核失败！');history.back()</script>";
        }
    }

    function denyShield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $denyResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'shield_req_proc_state' => 3
            ]);
        if (!empty($denyResult)) {
            $filter = $request->all();
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $filter['region'] = $request->get('region');
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '驳回屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/checkShieldPage')
                ->with('flag', 'check')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('siteShieldsChecking', 1)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('审核失败！');history.back()</script>";
        }
    }

    function denyUnshield($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $denyResult = DB::table('shield_info')
            ->where('id', $id)
            ->update([
                'unshield_req_proc_state' => 3
            ]);
        if (!empty($denyResult)) {
            $filter = $request->all();
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $filter['region'] = $request->get('region');
            $filter['beginDate'] = $beginDate;
            $filter['endDate'] = $endDate;
            $filter['checkStatus'] = 1;
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '驳回解屏蔽申请',
                'site_shield', '');
            return redirect('backend/siteShield/checkUnshieldPage')
                ->with('flag', 'check')
                ->with('region', $regionName)
                ->with('beginDate', $beginDate)
                ->with('endDate', $endDate)
                ->with('checkStatus', 1)
                ->with('siteUnshieldsChecking', 1)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('审核失败！');history.back()</script>";
        }
    }

    function checkShieldPage(Request $request)
    {
        $siteShieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('siteShieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $regionName = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
            } else {
                $filter = $request->all();
                $regionName = $request->get('region');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $checkStatus = 1;
            }
            $siteShields = $siteShieldDB->getSiteShields($regionName, $checkStatus, 0, $beginDate, $endDate)->paginate(15);
            return view('backend.siteShield.check-shield')
                ->with('siteShields', $siteShields)
                ->with('filter', $filter);
        } else {
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $siteShields = $siteShieldDB->getSiteShields($regionName, 1, 0, $beginDate, $endDate);
            return view('backend.siteShield.check-shield')
                ->with('siteShields', $siteShields);
        }

    }

    function checkUnshieldPage(Request $request)
    {
        $siteShieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('siteUnshieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $regionName = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
            } else {
                $filter = $request->all();
                $regionName = $request->get('region');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                $checkStatus = 1;
            }
            $siteShields = $siteShieldDB->getSiteShields($regionName, $checkStatus, 1, $beginDate, $endDate)->paginate(15);
            return view('backend.siteShield.check-unshield')
                ->with('siteShields', $siteShields)
                ->with('filter', $filter);
        } else {
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $siteShields = $siteShieldDB->getSiteShields($regionName, 1, 1, $beginDate, $endDate);
            return view('backend.siteShield.check-unshield')
                ->with('siteShields', $siteShields);
        }

    }

    function shieldPage(Request $request)
    {
        $siteShieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('siteShieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $region = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $siteShieldDB->getSiteShields($region, $checkStatus, 0, $beginDate, $endDate)->paginate(15);
                return view('backend/siteShield/index-shield-checking')
                    ->with('siteShields', $siteShields)
                    ->with('filter', $filter);
            } elseif (!empty(session('siteShieldsApproved'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $region = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $siteShieldDB->getSiteShields($region, $checkStatus, 0, $beginDate, $endDate)->paginate(15);
                return view('backend/siteShield/index-shield-approved')
                    ->with('siteShields', $siteShields)
                    ->with('filter', $filter);
            } else {
                $filter = $request->all();
                $checkStatus = $request->get('checkStatus');
                $regionName = $request->get('region');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                if ($checkStatus == 1) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 1, 0, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-shield-checking')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                } elseif ($checkStatus == 2) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 2, 0, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-shield-approved')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                } elseif ($checkStatus == 3) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 3, 0, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-shield-denied')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                }
            }
        }
    }

    function unshieldPage(Request $request)
    {
        $siteShieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('siteUnshieldsChecking'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $region = $request->session()->pull('region');
                $beginDate = $request->session()->pull('beginDate');
                $endDate = $request->session()->pull('endDate');
                $checkStatus = $request->session()->pull('checkStatus');
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('申请成功！')</script>";
                } elseif ($flag == 'withdraw') {
                    echo "<script language='JavaScript'>alert('撤回成功！')</script>";
                } elseif ($flag == 'check') {
                    echo "<script language='JavaScript'>alert('审核成功！')</script>";
                }
                $siteShields = $siteShieldDB->getSiteShields($region, $checkStatus, 1, $beginDate, $endDate)->paginate(15);
                return view('backend/siteShield/index-unshield-checking')
                    ->with('siteShields', $siteShields)
                    ->with('filter', $filter);
            } else {
                $filter = $request->all();
                $checkStatus = $request->get('checkStatus');
                $regionName = $request->get('region');
                $beginDate = $request->get('beginDate');
                $endDate = $request->get('endDate');
                if ($checkStatus == 1) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 1, 1, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-unshield-checking')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                } elseif ($checkStatus == 2) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 2, 1, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-unshield-approved')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                } elseif ($checkStatus == 3) {
                    $siteShields = $siteShieldDB->getSiteShields($regionName, 3, 1, $beginDate, $endDate)->paginate(15);
                    return view('backend/siteShield/index-unshield-denied')
                        ->with('siteShields', $siteShields)
                        ->with('filter', $filter);
                }
            }
        }
    }

    function shieldCheckingPage(Request $request)
    {
        $siteShieldDB = new SiteShield();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $filter = $request->all();
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $siteShields = $siteShieldDB->getSiteShields($regionName, 2, 0, $beginDate, $endDate)->paginate(15);
            return view('backend/siteShield/add-unshield')
                ->with('siteShields', $siteShields)
                ->with('filter', $filter);
        } else {
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $siteShields = $siteShieldDB->getSiteShields($regionName, 2, 0, $beginDate, $endDate);
            return view('backend/siteShield/add-unshield')
                ->with('siteShields', $siteShields);
        }

    }


}
