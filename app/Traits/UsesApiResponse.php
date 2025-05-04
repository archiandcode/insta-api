<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait UsesApiResponse
{
    public function responseFailed(string $message = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message ?? __('Bad request')
        ], $code);
    }
}
