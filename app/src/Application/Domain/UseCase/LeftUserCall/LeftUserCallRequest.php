<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\LeftUserCall;

use App\Application\Domain\Entity\User;

/**
 * Class LeftUserCallRequest
 * @package App\Application\Domain\UseCase\LeftUserCall
 */
class LeftUserCallRequest
{
    /** @var User */
    private $user;

    /** @var string */
    private $callId;

    /**
     * LeftUserCallRequest constructor.
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
