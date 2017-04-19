<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Session;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class Permission
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $permits = $this->getPermission($request);
        if (empty($permits)) {
            return $next($request);
        }
//        $admin = \App\Http\Middleware\Authenticate::getAuthUser();
        $admin = Auth::user();
        $adminValidate = new Admin();
        // 需要有全部权限才能进入该请求
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            if (!$adminValidate->hasPermission($permits, $admin['attributes'])) {
                return response()->json(['code' => 500]);
            } else {
                return $next($request);
            }
        }else{
            if (!$adminValidate->hasPermission($permits, $admin['attributes'])) {
                echo "<script language=javascript>history.back();alert('没有权限，请联系管理员！');</script>";
            } else {
                return $next($request);
            }
        }

    }

    // 获取当前路由需要的权限
    public function getPermission($request)
    {
        $actions = $request->route()->getAction();
        if (empty($actions['permissions'])) {
            return null;
        }
        return $actions['permissions'];
    }
}
