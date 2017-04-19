<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard()->guest()) {
            return redirect('/login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $todoListDB = new TodoList();
                $todoList = $todoListDB->getTodoList(Auth::user()->area_level);
                return view('backend/home/index')
                    ->with('todoList', $todoList);
            } else {
                $filter = $request->all();
                $regionName = $request->get('region');
                $todoListDB = new TodoList();
                $todoList = $todoListDB->getTodoList($regionName);
                return view('backend/home/index')
                    ->with('todoList', $todoList)
                    ->with('filter', $filter);
            }

        }

    }

    function todoHandlePage($id)
    {

        $region = Auth::user()->area_level;
        $beginDate = '';
        $endDate = '';
        $filter['region'] = $region;
        $filter['beginDate'] = $beginDate;
        $filter['endDate'] = $endDate;

        switch ($id) {
            case 0:
                $checkStatus = 1;
//                $filter['checkStatus'] = $checkStatus;
//                return redirect('backend/excepHandle/importSiteInfo')
//                    ->with('region', $region)
//                    ->with('beginDate', $beginDate)
//                    ->with('endDate', $endDate)
//                    ->with('checkStatus', $checkStatus)
//                    ->with('filter', $filter)
//                    ->with('siteShieldsChecking', 1);;
                break;
            case 1:
                $checkStatus = 0;
                $filter['checkStatus'] = $checkStatus;
                return redirect('backend/gnrRec')
                    ->with('region', $region)
                    ->with('beginDate', $beginDate)
                    ->with('endDate', $endDate)
                    ->with('checkStatus', 0)
                    ->with('filter', $filter);
                break;
            case 2:
                $checkStatus = 0;
                $filter['checkStatus'] = $checkStatus;
                return redirect('backend/siteCheck')
                    ->with('region', $region)
                    ->with('beginDate', $beginDate)
                    ->with('endDate', $endDate)
                    ->with('checkStatus', 0)
                    ->with('filter', $filter);
                break;
            case 3:
                $checkStatus = 0;
                $filter['checkStatus'] = $checkStatus;
                return redirect('backend/osReasonFill')
                    ->with('region', $region)
                    ->with('beginDate', $beginDate)
                    ->with('endDate', $endDate)
                    ->with('checkStatus', 0)
                    ->with('filter', $filter);
                break;
            case 4:
                return redirect('backend/servBill');
                break;
            case 5:
                $checkStatus = 1;
                $filter['checkStatus'] = $checkStatus;
                return redirect('backend/siteShield/checkShieldPage')
                    ->with('region', $region)
                    ->with('beginDate', $beginDate)
                    ->with('endDate', $endDate)
                    ->with('checkStatus', $checkStatus)
                    ->with('filter', $filter)
                    ->with('siteShieldsChecking', 1);
                break;
            case 6:
                $checkStatus = 1;
                $filter['checkStatus'] = $checkStatus;
                return redirect('backend/siteShield/checkUnshieldPage')
                    ->with('region', $region)
                    ->with('beginDate', $beginDate)
                    ->with('endDate', $endDate)
                    ->with('checkStatus', $checkStatus)
                    ->with('filter', $filter)
                    ->with('siteUnshieldsChecking', 1);
                break;
        }

    }

    function test(){
        return view('backend.siteStats.index');
    }


}