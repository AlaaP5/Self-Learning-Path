<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse

{
    protected bool $status;
    protected string $message;
    protected mixed $data;
    protected int $pageNumber;
    protected int $totalCount;

    public function __construct(bool $status, string $message, mixed $data, int $pageNumber, int $totalCount)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->pageNumber = $pageNumber;
        $this->totalCount = $totalCount;
    }
    /**
     * Return a success response wrapped in ApiResponse.
     *
     * @param mixed $data
     * @param string $message
     * @param int $totalCount
     * @param int $pageNumber
     * @return ApiResponse
     */

    public static function success(mixed $data, string $message = '', int $totalCount = 1, int $pageNumber = 1)
    {
        return new self(true, $message, $data, $pageNumber, $totalCount);
    }
    /**
     * Return an error response wrapped in ApiResponse.
     *
     * @param string $message
     * @param int $pageNumber
     * @param int $totalCount
     * @return ApiResponse
     */

    public static function error(string $message, int $pageNumber = 1, int $totalCount = 0)
    {
        return new self(false, $message, null, $pageNumber, $totalCount);
    }

    /**
     * Convert ApiResponse to JsonResponse.
     *
     * @return JsonResponse
     */
    public function toJsonResponse(): JsonResponse
    {
        return response()->json([
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'pageNumber' => $this->pageNumber,
            'totalCount' => $this->totalCount,
        ]);
    }
}
