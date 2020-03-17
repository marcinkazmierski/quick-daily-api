<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeamUsers;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\TeamRepositoryInterface;

/**
 * Class GetTeamUsers
 * @package App\Application\Domain\UseCase\GetTeamUsers
 */
class GetTeamUsers
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /** @var TeamRepositoryInterface */
    private $teamRepository;

    /**
     * GetTeamUsers constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param TeamRepositoryInterface $teamRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, TeamRepositoryInterface $teamRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->teamRepository = $teamRepository;
    }


    /**
     * @param GetTeamUsersRequest $request
     * @param GetTeamUsersPresenterInterface $presenter
     */
    public function execute(
        GetTeamUsersRequest $request,
        GetTeamUsersPresenterInterface $presenter)
    {
        $response = new GetTeamUsersResponse();
        try {
            $user = $request->getUser();
            $team = $this->teamRepository->getById($request->getTeamId());
            if (!$user->getTeams()->contains($team)) {
                throw new ValidateException(sprintf("User (id: %d) is not a member of this team (id: %d)", $user->getId(), $team->getId()));
            }
            $users = $team->getUsers()->filter(function (User $user) {
                return $user->getStatus() === 1;
            });
            $response->setUsers($users->toArray());
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
