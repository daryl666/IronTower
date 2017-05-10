<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class EventLogController extends Controller
{
    function indexPage(Request $request){
        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
            $filter = $request->all();
            $region = $request->get('region');
            $beginDate = $request->get('beginDate');
            $endDate = $request->get('endDate');
            if ($region =='湖北省'){
                $query = DB::table('sys_log')
                ->orderBy('created_at', 'DESC');
            }else{
                $query = DB::table('sys_log')
                    ->where('region_id', transRegion($region))
                    ->orderBy('created_at', 'DESC');
            }
            if ($beginDate != '') {
                $query->where('created_at', '>=', $beginDate . '-01 00:00:00');
            }
            if ($endDate != '') {
                $query->where('created_at', '<=', $endDate . '-31 23:59:59');
            }
            $eventLogs = $query->paginate(15);
            return view('backend.eventLog.index')
                ->with('eventLogs', $eventLogs)
                ->with('filter', $filter);
        }
    }
}
