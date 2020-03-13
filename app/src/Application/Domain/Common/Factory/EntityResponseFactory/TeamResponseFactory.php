<?php
declare(strict_types=1);

namespace App\Application\Domain\Common\Factory\EntityResponseFactory;

use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\Team;

class TeamResponseFactory implements TeamResponseFactoryInterface
{
    /**
     * @param Team $team
     * @return array
     */
    public function create(Team $team): array
    {
        return [
            ResponseFieldMapper::ID => $team->getId(),
            ResponseFieldMapper::TEAM_NAME => $team->getName(),
            ResponseFieldMapper::TEAM_DESCRIPTION => $team->getDescription(),
            ResponseFieldMapper::TEAM_IMAGE => $team->getImage(),
            ResponseFieldMapper::TEAM_EXTERNAL_APP_KEY => $team->getCompany()->getExternalAppId(),
        ];
    }
}
