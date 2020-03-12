<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class ErrorCodeMapper
{
    const ERROR_GENERAL = '1001';
    const ERROR_INVALID_REQUEST = '1002';
}
