<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetUser;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class GetUser
 * @package App\Application\Domain\UseCase\GetUser
 */
class GetUser
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * GetUser constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserRepositoryInterface $userRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param GetUserRequest $request
     * @param GetUserPresenterInterface $presenter
     */
    public function execute(
        GetUserRequest $request,
        GetUserPresenterInterface $presenter)
    {
        $response = new GetUserResponse();
        try {
            if (!empty($request->getCallId())) {
                $user = $this->userRepository->getUserByExternalId($request->getCallId());
                $response->setUser($user);
            } else {
                $response->setUser($request->getUser());
            }
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
