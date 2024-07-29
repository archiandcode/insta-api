<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;

function responseFailed(string $message = null, int $code = 400): JsonResponse
{
    return response()->json([
        'message' => $message ?? _('Bad request')
    ], $code);
}


function uploadImage(UploadedFile $image): string
{
    $path = $image->storePublicly('avatars');

    return config('app.url')."/storage/$path";
}
