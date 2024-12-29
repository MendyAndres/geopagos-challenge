<?php
declare(strict_types=1);

namespace App\Infrastructure\Framework\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseFormatter
{
    /**
     * Formats a successful response.
     *
     * @param mixed $data The data to include in the response.
     * @param string $message The success message (default is 'Success').
     * @return JsonResponse The formatted success response.
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
     * @param string $message The error message.
     * @param int $code The error code (default is 500).
     * @return JsonResponse The formatted error response.
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
