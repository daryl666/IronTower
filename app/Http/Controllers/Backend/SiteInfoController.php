<?php

namespace App\Http\Controllers\Backend;

use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\ServPrice;
use Redirect;
use Session;
use Auth;

class SiteInfoController extends Controller
{
    public function indexPage(Request $request)
    {
        $filter = $request->all();
        $siteinfoDB = new SiteInfo();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $filter = $request->all();
            $region = $request->input('region', '');
            $infoSites = $siteinfoDB->searchInfoSite($region);
            return view('backend/siteInfo/index')
                ->with('infoSites', $infoSites)
                ->with('filter', $filter);
        } elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
            $region = $request->get('region');
            if (!empty(session('filter'))) {
                $filter = $request->session()->pull('filter');
                $region = $filter['region'];
            }
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
            if ($flag == 'import') {
                echo "<script language=javascript>alert('导入成功！');</script>";
            }
            $infoSites = $siteinfoDB->searchInfoSite($region)->paginate(15);
            return view('backend/siteInfo/index')
                ->with('infoSites', $infoSites)
                ->with('filter', $filter);
        }
    }


    public function editPage($id, Request $request)
    {
        $siteInfoDB = new SiteInfo();
        $filter = $request->all();
        $siteInfo = $siteInfoDB->searchInfoSiteById($id);
        return view('backend/siteInfo/edit')
            ->with('siteInfo', $siteInfo[0])
            ->with('filter', $filter);
    }

    public function addNewPage()
    {
        return view('backend/siteInfo/add_new');
    }

    public function addOldPage()
    {
        return view('backend/siteInfo/add_old');
    }
    //根据输入的站址属性查询对应的code


    //将站址属性和站址的服务费用插入到对应的表中
    public function addNewDB(Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $siteinfoDB = new SiteInfo();
        $bool = $siteinfoDB->addInfoSiteNew($request);
        if ($bool[0] == false) {
            if ($bool[1] == true && $bool[2] == true) {
                $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name,
                    '新增站址', 'site_info');
                return redirect('backend/siteInfo')
                    ->with('filter', $filter)
                    ->with('flag', 'add');
            } else {
                echo "<script language=javascript>alert('提交失败！');history.back();</script>";
            }
        } else {
            echo "<script language=javascript>alert('该站址已经存在！');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }

    public function addOldDB(Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
        $siteinfoDB = new SiteInfo();
        $bool = $siteinfoDB->addInfoSiteOld($request);
        if ($bool[0] == false) {
            if ($bool[1] == true && $bool[2] == true) {
                $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name,
                    '新增站址', 'site_info');
                return redirect('backend/siteInfo')
                    ->with('filter', $filter)
                    ->with('flag', 'add');
            } else {
                echo "<script language=javascript>alert('提交失败！');history.back();</script>";
            }
        } else {
            echo "<script language=javascript>alert('该站址已经存在！');location.href='" . $_SERVER["HTTP_REFERER"] . "';</script>";
        }
    }

    public function delete($id, Request $request)
    {
        $eventLogDB = new EventLog();
        $isSuccess1 = DB::table('site_info')->where('site_code', $id)
            ->update(['is_valid' => 0
            ]);
        $isSuccess2 = DB::table('fee_out_site_price')->where('site_code', $id)
            ->update(['is_valid' => 0
            ]);
        if ($isSuccess1 and $isSuccess2) {
            $isSuccess = true;
        } else {
            $isSuccess = false;
        }
        $filter = $request->all();
        if ($isSuccess == true) {
            $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name,
                '删除站址', 'site_info', $id);
            return redirect('backend/siteInfo')
                ->with('filter', $filter)
                ->with('flag', 'delete');
        } else {
            echo "<script language=javascript>alert('删除失败！');history.back();</script>";
        }
    }

    public function update(Request $request)
    {
        $eventLogDB = new EventLog();
        $filter = $request->all();
//        dd($filter);
        $region = $request->input('region', '');
        $siteinfoDB = new SiteInfo();
        $isSuccess = $siteinfoDB->updateDB($request);
        if ($isSuccess == 'error1') {
            echo "<script language=javascript>alert('系统1高度有错误！');history.back()</script>";
        } elseif ($isSuccess == 'error2') {
            echo "<script language=javascript>alert('系统2高度有错误！');history.back()</script>";
        } elseif ($isSuccess == 'error3') {
            echo "<script language=javascript>alert('系统3高度有错误！');history.back()</script>";
        } else {
            if ($isSuccess == 'success') {
                $eventLogDB->addEvent(Auth::user()->area_level, '', Auth::user()->name, '修改站址',
                    'site_info/fee_out_site_price', '');
                return redirect('backend/siteInfo')
                    ->with('filter', $filter)
                    ->with('flag', 'update');
            } else {
                echo "<script language=javascript>alert('修改失败！');history.back()</script>";
            }
        }
    }

    public function back(Request $request)
    {
        $filter = $request->all();
        $region = $request->get('region');
        $siteinfoDB = new SiteInfo();
        $infoSites = $siteinfoDB->searchInfoSite($region);
        return view('backend/siteInfo/index')->with('infoSites', $infoSites)
            ->with('filter', $filter);
    }

    public function test()
    {
        $infoSites = DB::table('site_info')
            ->paginate(3);
        return view('backend.siteInfo.test')
            ->with('infoSites', $infoSites);
    }
}
