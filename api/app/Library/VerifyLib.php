<?php
//校验工具类
namespace App\Library;

use App\Exceptions\ApiException;

class VerifyLib
{
    /*
         * 参数预处理+校验+返回错误提示
         * $params为请求参数
         *  rules为校验规则，rules示例:
         *  $rules = [
                'isdealer' => ['do'=>['intval'],'check'=>[[0,1]], 'msg'=>['请选择正确的账户类型！']],
                'user_name' => ['do'=>['trim'], 'check'=>['$param'], 'msg'=>['用户名缺失！']],
                'mobile' => ['do'=>['trim'], 'check'=>['mobile'], 'msg'=>['手机号格式有误！']],
                'age' => ['do'=>['intval'], 'check'=>['$param>=18'], 'msg'=>['未成年禁止访问！']],
            ];
         *  rules元素的参数说明：
         *  do: array，预处理，可多项；
         *  check：array，校验，可多项；
         *  msg：array，对应check失败时的返回提示，当check有多项时，如果没有对应的返回提示，默认取msg第一项；
         *  optional: 是否必须;
         */
    public static function verifyParams(&$params, &$rules)
    {
        if ($rules) {
            foreach ($rules as $param => $rule) {
                $defaultMsg = isset($rule['msg'][0]) ? $rule['msg'][0] : '参数'.$param.'异常';
                if (isset($params[$param])) {
                    //参数预处理
                    if (!empty($rule['do'])) {
                        foreach ($rule['do'] as $do) {
                            $params[$param] = $do($params[$param]);
                        }
                    }
                    //参数正式校验并返回对应错误提示
                    if (!empty($rule['check'])) {
                        $index = 0;
                        foreach ($rule['check'] as $checkType => $check) {
                            if (!self::checkRule($params[$param],$checkType,$check)) {
                                $msg = isset($rule['msg'][$index]) ? $rule['msg'][$index] : $defaultMsg;
                                throw new ApiException($msg);
                            }
                            $index++;
                        }
                    }
                } else {
                    if (empty($rule['optional'])) {
                        throw new ApiException($defaultMsg);
                    }
                }
            }
        }
    }

    //校验单个规则
    public static function checkRule($value,$checkType,$check)
    {
        if (is_numeric($checkType)) {
            if (is_array($check)) {  //in_array
                if (in_array($value,$check)) {
                    return true;
                }
            } else if ($check == 'mobile') {  //手机号
                if (preg_match("/^1[345678]{1}\d{9}$/",$value)) {
                    return true;
                }
            } else if ($check == '$param') {  //非空
                if (!empty($value)) {
                    return true;
                }
            } else if (substr($check,0,8) == '$param>=') {  //数值范围判断
                if ($value >= substr($check,8)) {
                    return true;
                }
            } else if (substr($check,0,8) == '$param<=') {
                if ($value <= substr($check,8)) {
                    return true;
                }
            } else if (substr($check,0,8) == '$param!=') {
                if ($value != substr($check,8)) {
                    return true;
                }
            } else if (substr($check,0,7) == '$param=') {
                if ($value == substr($check,7)) {
                    return true;
                }
            } else if (substr($check,0,7) == '$param>') {
                if ($value > substr($check,7)) {
                    return true;
                }
            } else if (substr($check,0,7) == '$param<') {
                if ($value < substr($check,7)) {
                    return true;
                }
            }
        }
        return false;
    }


}
