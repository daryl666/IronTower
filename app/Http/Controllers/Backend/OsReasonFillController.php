<?php

namespace App\Http\Controllers\Backend;

use App\Models\EventLog;
use App\Models\OsReasonFill;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;

class OsReasonFillController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function indexPage(Request $request)
    {
        $osReasonDB = new OsReasonFill();
        $region = $request->get('region');
        $beginDate = $request->get('beginDate');
        $endDate = $request->get('endDate');
        $checkStatus = $request->get('checkStatus');
        $filter = $request->all();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('filter'))) {
                $flag = $request->session()->pull('flag');
                $filter = $request->session()->pull('filter');
                $osReasons = $osReasonDB->getOsReasons($region, $beginDate, $endDate, $checkStatus)->paginate(15);
                if ($flag == 'add') {
                    echo "<script language='JavaScript'>alert('提交成功！');</script>";
                }
                return view('backend/osReasonFill/index')
                    ->with('osReasons', $osReasons)
                    ->with('filter', $filter);

            } else {
                $osReasons = $osReasonDB->getOsReasons($region, $beginDate, $endDate, $checkStatus)->paginate(15);
                if ($checkStatus == 0){
                    return view('backend/osReasonFill/index')
                        ->with('osReasons', $osReasons)
                        ->with('filter', $filter);
                }else{
                    return view('backend/osReasonFill/index-handled')
                        ->with('osReasons', $osReasons)
                        ->with('filter', $filter);
                }


            }
        }

    }

    /**
     * @param $id
     * @param Request $request
     */
    function add($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $osReason = $request->get('osReason_' . $id);
        $osDetail = $request->get('osDetail_' . $id);
        $respUnit = $request->get('respUnit_' . $id);
        $filter = $request->all();
        $addResult = DB::table('tysys_os_info')
            ->where('id', $id)
            ->update([
                'os_reason' => transOsReason($osReason),
                'os_detail' => $osDetail,
                'response_unit' => transRespUnit($respUnit),
                'check_status' => 1
            ]);
        $originOsReasons = DB::table('tysys_os_info')
            ->where('id', $id)
            ->get();

        // 调用存储过程，向os_record表中插入记录
        $isSuccess = DB::statement('call ty2os(?,?,?,?,?,?,?)', array(transRegion($originOsReasons[0]->region_name), $originOsReasons[0]->station_code,
            $originOsReasons[0]->station_name, $originOsReasons[0]->orig_os_start_time, $originOsReasons[0]->orig_os_end_time,
            transOsReason($originOsReasons[0]->os_reason), transRespUnit($originOsReasons[0]->response_unit)));
        if (!empty($addResult)) {

            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '填报退服原因',
                'tysys_os_info', $id);
            return redirect('backend/osReasonFill')
                ->with('filter', $filter)
                ->with('flag', 'add');
        } else {
            echo "<script language='JavaScript'>alert('提交失败！');history.back()</script>";
        }


    }
}
