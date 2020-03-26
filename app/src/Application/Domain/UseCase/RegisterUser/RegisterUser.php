<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\RegisterUser;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class RegisterUser
 * @package App\Application\Domain\UseCase\RegisterUser
 */
class RegisterUser
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * RegisterUser constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
    )
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param RegisterUserRequest $request
     * @param RegisterUserPresenterInterface $presenter
     */
    public function execute(
        RegisterUserRequest $request,
        RegisterUserPresenterInterface $presenter)
    {
        $response = new RegisterUserResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
