<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeams;

use App\Application\Domain\Entity\User;

/**
 * Class GetTeamsRequest
 * @package App\Application\Domain\UseCase\GetTeams
 */
class GetTeamsRequest
{
    /** @var User */
    private $user;

    /**
     * GetTeamsRequest constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
