<?php
declare(strict_types=1);

namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\RepositoryException;

interface UserRepositoryInterface
{
    /**
     * @param User $entity
     * @throws RepositoryException
     */
    public function save(User $entity): void;

    /**
     * @param User $user
     * @param string $password
     * @return string
     */
    public function encodePassword(User $user, string $password): string;
}