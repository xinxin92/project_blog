<?php
//用户登录鉴权
namespace App\Http\Controllers\Admin;

use App\Library\VerifyLib;
use App\Repository\Admin\AuthRep;

class AuthController
{
    //登录接口,请求：用户名/密码,返回：token
    public function login()
    {
        $request = request()->all();
        $rules = [
            'username' => ['do' => ['trim'], 'check' => ['$param'], 'msg' => ['用户名缺失！']],
            'password' => ['do' => ['trim'], 'check' => ['$param'], 'msg' => ['密码缺失！']],
        ];
        VerifyLib::verifyParams($request,$rules);

        $data = AuthRep::login($request['username'],$request['password']);

        return responseApi($data);
    }

    //登出接口,请求：用户名,返回：无
    public function logout()
    {
        $request = request()->all();

        $data = AuthRep::logout($request['username']);

        return responseApi($data);
    }

}
