<?php

namespace App\Http\Controllers\Backend;

use App\Models\EventLog;
use App\Models\GnrRec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SiteInfo;
use Illuminate\Support\Facades\Session;
use Excel;
use App\Http\Controllers\Controller;
use Auth;

class GnrRecController extends Controller
{

    public function my_sort($arrays, $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC)
    {
        if (is_array($arrays)) {
            foreach ($arrays as $array) {
                $key_arrays[] = $array[$sort_key];
            }
        } else {
            return false;
        }
        array_multisort($key_arrays, $sort_order, $sort_type, $arrays);
        return $arrays;
    }

    public function indexPage(Request $request)
    {
        $filter = $request->all();
        $gnrRecDB = new GnrRec();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filter = $request->all();
            $checkStatus = intval($request->input('checkStatus', '0'));
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            $regionName = $request->get('region');
            $gnrRecs = $gnrRecDB->searchGnr($regionName, $checkStatus, $beginDate, $endDate);
            if ($checkStatus == 0) {
                return view('backend/gnrRec/index')
                ->with('filter', $filter)
                ->with('gnrRecs', $gnrRecs);
            } elseif ($checkStatus == 1) {
                return view('backend/gnrRec/index-handled')
                ->with('filter', $filter)
                ->with('gnrRecs', $gnrRecs);
            }
        } else {
            // if (!empty(session('filter'))) {
            //     $siteInfos = $request->session()->pull('siteInfos');
            //     $filter = $request->session()->pull('filter');
            //     $region = $request->session()->pull('region');
            //     $beginDate = $request->session()->pull('beginDate');
            //     $endDate = $request->session()->pull('endDate');
            //     $checkStatus = $request->session()->pull('checkStatus');
            //     $flag = $request->session()->pull('flag');
            //     if ($flag == 'add') {
            //         echo "<script language=javascript>alert('提交成功！');</script>";
            //     } elseif ($flag == 'update') {
            //         echo "<script language=javascript>alert('修改成功！');</script>";
            //     } elseif ($flag == 'delete') {
            //         echo "<script language=javascript>alert('删除成功！');</script>";
            //     } elseif ($flag == 'import') {
            //         echo "<script language=javascript>alert('导入成功！');</script>";
            //     }
            //     $gnrRecs = $gnrRecDB->searchGnr($region, $checkStatus, $beginDate, $endDate)->paginate(15);
            //     return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
            //     ->with('gnrRecs', $gnrRecs)
            //     ->with('filter', $filter);
            // } else {
            if (!empty(session('flag'))) {
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language=javascript>alert('提交成功！');</script>";
                } elseif ($flag == 'update') {
                    echo "<script language=javascript>alert('修改成功！');</script>";
                } elseif ($flag == 'delete') {
                    echo "<script language=javascript>alert('删除成功！');</script>";
                } elseif ($flag == 'import') {
                    echo "<script language=javascript>alert('导入成功！');</script>";
                }
            }
            $filter = $request->all();
            $regionName = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('$endDate');
            $checkStatus = $request->get('checkStatus');
            $gnrRecs = $gnrRecDB->searchGnr($regionName, $checkStatus, $beginDate, $endDate)->paginate(15);
            if ($checkStatus == 0) {
                return view('backend/gnrRec/index')
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter);
            } else {
                return view('backend/gnrRec/index-handled')
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter);
            }


        }


    }

    public function indexPage_siteinfo(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $filter = $request->all();
            $filter['siteChoose'] = null;
            $region = $request->input('region', '');
            $siteinfoDB = new SiteInfo();
            $gnrrecDB = new GnrRec();
            $stationCode = $request->get('stationCode');
//            if ($stationCode != '') {
//                $siteInfos = DB::table('site_info')
                   // ->where('site_code', 'like', '%' . $stationCode . '%')
//                    ->get();
//            } else {
            $siteInfos = $siteinfoDB->searchInfoSite($region, $stationCode);
//            }
            if (!empty($siteInfos)) {
                foreach ($siteInfos as $siteInfo) {
                    $gnrRec = $gnrrecDB->searchGnr($siteInfo->site_code, '1');
                    $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_len_minute');
                    $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
                    $gnr_total_len_minutes = $gnr_total_len_minute % 60;
                    $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
                    $gnr_num = count($gnrRec);
                    $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_fee');
                    $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteInfo->site_code)->sum('gnr_fee_taxed');
                    if (!empty($gnrRec)) {
                        $siteInfo->last_gnr_time = $gnrRec[0]->gnr_stop_time;
                        $siteInfo->gnr_total_len = $gnr_total_len;
                        $siteInfo->gnr_num = $gnr_num;
                        $siteInfo->gnr_total_fee = $gnr_total_fee;
                        $siteInfo->gnr_total_fee_taxed = $gnr_total_fee_taxed;
                    }
                    if (empty($gnrRec)) {
                        $siteInfo->last_gnr_time = '';
                        $siteInfo->gnr_total_len = '';
                        $siteInfo->gnr_num = '';
                        $siteInfo->gnr_total_fee = '';
                        $siteInfo->gnr_total_fee_taxed = '';
                    }
                }
                $siteInfos = json_encode($siteInfos);
                $siteInfos = json_decode($siteInfos, true);
                $siteInfos = $this->my_sort($siteInfos, 'last_gnr_time', SORT_DESC, SORT_STRING);
                $siteInfos = json_encode($siteInfos);
                $siteInfos = json_decode($siteInfos);
                return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
                ->with('filter', $filter);
            } else {
                return view('backend/gnrRec/index')
                ->with('filter', $filter);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            return view('backend/gnrRec/index');
        }


    }

    public function indexPage_gnr(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filter = $request->all();
            $siteID_1 = intval($request->get('siteChoose'));
            $siteID_2 = $request->get('siteID');
            $siteID = (empty($siteID_2)) ? $siteID_1 : $siteID_2;
            $checkStatus = intval($request->input('checkStatus', '0'));
            $siteinfoDB = new SiteInfo();
            $gnrrecDB = new GnrRec();
            $siteInfos = $siteinfoDB->searchInfoSiteById($siteID);
            $siteCode = $siteInfos[0]->site_code;
            $allGnrRecs = $gnrrecDB->searchGnr($siteCode, '1');
            $gnrRecs = $gnrrecDB->searchGnr($siteCode, $checkStatus);
            $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes = $gnr_total_len_minute % 60;
            $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num = count($allGnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
            if (!empty($allGnrRecs)) {
                $siteInfos[0]->last_gnr_time = $allGnrRecs[0]->gnr_stop_time;
                $siteInfos[0]->gnr_total_len = $gnr_total_len;
                $siteInfos[0]->gnr_num = $gnr_num;
                $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
                $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
            }
            if ($checkStatus == 0) {
                return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
                ->with('filter', $filter)
                ->with('gnrRecs', $gnrRecs)
                ->with('siteID', $siteID);
            } elseif ($checkStatus == 1) {
                return view('backend/gnrRec/index-handled')->with('siteInfos', $siteInfos)
                ->with('filter', $filter)
                ->with('gnrRecs', $gnrRecs)
                ->with('siteID', $siteID);
            }

        } else {
            if (!empty(session('gnrRecs'))) {

                $filter = $request->session()->pull('filter');
                $gnrRecs = $request->session()->pull('gnrRecs');
                if ($gnrRecs == 1) {
                    $gnrRecs = null;
                }
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language=javascript>alert('提交成功！');</script>";
                } elseif ($flag == 'update') {
                    echo "<script language=javascript>alert('修改成功！');</script>";
                } elseif ($flag == 'delete') {
                    echo "<script language=javascript>alert('删除成功！');</script>";
                } elseif ($flag == 'import') {
                    echo "<script language=javascript>alert('导入成功！');</script>";
                }
                return view('backend/gnrRec/index')
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter)
                ->with('status_update', $filter);
            } else {
                return view('backend/gnrRec/index');
            }
        }


    }

    public function addPage(Request $request)
    {

//        $siteChoose = $request->get('sitechoose');
//        $siteID = $request->get('siteID');
//        $siteInfos = DB::table('site_info')->where('id', $siteID)->get();
//        $siteCode = $siteInfos[0]->site_code;
//        $gnrrecDB = new GnrRec();
//        $gnrRecs = $gnrrecDB->searchGnr($siteCode, '1');
//        $siteInfos[0]->site_address = $request->get('siteAddress');
//        $siteInfos[0]->last_gnr_time = $request->get('lastGnrTime');
//        $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
//        $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
//        $gnr_total_len_minutes = $gnr_total_len_minute % 60;
//        $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
//        $gnr_num = count($gnrRecs);
//        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
//        $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
//        $siteInfos[0]->gnr_total_len = $gnr_total_len;
//        $siteInfos[0]->gnr_num = $gnr_num;
//        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
//        $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
        return view('backend/gnrRec/add');
    }

    function handlePage($id, Request $request)
    {
        $filter = $request->all();
        $gnrRecs = DB::table('fee_out_gnr')
        ->where('id', $id)
        ->get();
        return view('backend/gnrRec/handle')
        ->with('id', $id)
        ->with('gnrRecs', $gnrRecs)
        ->with('filter', $filter);
    }

    public function editPage($gnrID, $siteID, $siteChoose, $lastGnrTime)
    {
//        $sitechoose = $request->get('sitechoose');
        $siteInfos = DB::table('site_info')->where('id', $siteID)->get();
        $siteCode = $siteInfos[0]->site_code;
        $gnrRec = DB::table('fee_out_gnr')->where('id', $gnrID)->get();
        $gnrrecDB = new GnrRec();
        $gnrRecs = $gnrrecDB->searchGnr($siteCode);
        $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
        $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
        $gnr_total_len_minutes = $gnr_total_len_minute % 60;
        $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
        $gnr_num = count($gnrRecs);
        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
        $gnr_total_fee_taxed = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee_taxed');
        $siteInfos[0]->gnr_total_len = $gnr_total_len;
        $siteInfos[0]->gnr_num = $gnr_num;
        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
        $siteInfos[0]->gnr_total_fee_taxed = $gnr_total_fee_taxed;
        $siteInfos[0]->last_gnr_time = $lastGnrTime;
        return view('backend/gnrRec/edit')->with('gnrRecs', $gnrRec)
        ->with('siteInfos', $siteInfos)
        ->with('sitechoose', $siteChoose);
    }

    public function addGnr(Request $request)
    {
        $eventLogDB = new EventLog();
        $gnrRecDB = new GnrRec();
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $siteInfo = DB::table('site_info')
        ->where('site_code', $siteCode)
        ->where('region_id', transRegion($filter['region']))
        ->get();
        $stationCode = $request->get('stationCode');
        $stationSiteMap = DB::table('site_station')
        ->where('cdma_code', $stationCode)
        ->where('tower_site_code', $siteCode)
        ->where('region_id', transRegion($filter['region']))
        ->get();
        // dd($stationSiteMap);
        if (empty($stationSiteMap)) {
            echo "<script language=javascript>alert('站址编码和基站编号映射关系不正确！');history.back();</script>";
        } elseif (empty($siteInfo)) {
            echo "<script language=javascript>alert('该站址不存在！');history.back();</script>";
        } else {
            $region = $request->get('region');
            $gnrRaiseSide = $request->get('gnrRaiseSide');
            $gnrReqTime = $request->get('gnrReqTime');
            $addGnr = DB::table('fee_out_gnr')
            ->insert([
                'site_code' => $siteCode,
                'gnr_req_time' => $gnrReqTime,
                'gnr_raise_side' => transGnrRaiseSide($gnrRaiseSide),
                'check_status' => 0,
                'region_name' => $region,
                'region_id' => transRegion($region)
            ]);
            if ($addGnr == true) {
                $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报发电申请',
                    'fee_out_gnr', '');
                $filter['region'] = Auth::user()->area_level;
                $filter['beginDate'] = '';
                $filter['endDate'] = '';
                $filter['checkStatus'] = 0;
                return redirect('backend/gnrRec?region='.$filter['region'].'&checkStatus='.$filter['checkStatus'].'&beginDate='.$filter['beginDate'].'&endDate='.$filter['endDate'])
                // ->with('gnrRecs', 1)
                // ->with('filter', $filter)
                // ->with('region', $filter['region'])
                // ->with('beginDate', $filter['beginDate'])
                // ->with('endDate', $filter['endDate'])
                // ->with('checkStatus', $filter['checkStatus'])
                ->with('flag', 'add');

            } else {
                echo "<script language=javascript>alert('提交失败！');history.back();</script>";
            }
        }


    }

    function handleGnr($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();

        $gnrResult = $request->get('gnrResult');
        $gnrStartTime = ($gnrResult == '失败') ? null : $request->get('gnrStartTime');
        $gnrEndTime = ($gnrResult == '失败') ? null : $request->get('gnrEndTime');
        $siteCode = DB::table('fee_out_gnr')
        ->where('id', $id)
        ->pluck('site_code');
        $gnr_len_minute = floor((strtotime($gnrEndTime) - strtotime($gnrStartTime)) / 60);
        $gnr_hour = floor($gnr_len_minute / 60);
        $gnr_minute = $gnr_len_minute % 60;
        $gnr_len = $gnr_hour . ':' . $gnr_minute;
        $gnr_compute_len = $gnr_hour > 5 ? $gnr_hour : 5;
        $land_form = DB::table('site_info')->where('site_code', $siteCode[0])->pluck('land_form');
        if ($land_form[0] == 1) {
            $gnr_fee = 270 + 20 * ($gnr_compute_len - 5);
        } elseif ($land_form[0] ==0) {
            $gnr_fee = 220 + 20 * ($gnr_compute_len - 5);
        }
        $handleGnr = DB::table('fee_out_gnr')
        ->where('id', $id)
        ->update([
            'gnr_result' => transGnrResult($gnrResult),
            'check_status' => 1,
            'gnr_start_time' => $gnrStartTime,
            'gnr_stop_time' => $gnrEndTime,
            'gnr_len' => $gnr_len,
            'gnr_len_minute' => $gnr_len_minute,
            'gnr_compute_len' => $gnr_compute_len,
            'gnr_fee' => $gnr_fee,
            'gnr_fee_taxed' => $gnr_fee * 1.06,
        ]);
        if ($handleGnr == true) {
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报发电结果',
                'fee_out_gnr', $id);
            return redirect('backend/gnrRec?region='.$filter['region'].'&checkStatus='.$filter['checkStatus'].'&beginDate='.$filter['beginDate'].'&endDate='.$filter['endDate'])
            // ->with('gnrRecs', 1)
            // ->with('filter', $filter)
            // ->with('region', $filter['region'])
            // ->with('beginDate', $filter['beginDate'])
            // ->with('endDate', $filter['endDate'])
            // ->with('checkStatus', $filter['checkStatus'])
            ->with('flag', 'add');
        } else {
            echo "<script language=javascript>alert('提交失败！');history.back();</script>";
        }
    }

    public function update(Request $request)
    {
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $gnrRecDB = new GnrRec();
        $isSuccess = $gnrRecDB->updateDB($request);
        if ($isSuccess == 'is_out') {
            echo "<script language=javascript>alert('该月账单已出，无法修改！');history.back();</script>";
        } else {
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $lastGnrTime = $gnrRecs[0]->gnr_stop_time;
            if ($isSuccess == true) {
                $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_valid', '是')->get();
                $gnrRecs = $gnrRecDB->searchGnr($siteCode);
                $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
                $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
                $gnr_total_len_minutes = $gnr_total_len_minute % 60;
                $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
                $gnr_num = count($gnrRecs);
                $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
                $siteInfos[0]->last_gnr_time = $lastGnrTime;
                $siteInfos[0]->gnr_total_len = $gnr_total_len;
                $siteInfos[0]->gnr_num = $gnr_num;
                $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
                return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
                ->with('gnrRecs', $gnrRecs)
                ->with('filter', $filter)
                ->with('flag', 'update');

            } else {
                echo "<script language=javascript>alert('修改失败！');history.back();</script>";
            }
        }


    }

    public function back(Request $request)
    {
        $filter = $request->all();
        $siteCode = $request->get('siteCode');
        $lastGnrTime = $request->get('lastGnrTime');
        $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->get();
        $siteInfos[0]->last_gnr_time = $lastGnrTime;
        $gnrRecDB = new GnrRec();
        $gnrRecs = $gnrRecDB->searchGnr($siteCode);
        $gnr_total_compute_len = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_compute_len');
        $gnr_num = count($gnrRecs);
        $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
        $siteInfos[0]->gnr_total_compute_len = $gnr_total_compute_len;
        $siteInfos[0]->gnr_num = $gnr_num;
        $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
        return view('backend/gnrRec/index')->with('siteInfos', $siteInfos)
        ->with('gnrRecs', $gnrRecs)
        ->with('filter', $filter);
    }

    public function delete($id, Request $request)
    {
        $isSuccess = DB::table('fee_out_gnr')->where('id', $id)->delete();
        $filter = $request->all();
        if ($isSuccess == true) {
            $siteCode = $request->get('siteCode');
            $lastGnrTime = $request->get('lastGnrTime');
            $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_valid', '是')->get();
            $siteInfos[0]->last_gnr_time = $lastGnrTime;
            $gnrRecDB = new GnrRec();
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_compute_len = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_compute_len');
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $siteInfos[0]->gnr_total_compute_len = $gnr_total_compute_len;
            $siteInfos[0]->gnr_num = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;
            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
            ->with('gnrRecs', $gnrRecs)
            ->with('filter', $filter)
            ->with('flag', 'delete');
        } else {
            echo "<script language=javascript>alert('删除失败！');history.back();</script>";
        }


    }

    public function importGnrRec(Request $request)
    {
        $file = $request->file('gnrRecFile');
        $clientName = $file->getClientOriginalName();
        $file_types = explode(".", $clientName);
        $file_type = $file_types [count($file_types) - 1];
        if (strtolower($file_type) != "xlsx" && strtolower($file_type) != "xls") {
            echo "<script language=javascript>alert('不是Excel文件，请重新上传！');history.back();</script>";
        } else {
            $savePath = 'storage/app';
            $str = date('Ymdhis');
            $file_name = $str . "." . $file_type;
            $path = $file->move($savePath, $file_name);
            $filePath = "public\storage\app\\";
//        $reader->setOutputEncoding('UTF-8');
            Excel::load($filePath . $file_name, function ($reader) {
//            获取excel的第1张表
                $reader = $reader->getSheet(0);
//            获取表中的数据
                $results = $reader->toArray();
                $gnrRecDB = new GnrRec();
                $gnrRecDB->addGnrRecByArray($results);

            });
            $filter = $request->all();
            $siteCode = $request->get('siteCode');

            $gnrRecDB = new GnrRec();
            $siteInfos = DB::table('site_info')->where('site_code', $siteCode)->where('is_valid', '是')->get();
            $gnrRecs = $gnrRecDB->searchGnr($siteCode);
            $gnr_total_len_minute = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_len_minute');
            $gnr_total_len_hour = floor($gnr_total_len_minute / 60);
            $gnr_total_len_minutes = $gnr_total_len_minute % 60;
            $gnr_total_len = $gnr_total_len_hour . ':' . $gnr_total_len_minutes;
            $gnr_num = count($gnrRecs);
            $gnr_total_fee = DB::table('fee_out_gnr')->where('site_code', $siteCode)->sum('gnr_fee');
            $last_gnr_time = DB::table('fee_out_gnr')->where('site_code', $siteCode)->max('gnr_stop_time');
            $siteInfos[0]->last_gnr_time = $last_gnr_time;
            $siteInfos[0]->gnr_total_len = $gnr_total_len;
            $siteInfos[0]->gnr_num = $gnr_num;
            $siteInfos[0]->gnr_total_fee = $gnr_total_fee;

            return redirect('backend/gnrRec/indexGnr')->with('siteInfos', $siteInfos)
            ->with('gnrRecs', $gnrRecs)
            ->with('filter', $filter)
            ->with('flag', 'import');
        }

    }
}
