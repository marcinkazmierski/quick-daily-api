<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class RequestFieldMapper
{
    const USER_PASSWORD = 'password';
    const AUTH_TOKEN = 'X-AUTH-TOKEN';
    const USER_EMAIL = 'email';
    const CALL_ID = 'callId';
    const TEAM_ID = 'teamId';
    const USER_NICK = 'nick';
}
