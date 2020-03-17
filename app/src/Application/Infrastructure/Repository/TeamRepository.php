<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Repository;

use App\Application\Domain\Entity\Team;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Repository\TeamRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TeamRepository extends ServiceEntityRepository implements TeamRepositoryInterface
{
    /**
     * TeamRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Team::class);
    }

    /**
     * @param int $id
     * @return Team
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Team
    {
        /** @var Team $entity */
        $entity = $this->find($id);
        if (!$entity) {
            throw new EntityNotFoundException("Invalid id - team not exist");
        }
        return $entity;
    }
}
