<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetTeamUsers;

use App\Application\Domain\Common\Factory\EntityResponseFactory\UserResponseFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\GetTeamUsers\GetTeamUsersPresenterInterface;
use App\Application\Domain\UseCase\GetTeamUsers\GetTeamUsersResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetTeamUsersPresenter
 * @package App\Application\Infrastructure\UseCase\GetTeamUsers
 */
class GetTeamUsersPresenter extends AbstractPresenter implements GetTeamUsersPresenterInterface
{
    /**
     * @var GetTeamUsersResponse $response
     */
    private $response;

    /** @var UserResponseFactoryInterface */
    private $userResponseFactory;

    /**
     * GetTeamUsersPresenter constructor.
     * @param UserResponseFactoryInterface $userResponseFactory
     */
    public function __construct(UserResponseFactoryInterface $userResponseFactory)
    {
        $this->userResponseFactory = $userResponseFactory;
    }

    /**
     * @param GetTeamUsersResponse $response
     */
    public function present(GetTeamUsersResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if ($this->response->hasError()) {
            switch ($this->response->getError()->getCode()) {
                case ErrorCodeMapper::ERROR_GENERAL:
                    $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                    break;
                default:
                    $statusCode = JsonResponse::HTTP_BAD_REQUEST;
            }
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }
        $users = [];
        /** @var User $user */
        foreach ($this->response->getUsers() as $user) {
            $users[] = $this->userResponseFactory->create($user);
        }

        return new JsonResponse([ResponseFieldMapper::USERS_SECTION => $users], JsonResponse::HTTP_OK);
    }
}
