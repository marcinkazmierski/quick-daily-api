<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateNewUser;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\User;

/**
 * Class CreateNewUserResponse
 * @package App\Application\Domain\UseCase\CreateNewUser
 */
class CreateNewUserResponse extends AbstractResponse
{
    /** @var User */
    private $user;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
