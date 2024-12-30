<?php
declare(strict_types=1);

namespace App\Infrastructure\Framework\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseFormatter
{
    /**
     * Formats a successful response.
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    public static function success(mixed $data, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Formats an error response.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public static function error(string $message, int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'error' => $message,
            'code' => $code,
        ], $code);
    }
}
