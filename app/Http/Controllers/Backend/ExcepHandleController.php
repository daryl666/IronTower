<?php

namespace App\Http\Controllers\Backend;

use App\Models\ExcepHandle;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class ExcepHandleController extends Controller
{
    function indexPage(Request $request)
    {

        $excepHandleDB = new ExcepHandle();
        $regionName = Auth::user()->area_level;
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (!empty(session('excepSiteInfos'))) {
                $excepSiteInfos = $request->session()->pull('excepSiteInfos');
                $origSiteInfos = $request->session()->pull('origSiteInfos');
                $filter = $request->session()->pull('filter');
                echo "<script language='JavaScript'>alert('操作成功！');</script>";
                return view('backend/excepHandle/imptSiteInfo')
                    ->with('excepSiteInfos', $excepSiteInfos)
                    ->with('origSiteInfos', $origSiteInfos)
                    ->with('filter', $filter);
            } else {
                $siteInfos = $excepHandleDB->getExcepSiteInfos($regionName);
                $excepSiteInfos = $siteInfos[0];
                $origSiteInfos = $siteInfos[1];
                return view('backend/excepHandle/imptSiteInfo')
                    ->with('excepSiteInfos', $excepSiteInfos)
                    ->with('origSiteInfos', $origSiteInfos);
            }

        } else {
            $filter = $request->all();
            $regionName = $request->get('region');
            $siteInfos = $excepHandleDB->getExcepSiteInfos($regionName);
            $excepSiteInfos = $siteInfos[0];
            $origSiteInfos = $siteInfos[1];
            return view('backend/excepHandle/imptSiteInfo')
                ->with('excepSiteInfos', $excepSiteInfos)
                ->with('origSiteInfos', $origSiteInfos)
                ->with('filter', $filter);
        }
    }

    function updateSiteInfo($id, Request $request)
    {
        $filter = $request->all();
        $excepHandleDB = new ExcepHandle();
        $excepSiteInfo = DB::table('import_site_excep')
            ->where('id', $id)
            ->get();
        $updateResult = $excepHandleDB->updateSiteInfo($excepSiteInfo);
        if (!empty($updateResult)) {
            $regionName = Auth::user()->area_level;
            $siteInfos = $excepHandleDB->getExcepSiteInfos($regionName);
            $excepSiteInfos = $siteInfos[0];
            $origSiteInfos = $siteInfos[1];
            return redirect('backend/excepHandle')
                ->with('excepSiteInfos', $excepSiteInfos)
                ->with('origSiteInfos', $origSiteInfos)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('操作失败！');history.back()</script>";
        }
    }

    function denySiteInfo($id, Request $request)
    {
        $filter = $request->all();
        $excepHandleDB = new ExcepHandle();
        $denyResult = $excepHandleDB->denySiteInfo($id);
        if (!empty($denyResult)) {
            $regionName = Auth::user()->area_level;
            $siteInfos = $excepHandleDB->getExcepSiteInfos($regionName);
            $excepSiteInfos = $siteInfos[0];
            $origSiteInfos = $siteInfos[1];
            return redirect('backend/excepHandle')
                ->with('excepSiteInfos', $excepSiteInfos)
                ->with('origSiteInfos', $origSiteInfos)
                ->with('filter', $filter);
        } else {
            echo "<script language='JavaScript'>alert('操作失败！');history.back()</script>";
        }
    }
}
