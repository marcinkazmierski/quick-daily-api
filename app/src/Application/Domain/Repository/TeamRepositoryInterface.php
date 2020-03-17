<?php
declare(strict_types=1);

namespace App\Application\Domain\Repository;


use App\Application\Domain\Entity\Team;
use App\Application\Domain\Exception\EntityNotFoundException;

interface TeamRepositoryInterface
{
    /**
     * @param int $id
     * @return Team
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Team;
}