<?php
//字符串工具类
namespace App\Library;

class StringLib
{
    //获取唯一串（raw: true-16字符二进制格式, false-32字符十六进制数）
    public static function createUniqueValue($attach = '', $raw = false) {
        $microsecond = microtime(true) * 10000;  //获取微妙级当前时间戳
        $randomStr = str_pad(rand(0, 100000), 6, 0, STR_PAD_LEFT);  //取6位随机数，不足为以0填补
        $uniqueValue = $microsecond . $randomStr;
        $attach && $uniqueValue = $uniqueValue.$attach;
        return md5($uniqueValue, $raw);
    }

}
