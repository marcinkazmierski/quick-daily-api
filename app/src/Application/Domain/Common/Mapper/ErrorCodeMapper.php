<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class ErrorCodeMapper
{
    const ERROR_GENERAL = '1001';
    const ERROR_INVALID_REQUEST = '1002';
    const ERROR_INVALID_USER_CREDENTIALS = '1003';
    const ERROR_INVALID_USER_STATUS = '1004';
    const ERROR_INVALID_USER_TOKEN = '1004';
}
