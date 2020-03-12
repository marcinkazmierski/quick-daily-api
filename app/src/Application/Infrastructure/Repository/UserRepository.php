<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Exception\RepositoryException;
use App\Application\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository extends ServiceEntityRepository implements UserLoaderInterface, UserRepositoryInterface
{

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserRepository constructor.
     * @param ManagerRegistry $registry
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ManagerRegistry $registry, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($registry, User::class);
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $username
     * @return User
     * @throws EntityNotFoundException
     */
    public function loadUserByUsername(string $username): User
    {
        /** @var User $user */
        $user = $this->findOneBy(['email' => $username, 'status' => 1]);
        if (!$user) {
            throw new EntityNotFoundException(sprintf("User with %s email not exist", $username));
        }

        return $user;
    }

    /**
     * @param User $entity
     * @throws RepositoryException
     */
    public function save(User $entity): void
    {
        try {
            $this->_em->persist($entity);
            $this->_em->flush();
        } catch (ORMException $e) {
            $this->_em->rollback();
            throw new RepositoryException($e->getMessage());
        }
    }

    /**
     * @param User $user
     * @param string $password
     * @return string
     */
    public function encodePassword(User $user, string $password): string
    {
        return $this->passwordEncoder->encodePassword($user, $password);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws EntityNotFoundException
     */
    public function getUserByEmailAndPassword(string $email, string $password): User
    {
        /** @var User $user */
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            throw new EntityNotFoundException("Invalid email");
        }

        if (!$this->passwordEncoder->isPasswordValid($user, $password)) {
            throw new EntityNotFoundException("Invalid password");
        }
        return $user;
    }
}
