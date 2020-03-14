<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetUser;

use App\Application\Domain\Entity\User;

/**
 * Class GetUserRequest
 * @package App\Application\Domain\UseCase\GetUser
 */
class GetUserRequest
{
    /** @var User */
    private $user;

    /** @var string */
    private $callId;

    /**
     * GetUserRequest constructor.
     * @param User $user
     * @param string $callId
     */
    public function __construct(User $user, string $callId)
    {
        $this->user = $user;
        $this->callId = $callId;
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
}
