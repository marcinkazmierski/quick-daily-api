<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Entity\UserToken;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Exception\RepositoryException;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserTokenRepository extends ServiceEntityRepository implements UserTokenRepositoryInterface
{
    /**
     * UserTokenRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserToken::class);
    }

    /**
     * @param UserToken $token
     * @throws RepositoryException
     */
    public function insertToken(UserToken $token): void
    {
        try {
            $this->_em->persist($token);
            $this->_em->flush();
        } catch (\Throwable $e) {
            throw new RepositoryException();
        }
    }

    /**
     * @param string $tokenKey
     * @return UserToken
     * @throws EntityNotFoundException
     */
    public function getTokenByTokenKey(string $tokenKey): UserToken
    {
        /** @var UserToken $token */
        $token = $this->findOneBy(['tokenKey' => $tokenKey]);
        if (!$token) {
            throw new EntityNotFoundException(sprintf("Invalid tokenKey: '%s'", $tokenKey));
        }
        return $token;
    }

    /**
     * @param User $user
     * @throws EntityNotFoundException
     */
    public function removeTokensByUser(User $user): void
    {
        try {
            $qb = $this->_em->createQueryBuilder();
            $qb->delete(UserToken::class, 't');
            $qb->where('t.user = :user');
            $qb->setParameter('user', $user);
            $qb->getQuery()->execute();
        } catch (\Throwable $e) {
            throw new EntityNotFoundException($e->getMessage());
        }
    }

    /**
     * @param User $user
     * @return UserToken
     * @throws RepositoryException
     */
    public function generateToken(User $user): UserToken
    {
        try {
            $token = new UserToken();
            $token->setTokenKey(bin2hex(random_bytes(64)));
        } catch (\Throwable $e) {
            throw new RepositoryException($e->getMessage());
        }
        $token->setUser($user);
        $this->insertToken($token);
        return $token;
    }
}
