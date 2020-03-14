<?php
declare(strict_types=1);

namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\EntityNotFoundException;
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

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUserByEmailAndPassword(string $email, string $password): User;

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUserById(int $id): User;

    /**
     * @param string $externalId
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUserByExternalId(string $externalId): User;
}