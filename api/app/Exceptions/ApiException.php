<?php
namespace App\Exceptions;

class ApiException extends \Exception
{
    public function __construct($msg = '', $code = null)
    {
        $code === null && $code = config('services.response_code')['fail'];
        parent::__construct($msg, $code);
    }

    public function render()
    {
        $result = [
            'code' => (string)$this->getCode(),
            'message'  => (string)$this->getMessage(),
            'data' => null
        ];
        return response()->json($result);
    }


}
