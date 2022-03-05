<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const status_ok = "OK";
    const status_fail = "FAIL";
    const code_ok = 200;
    const code_failed = 400;
    const code_unauthorized = 403;
    const code_not_found = 404;
    const code_error = 500;

    public $status;

    public $code;

    public $messages = array();

    public $result = array();


    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return JsonResponse
     */
    public function sendResponse($result, string $message)
    {
        $response = [
            'success' => true,
            'code' => 200,
            'message' => $message,
            'data' => $result,
            
        ];

        return response()->json($response, 200);
    }


    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return JsonResponse
     */
    public function sendWithDataResponse($result, string $message, int $count = 0)
    {
        if($count == 0){
            $count =$result->count();
        }
        $response = [
            'success' => true,
            'code' => 200,
            'message' => $message,
            'count' => $count,
            'data' => $result,
            
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     *
     * @return JsonResponse
     */
    public function sendError($error = [], $errorMessages, $code = 200)
    {
        $response = [
            'success' => false,
            'code' => 400,
            'message' => $errorMessages,
        ];

        if (!empty($error)) {
            $response['data'] = $error;
        }

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     *
     * @return JsonResponse
     */
    public function exceptionHandle($exception, $code = 200)
    {
        $response = [
            'success' => false,
            'code' => 201,
            'message' => $exception->getMessage(),
            'data' => $exception,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param  array  $errorMessages
     * @param  int  $code
     *
     * @return JsonResponse
     */
    public function dbExceptionHandle($exception, $code = 200)
    {
        $response = [
            'success' => false,
            'code' => 201,
            'message' => 'Some exceptions occurred from the DB server. Please contact the administrator.',
            'data' => $exception->getMessage(),
        ];

        return response()->json($response, $code);
    }
}
