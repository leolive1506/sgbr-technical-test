<?php
namespace App\Constants\Auth;

use App\Constants\MessagesResponse as HttpMessagesResponse;

abstract class MessagesResponse extends HttpMessagesResponse
{
    public const TOKEN_REVOKED = 'Token revoked';

    public const UNAUTHORIZED = 'Unauthorized';
}
