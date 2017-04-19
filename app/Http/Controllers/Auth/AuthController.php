<?php

namespace App\Http\Controllers\Auth;

//use App\Http\Requests\Request;
use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/backend';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|max:255|unique:users',
//            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|between:6,20|confirmed',
        ];

        $messages = [
            'name.required' => '用户名不能为空',
            'password.required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '密码和确认密码不匹配'
        ];
        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $view = 0;
        $bulk_export = 0;
        $bulk_import = 0;
        $bulk_update = 0;
        $single_update = 0;
        $delete = 0;
        $account_out = 0;
        if (!empty($data['permission'])) {
            foreach ($data['permission'] as $permission) {
                if ($permission == 'view') {
                    $view = 1;
                }
                if ($permission == 'bulk_export') {
                    $bulk_export = 1;
                }
                if ($permission == 'bulk_import') {
                    $bulk_import = 1;
                }
                if ($permission == 'bulk_update') {
                    $bulk_update = 1;
                }
                if ($permission == 'single_update') {
                    $single_update = 1;
                }
                if ($permission == 'delete') {
                    $delete = 1;
                }
                if ($permission == 'account_out') {
                    $account_out = 1;
                }
            }
        }

        return User::create([
            'name' => $data['name'],
//            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'area_level' => $data['area_level'],
            'view' => $view,
            'bulk_export' => $bulk_export,
            'bulk_import' => $bulk_import,
            'bulk_update' => $bulk_update,
            'single_update' => $single_update,
            'is_verified' => 0,
            'delete' => $delete,
            'account_out' => $account_out,
        ]);
    }

    public function getReset()
    {
        return view('auth.reset');
    }

    public function postUpdate(Request $request)
    {

        $name = $request->get('name');
        $oldpassword = $request->get('oldpassword');
        $password = $request->get('password');
        $data = $request->all();
        $rules = [
            'name' => 'required|max:255',
            'oldpassword' => 'required|between:6,20',
            'password' => 'required|between:6,20|confirmed',
        ];
        $messages = [
            'name.required' => '用户名不能为空',
            'oldpassword.required' => '原密码不能为空',
            'password.required' => '新密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);

        $oldpassword_user = DB::table('users')->where('name',$name)->pluck('password');
        $oldpassword_user = $oldpassword_user[0];
        $validator->after(function($validator) use ($oldpassword, $oldpassword_user) {
            if (!\Hash::check($oldpassword, $oldpassword_user)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性错误
        }
        DB::table('users')->where('name',$name)->update([
            'password' => bcrypt($password)
        ]);
        return redirect('/login');

//        Auth::logout();  //更改完这次密码后，退出这个用户
//        return redirect('/login');
    }

    public function postReset(Request $request){
        $name = $request->get('name');
        $isSuccess = DB::table('users')->where('name',$name)->update([
            'password' => bcrypt('000000')
        ]);
        if($isSuccess){
            echo "<script language=javascript>alert('重置成功！');</script>";
            return redirect('/login');
        }else{
            echo "<script language=javascript>alert('重置失败！');history.back()</script>";
        }
    }
}
