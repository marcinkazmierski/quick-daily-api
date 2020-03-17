<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Mapper;

abstract class ResponseFieldMapper
{
    const TEAM_SECTION = 'teams';
    const USERS_SECTION = 'users';

    const AUTH_TOKEN = 'token';
    const ID = 'id';

    const TEAM_NAME = 'name';
    const TEAM_DESCRIPTION = 'description';
    const TEAM_IMAGE = 'image';
    const TEAM_EXTERNAL_APP_KEY = 'externalAppKey';

    const USER_EXTERNAL_ID = 'externalId';
    const USER_NICK = 'nick';
    const USER_AVATAR = 'avatar';
}
