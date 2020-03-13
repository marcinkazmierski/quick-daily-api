<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserCall;

use App\Application\Domain\Entity\User;

/**
 * Class UserCallRequest
 * @package App\Application\Domain\UseCase\UserCall
 */
class UserCallRequest
{
    /** @var User */
    private $user;

    /** @var string */
    private $callId;

    /** @var int */
    private $teamId;

    /**
     * UserCallRequest constructor.
     * @param User $user
     * @param string $callId
     * @param int $teamId
     */
    public function __construct(User $user, string $callId, int $teamId)
    {
        $this->user = $user;
        $this->callId = $callId;
        $this->teamId = $teamId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getCallId(): string
    {
        return $this->callId;
    }

    /**
     * @return int
     */
    public function getTeamId(): int
    {
        return $this->teamId;
    }
}
