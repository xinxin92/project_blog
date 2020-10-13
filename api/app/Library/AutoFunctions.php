<?php

//自定义函数
if (! function_exists('responseApi')) {
    function responseApi($data = null)
    {
        $returnData = json_encode(['code' => '0', 'message' => 'success', 'data' => $data], JSON_UNESCAPED_UNICODE);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $returnData;
        } else {
            return json_encode(['code' => '10000', 'message' => 'json非法字符', 'data' => null], JSON_UNESCAPED_UNICODE);
        }
    }
}
