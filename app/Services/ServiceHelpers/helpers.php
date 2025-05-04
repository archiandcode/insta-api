<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;

function uploadImage(UploadedFile $image): string
{
    $path = $image->storePublicly('avatars');

    return config('app.url')."/storage/$path";
}
