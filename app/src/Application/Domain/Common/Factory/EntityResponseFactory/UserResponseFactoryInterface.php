<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Factory\EntityResponseFactory;

use App\Application\Domain\Entity\User;

interface UserResponseFactoryInterface
{
    /**
     * @param User $user
     * @return array
     */
    public function create(User $user): array;
}