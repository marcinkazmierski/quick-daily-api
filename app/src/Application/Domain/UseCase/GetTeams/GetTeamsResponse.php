<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeams;

use App\Application\Domain\Common\Response\AbstractResponse;
use App\Application\Domain\Entity\Team;

/**
 * Class GetTeamsResponse
 * @package App\Application\Domain\UseCase\GetTeams
 */
class GetTeamsResponse extends AbstractResponse
{
    /** @var Team[] */
    private $teams = [];

    /**
     * @return Team[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }

    /**
     * @param Team[] $teams
     */
    public function setTeams(array $teams): void
    {
        $this->teams = $teams;
    }
}
