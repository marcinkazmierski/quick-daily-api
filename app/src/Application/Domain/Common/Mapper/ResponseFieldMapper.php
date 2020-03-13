<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class ResponseFieldMapper
{
    const AUTH_TOKEN = 'token';
    const USER_ID = 'userId';
    const TEAM_SECTION = 'teams';
    const ID = 'id';
    const TEAM_NAME = 'name';
    const TEAM_DESCRIPTION = 'description';
    const TEAM_IMAGE = 'image';
    const TEAM_EXTERNAL_APP_KEY = 'externalAppKey';
}
