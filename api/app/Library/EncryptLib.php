<?php
//加密解密工具类
namespace App\Library;

class EncryptLib
{
    //加密用户的密码
    public static function createPassword($password,$salt='#ifjf541#65*gbk415&$') {
        return md5($password.$salt);
    }

}
