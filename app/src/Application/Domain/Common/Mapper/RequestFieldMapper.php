<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class RequestFieldMapper
{
    const PASSWORD = 'password';
    const AUTH_TOKEN = 'X-AUTH-TOKEN';
    const USER_EMAIL = 'email';
}
