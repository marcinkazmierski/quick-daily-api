<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeamUsers;

use App\Application\Domain\Entity\User;

/**
 * Class GetTeamUsersRequest
 * @package App\Application\Domain\UseCase\GetTeamUsers
 */
class GetTeamUsersRequest
{
    /** @var int */
    private $teamId;

    /** @var User */
    private $user;

    /**
     * GetTeamUsersRequest constructor.
     * @param int $teamId
     * @param User $user
     */
    public function __construct(int $teamId, User $user)
    {
        $this->teamId = $teamId;
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }
}
