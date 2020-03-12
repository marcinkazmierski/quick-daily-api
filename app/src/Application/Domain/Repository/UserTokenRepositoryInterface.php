<?php
declare(strict_types=1);

namespace App\Application\Domain\Repository;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Exception\RepositoryException;

interface UserTokenRepositoryInterface
{
    /**
     * @param UserToken $token
     * @throws RepositoryException
     */
    public function insertToken(UserToken $token): void;

    /**
     * @param string $tokenKey
     * @return UserToken
     * @throws EntityNotFoundException
     */
    public function getTokenByTokenKey(string $tokenKey): UserToken;

    /**
     * @param User $user
     * @throws EntityNotFoundException
     */
    public function removeTokensByUser(User $user): void;

    /**
     * @param User $user
     * @return UserToken
     * @throws RepositoryException
     */
    public function generateToken(User $user): UserToken;
}