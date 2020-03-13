<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Factory\EntityResponseFactory;

use App\Application\Domain\Entity\Team;

interface TeamResponseFactoryInterface
{
    /**
     * @param Team $team
     * @return array
     */
    public function create(Team $team): array;
}