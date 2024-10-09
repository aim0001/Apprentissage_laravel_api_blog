<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected $HTTP_OK_CODE = Response::HTTP_OK;
    protected $HTTP_FORBIDDEN_CODE = Response::HTTP_FORBIDDEN;
    protected $HTTP_NOT_FOUND_CODE = Response::HTTP_NOT_FOUND;

    private function abstractResponse($httpStatusCode = 200, $message = null, $data = null)
    {
        return response()->json([
            'status_code' => $httpStatusCode,
            'status_message' => $message,
            'data' => $data,
        ], $httpStatusCode);
    }


    public function responceOk($message = "All right", $data = null)
    {
        return $this->abstractResponse($this->HTTP_OK_CODE, $message, $data);
    }

    public function responceForbidden($message = "Must be authenticate !", $data = null)
    {
        return $this->abstractResponse($this->HTTP_FORBIDDEN_CODE, $message, $data);
    }

    public function responceNotFound($message = "All right")
    {
        return $this->abstractResponse($this->HTTP_NOT_FOUND_CODE, $message);
    }
}
