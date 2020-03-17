<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetTeamUsers;

/**
 * Interface GetTeamUsersPresenterInterface
 * @package App\Application\Domain\UseCase\GetTeamUsers
 */
interface GetTeamUsersPresenterInterface
{
    /**
     * @param GetTeamUsersResponse $response
     */
    public function present(GetTeamUsersResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
