<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeamUsers;

use App\Application\Domain\Common\Response\AbstractResponse;

/**
 * Class GetTeamUsersResponse
 * @package App\Application\Domain\UseCase\GetTeamUsers
 */
class GetTeamUsersResponse extends AbstractResponse
{
    /** @var array */
    private $users = [];

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    /**
     * @param array $users
     */
    public function setUsers(array $users): void
    {
        $this->users = $users;
    }
}
