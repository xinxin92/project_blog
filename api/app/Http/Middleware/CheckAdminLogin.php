<?php
//管理后台登录态校验&用户信息获取
namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Models\AdminUser;
use Closure;
use Illuminate\Http\Request;

class CheckAdminLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $noLoginCode = config('services.response_code.no_login');
        //cookie验证,获取token
        $token = $request->header('token');
        if (!$token) {
            throw new ApiException('请先登录！', $noLoginCode);
        }
        //token验证获取userId
        $userInfo = AdminUser::where(['token' => $token])->first();
        if(!$userInfo){
            throw new ApiException('请先登录', $noLoginCode);
        }
        if(strtotime($userInfo['expired_at']) < time()){
            throw new ApiException('登录已过期，请重新登录！', $noLoginCode);
        }
        //系统用户校验，获取用户信息
        $userInfo = (new CsUser())->getOne(['fields'=>['*'],'where'=>['user_id'=>$userInfo['user_id'],'in'=>['status'=>[0,1]]]]);
        if (!$userInfo) {
            throw new ApiException('您不是系统用户！', $noLoginCode);
        }
        if ($userInfo['status'] == 0) {
            throw new ApiException('您的账号被禁用！', $noLoginCode);
        }

        //将用户信息放入$request对象中
        $userInfo['token'] = $token;
        $request->attributes->add(compact('userInfo', '$userInfo'));
        return $next($request);
    }
}
