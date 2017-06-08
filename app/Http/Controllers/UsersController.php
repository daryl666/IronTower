<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Validator;
use DB;
use Auth;

class UsersController extends Controller
{
    public function store(Request $request)
    {
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
        if (!empty($request->permission)) {
            foreach ($request->permission as $permission) {
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

        $user = User::create([
            'name' => $request->name,
//            'email' => $data['email'],
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
            'area_level' => $request->area_level,
            'site_view_basic' => $site_view_basic,
            'site_view_advance' => $site_view_advance,
            'site_batch_export' => $site_batch_export,
            'site_batch_import' => $site_batch_import,
            'site_modify' => $site_modify,
            'site_delete' => $site_delete,
            'is_verified' => 0,
            'site_add' => $site_add,
            'bill_out' => $bill_out,
            'bill_view' => $bill_view,
            'gnr_manage' => $gnr_manage,
            'site_check_manage' => $site_check_manage,
            'site_shield_manage' => $site_shield_manage,
            'os_reason_manage' => $os_reason_manage,
        ]);
        \Auth::login($user);
        return redirect('backend');
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $oldpassword = $request->get('oldpassword');
        $password = $request->get('password');
        $data = $request->all();
        $rules = [
            'oldpassword' => 'required|between:6,20',
            'password' => 'required|between:6,20|confirmed',
        ];
        $messages = [
            'oldpassword.required' => '原密码不能为空',
            'password.required' => '新密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);

        $user = User::findOrFail($id);
        $oldpassword_user = $user->password;
//        $oldpassword_user = DB::table('users')->where('name',$name)->pluck('password');
//        $oldpassword_user = $oldpassword_user[0];
        $validator->after(function($validator) use ($oldpassword, $oldpassword_user) {
            if (!\Hash::check($oldpassword, $oldpassword_user)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性错误
        }
        $updatePW = User::find($id)->update([
            'password' => bcrypt($password)
        ]);
        if (!empty($updatePW)) {
            echo "<script language=javascript>alert('修改密码成功！')</script>";
            Auth::logout();
            return redirect('/');
        }else{
            echo "<script language=javascript>alert('修改密码失败！');history.back()</script>";
        }



//        Auth::logout();  //更改完这次密码后，退出这个用户
//        return redirect('/login');
    }
}
