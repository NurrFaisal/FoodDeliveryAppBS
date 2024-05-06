<?php

namespace App\Services;


use App\Contracts\ApiBaseServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ApiBaseService implements ApiBaseServiceInterface
{
    /**
     * Success response method.
     *
     * @param array $result
     * @param $message
     * @param array $pagination
     * @param int $http_status
     * @param int $status_code
     * @return JsonResponse
     */
    public function sendSuccessResponse(
        $result,
        $message,
        $http_status = ResponseAlias::HTTP_OK,
        $status_code = ResponseAlias::HTTP_OK
    ) {
        $response = [
            'status' => 'SUCCESS',
            'status_code' => $status_code,
            'message' => $message,
            'data' => $result
        ];
        return response()->json($response, $http_status);
    }


    /**
     * Return error response.
     *
     * @param $message
     * @param array $errorMessages
     * @param int $status_code
     * @return JsonResponse
     */
    public function sendErrorResponse($message, $errorMessages = [], $status_code = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY)
    {
        $response = [
            'status' => 'FAIL',
            'status_code' => $status_code,
            'message' => $message,
        ];
        if (!empty($errorMessages)) {
            $response['error'] = $errorMessages;
        }
        return response()->json($response, $status_code);
    }

}
