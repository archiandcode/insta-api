<?php

namespace App\Http\Controllers\Api\User;

use App\Facades\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/v1/user/login",
 *     summary="Авторизация пользователя",
 *     description="Вход пользователя по email или login и получение токена",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"email","password"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="password", type="string", format="password", example="password123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешная авторизация",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOi...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Неверные учетные данные",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Invalid credentials")
 *         )
 *     )
 * )
 */
class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        return User::login($request->data());
    }

}
