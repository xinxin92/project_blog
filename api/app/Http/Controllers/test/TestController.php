<?php

namespace App\Http\Controllers\Test;

use App\Exceptions\ApiException;
use App\Library\EncryptLib;
use App\Library\VerifyLib;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController
{
    public function basic()
    {
        echo EncryptLib::createPassword('yuxinwei');
//        echo 'basic';
    }

    public function exception()
    {
        throw new ApiException('查询失败请重试！');
    }

    public function verify()
    {
        $request = request()->all();
        $rules = [
            'type' => ['do' => ['trim'], 'check' => [['delete', 'release']]],
            'age' => ['do' => ['intval'], 'check' => ['$param>=18'], 'msg' => ['未成年禁止访问！']],
        ];
        VerifyLib::verifyParams($request,$rules);


        return responseApi(['type'=>$request['type'],'age'=>$request['age']]);
    }

    public function db()
    {
//        $results = DB::connection('mysql')->select('select * from t_admin_user');
//        $results = DB::connection('mysql')->table('t_admin_user')->get();
        $results = AdminUser::where('id',2)->get()->toArray();  //推荐

        var_dump($results);
    }
}
