<?php
//用户登录鉴权
namespace App\Repository\Admin;

use App\Exceptions\ApiException;
use App\Library\EncryptLib;
use App\Library\StringLib;
use App\Models\AdminUser;

class AuthRep
{
    public static function login(&$username, &$password)
    {
        $user = AdminUser::where(['username' => $username])->first();
        if (empty($user)) {
            throw new ApiException('用户名不存在！');
        }
        $user = $user->toArray();
        if ($user['status'] == 2) {
            throw new ApiException('已经被封禁！');
        }
        if ($user['password'] != EncryptLib::createPassword($password)) {
            throw new ApiException('密码错误！');
        }

        $newToken = StringLib::createUniqueValue($username);
        $time = date('Y-m-d H:i:s', time());
        $upRes = AdminUser::where(['username' => $username])->update(['token' => $newToken, 'lastLoginTime' => $time]);
        if (!$upRes) {
            throw new ApiException('登录意外失败，请重试！');
        }
        $data = [
            'token' => $newToken,
        ];
        return $data;
    }

    public static function logout(&$username)
    {
        $time = date('Y-m-d H:i:s', time());
        $upRes = AdminUser::where(['username' => $username])->update(['token' => '', 'lastLogoutTime' => $time]);
        if (!$upRes) {
            throw new ApiException('退出操作意外失败，请重试！');
        }
        $data = '退出成功！';
        return $data;
    }

}
