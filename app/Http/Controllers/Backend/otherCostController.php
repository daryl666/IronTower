<?php

namespace App\Http\Controllers\Backend;

use App\Models\OtherCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class otherCostController extends Controller
{
    function indexPage(Request $request)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (session('otherCosts')) {
                $filter = $request->session()->pull('filter');
                $otherCosts = $request->session()->pull('otherCosts');
                if ($otherCosts == 1){
                    $otherCosts = null;
                }
                $flag = $request->session()->pull('flag');
                if ($flag == 'add') {
                    echo "<script language=javascript>alert('提交成功！');</script>";
                }
                if ($flag == 'update') {
                    echo "<script language=javascript>alert('修改成功！');</script>";
                }
                if ($flag == 'delete') {
                    echo "<script language=javascript>alert('删除成功！');</script>";
                }
                return view('backend/otherCost/index')->with('otherCosts', $otherCosts)
                    ->with('filter', $filter);
            } else {
                return view('backend/otherCost/index');
            }
        } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $filter = $request->all();
            $region = $request->get('region');
            $othercostDB = new OtherCost();
            $otherCosts = $othercostDB->searchOtherCost($region);
            return view('backend/otherCost/index')
                ->with('otherCosts', $otherCosts)
                ->with('filter', $filter);
        }
    }

    function addPage(Request $request)
    {
        $region = $request->get('region');
        return view('backend/otherCost/add')
            ->with('region', $region);
    }

    function addDB(Request $request)
    {
        $filter = $request->all();
        $othercostDB = new OtherCost();
        $addOtherCost = $othercostDB->addOtherCost($request);
        if (!$addOtherCost[0]) {
            if ($addOtherCost[1]) {
                $otherCosts = $othercostDB->searchOtherCost($request->get('region'));
                return redirect('backend/otherCost')
                    ->with('otherCosts', $otherCosts)
                    ->with('filter', $filter)
                    ->with('flag', 'add');
            } else {
                echo "<script language=javascript>alert('新增失败！');history.back();</script>";
            }
        } else {
            echo "<script language=javascript>alert('已经存在该站址！');history.back();</script>";
        }

    }

    function editPage($id, $region)
    {
        $otherCosts = DB::table('fee_other')
            ->where('id', $id)
            ->get();
        return view('backend/otherCost/edit')
            ->with('otherCosts', $otherCosts[0])
            ->with('region', $region);
    }

    function editDB($id, Request $request)
    {
        $filter = $request->all();
        $othercostDB = new OtherCost();
        $updOtherCost = $othercostDB->updateOtherCost($id, $request);
        if ($updOtherCost[0] && $updOtherCost[1]) {
            $otherCosts = $othercostDB->searchOtherCost($request->get('region'));
            return redirect('backend/otherCost')
                ->with('otherCosts', $otherCosts)
                ->with('filter', $filter)
                ->with('flag', 'update');
        } else {
            echo "<script language=javascript>alert('修改失败！');history.back();</script>";
        }

    }

    function back(Request $request){
        $filter = $request->all();
        $othercostDB = new OtherCost();
        $otherCosts = $othercostDB->searchOtherCost($request->get('region'));
        return redirect('backend/otherCost/')
            ->with('filter',$filter)
            ->with('otherCosts',$otherCosts);
    }

    function delete($id, Request $request){
        $filter = $request->all();
        $othercostDB = new OtherCost();
        $delOtherCost = $othercostDB->deleteDB($id);
        if ($delOtherCost){
            $otherCosts = $othercostDB->searchOtherCost($request->get('region'));
            if (empty($otherCosts)){
                $otherCosts = 1;
            }
            return redirect('backend/otherCost')
                ->with('otherCosts', $otherCosts)
                ->with('filter', $filter)
                ->with('flag', 'delete');
        }else{
            echo "<script language=javascript>alert('删除失败！');history.back();</script>";
        }

    }
}
