<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\LeftUserCall;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\AccessDeniedException;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class LeftUserCall
 * @package App\Application\Domain\UseCase\LeftUserCall
 */
class LeftUserCall
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * LeftUserCall constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserRepositoryInterface $userRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param LeftUserCallRequest $request
     * @param LeftUserCallPresenterInterface $presenter
     */
    public function execute(
        LeftUserCallRequest $request,
        LeftUserCallPresenterInterface $presenter)
    {
        $response = new LeftUserCallResponse();
        try {
            if (empty($request->getCallId())) {
                throw new ValidateException("Empty callId!");
            }
            $user = $this->userRepository->getUserById($request->getUser()->getId());
            $currentUser = $request->getUser();
            if ($user->getId() !== $currentUser->getId()) {
                throw new AccessDeniedException("Invalid callId");
            }
            $user->setExternalCallId('');
            $this->userRepository->save($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
