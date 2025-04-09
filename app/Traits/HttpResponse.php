<?php

namespace App\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use App\Constants\MessagesResponse;

trait HttpResponse
{
    public function error(string $message, string|int $status = Response::HTTP_BAD_REQUEST, array|MessageBag|string $errors = [], $content = [])
    {
        return response()->json([
            'message' => $message,
            'status' => $status,
            'errors' => $errors,
            'content' => $content
        ], $status);
    }

    public function success(mixed $content = [], string $message = MessagesResponse::OK, int $status = Response::HTTP_OK, )
    {
        $response = [
            'message' => $message,
            'status' => $status,
            'content' => $content
        ];

        return response()->json($response, $status);
    }
}
