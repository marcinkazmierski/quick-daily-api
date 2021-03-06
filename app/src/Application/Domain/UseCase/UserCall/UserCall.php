<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\UserCall;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class UserCall
 * @package App\Application\Domain\UseCase\UserCall
 */
class UserCall
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * UserCall constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserRepositoryInterface $userRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserCallRequest $request
     * @param UserCallPresenterInterface $presenter
     */
    public function execute(
        UserCallRequest $request,
        UserCallPresenterInterface $presenter)
    {
        $response = new UserCallResponse();
        try {
            if (empty($request->getCallId())) {
                throw new ValidateException("Empty callId!");
            }
            $user = $this->userRepository->getUserById($request->getUser()->getId());
            $user->setExternalCallId($request->getCallId());
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
