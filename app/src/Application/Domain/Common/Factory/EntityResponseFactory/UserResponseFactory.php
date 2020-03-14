<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Factory\EntityResponseFactory;

use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\User;

class UserResponseFactory implements UserResponseFactoryInterface
{
    /**
     * @param User $user
     * @return array
     */
    public function create(User $user): array
    {
        return [
            ResponseFieldMapper::ID => $user->getId(),
            ResponseFieldMapper::USER_NICK => $user->getNick(),
            ResponseFieldMapper::USER_EXTERNAL_ID => $user->getExternalCallId(),
            ResponseFieldMapper::USER_AVATAR => $user->getAvatar(),
        ];
    }
}
