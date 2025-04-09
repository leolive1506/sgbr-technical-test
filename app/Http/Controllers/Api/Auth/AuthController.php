<?php

namespace App\Http\Controllers\Api\Auth;

use App\Constants\Auth\MessagesResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        /** @var User $user */
        $user = auth()->user();

        $token = $user->createToken(Str::lower(request('email')) . '|' . request()->ip())->plainTextToken;

        return $this->success(
            MessagesResponse::OK,
            Response::HTTP_OK,
            [
                'token' => $token,
                'user'  => new UserResource($user),
            ]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->string('password')),
            ]);


            event(new Registered($user));

            $token = $user->createToken(Str::lower(request('email')) . '|' . request()->ip())->plainTextToken;

            return [
                'token' => $token,
                'user'  => new UserResource($user),
            ];
        });

        if (!filled($data)) {
            return $this->error(
                MessagesResponse::FAILED_CREATE,
            );
        }

        return $this->success(
            MessagesResponse::CREATED,
            Response::HTTP_CREATED,
            $data
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(MessagesResponse::TOKEN_REVOKED);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success(
            MessagesResponse::OK,
            Response::HTTP_OK,
            [
                'user' => new UserResource($request->user()),
            ]
        );
    }
}
