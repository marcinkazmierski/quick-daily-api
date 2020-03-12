<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CreateNewUser;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class CreateNewUser
 * @package App\Application\Domain\UseCase\CreateNewUser
 */
class CreateNewUser
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * CreateNewUser constructor.
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
     * @param CreateNewUserRequest $request
     * @param CreateNewUserPresenterInterface $presenter
     */
    public function execute(
        CreateNewUserRequest $request,
        CreateNewUserPresenterInterface $presenter)
    {
        $response = new CreateNewUserResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
