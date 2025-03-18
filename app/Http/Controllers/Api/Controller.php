<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Standard success response
     *
     * @param mixed $data
     * @param int $code
     * @param string $msg
     * @param string $statusCode
     * @return JsonResponse
     */
    public function sendResponse($data = [], int $code = 200, string $msg = 'OK', string $statusCode = 'success'): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'status_code' => $statusCode,
            'message' => $msg,
            'data' => $data,
        ], $code); 
    }

    /**
     * Standard error response
     *
     * @param string $msg
     * @param int $code
     * @param array|null $data
     * @return JsonResponse
     */
    public function sendError(string $msg = 'Error', int $code = 400, array $data = null): JsonResponse
    {
        $response = [
            'status' => $code,
            'status_code' => 'error',
            'message' => $msg,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code); 
    }
}
