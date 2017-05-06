<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use App\Models\ServPrice;
use Auth;


class UserManageController extends Controller
{
    public function indexPage(Request $request){
        $users = DB::table('users')->get();
        return view('backend/userManage/index')->with('users',$users);
    }

    public function verifyPermission(Request $request, $id){
        $site_view_basic = 0;
        $site_view_advance = 0;
        $site_batch_export = 0;
        $site_batch_import = 0;
        $site_modify = 0;
        $site_delete = 0;
        $site_add = 0;
        $bill_out = 0;
        $bill_view = 0;
        $gnr_manage = 0;
        $site_check_manage = 0;
        $site_shield_manage = 0;
        $os_reason_manage = 0;
        if(!empty($request->get('permission_'.$id))){
            foreach ($request->get('permission_'.$id) as $permission){
                if ($permission == 'site_view_basic') {
                    $site_view_basic = 1;
                }
                if ($permission == 'site_view_advance') {
                    $site_view_advance = 1;
                }
                if ($permission == 'site_batch_export') {
                    $site_batch_export = 1;
                }
                if ($permission == 'site_batch_import') {
                    $site_batch_import = 1;
                }
                if ($permission == 'site_modify') {
                    $site_modify = 1;
                }
                if ($permission == 'site_delete') {
                    $site_delete = 1;
                }
                if ($permission == 'site_add') {
                    $site_add = 1;
                }
                if ($permission == 'bill_out') {
                    $bill_out = 1;
                }
                if ($permission == 'bill_view') {
                    $bill_view = 1;
                }
                if ($permission == 'gnr_manage') {
                    $gnr_manage = 1;
                }
                if ($permission == 'site_check_manage') {
                    $site_check_manage = 1;
                }
                if ($permission == 'site_shield_manage') {
                    $site_shield_manage = 1;
                }
                if ($permission == 'os_reason_manage') {
                    $os_reason_manage = 1;
                }
            }
        }
        $update_success = DB::table('users')->where('id', $id)->update([
            'site_view_basic' => $site_view_basic,
            'site_view_advance' => $site_view_advance,
            'site_batch_export' => $site_batch_export,
            'site_batch_import' => $site_batch_import,
            'site_modify' => $site_modify,
            'site_delete' => $site_delete,
            'site_add' => $site_add,
            'bill_out' => $bill_out,
            'bill_view' => $bill_view,
            'gnr_manage' => $gnr_manage,
            'site_check_manage' => $site_check_manage,
            'site_shield_manage' => $site_shield_manage,
            'os_reason_manage' => $os_reason_manage,
        ]);
        if($update_success){
            echo "<script>alert('审核成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }else{
            echo "<script>alert('审核失败！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }
    }

    public function updatePermission(Request $request, $id){
        $site_view_basic = 0;
        $site_view_advance = 0;
        $site_batch_export = 0;
        $site_batch_import = 0;
        $site_modify = 0;
        $site_delete = 0;
        $site_add = 0;
        $bill_out = 0;
        $bill_view = 0;
        $gnr_manage = 0;
        $site_check_manage = 0;
        $site_shield_manage = 0;
        $os_reason_manage = 0;
        if(!empty($request->get('permission_'.$id))) {
            foreach ($request->get('permission_' . $id) as $permission) {
                if ($permission == 'site_view_basic') {
                    $site_view_basic = 1;
                }
                if ($permission == 'site_view_advance') {
                    $site_view_advance = 1;
                }
                if ($permission == 'site_batch_export') {
                    $site_batch_export = 1;
                }
                if ($permission == 'site_batch_import') {
                    $site_batch_import = 1;
                }
                if ($permission == 'site_modify') {
                    $site_modify = 1;
                }
                if ($permission == 'site_delete') {
                    $site_delete = 1;
                }
                if ($permission == 'site_add') {
                    $site_add = 1;
                }
                if ($permission == 'bill_out') {
                    $bill_out = 1;
                }
                if ($permission == 'bill_view') {
                    $bill_view = 1;
                }
                if ($permission == 'gnr_manage') {
                    $gnr_manage = 1;
                }
                if ($permission == 'site_check_manage') {
                    $site_check_manage = 1;
                }
                if ($permission == 'site_shield_manage') {
                    $site_shield_manage = 1;
                }
                if ($permission == 'os_reason_manage') {
                    $os_reason_manage = 1;
                }
            }
        }
        $update_success = DB::table('users')->where('id', $id)->update([
            'site_view_basic' => $site_view_basic,
            'site_view_advance' => $site_view_advance,
            'site_batch_export' => $site_batch_export,
            'site_batch_import' => $site_batch_import,
            'site_modify' => $site_modify,
            'site_delete' => $site_delete,
            'site_add' => $site_add,
            'bill_out' => $bill_out,
            'bill_view' => $bill_view,
            'gnr_manage' => $gnr_manage,
            'site_check_manage' => $site_check_manage,
            'site_shield_manage' => $site_shield_manage,
            'os_reason_manage' => $os_reason_manage,
        ]);
        if(!empty($update_success)){
            echo "<script>alert('修改成功！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }else{
            echo "<script>alert('修改失败！');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        }
    }


}
