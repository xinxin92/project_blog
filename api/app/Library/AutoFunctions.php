<?php

//判断当前环境是否为正式环境
if (!function_exists('isProduction')) {
    function isProduction()
    {
        if (config('app.env') == 'production') {
            return true;
        }
        return false;
    }
}

//自定义函数
if (!function_exists('responseApi')) {
    function responseApi($data = null)
    {
        $returnData = json_encode(['code' => config('services.response_code')['success'], 'message' => 'success', 'data' => $data], JSON_UNESCAPED_UNICODE);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $returnData;
        } else {
            return json_encode(['code' => config('services.response_code')['fail'], 'message' => 'json非法字符', 'data' => null], JSON_UNESCAPED_UNICODE);
        }
    }
}
