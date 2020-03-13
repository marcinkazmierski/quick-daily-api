<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetTeams;

/**
 * Interface GetTeamsPresenterInterface
 * @package App\Application\Domain\UseCase\GetTeams
 */
interface GetTeamsPresenterInterface
{
    /**
     * @param GetTeamsResponse $response
     */
    public function present(GetTeamsResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
