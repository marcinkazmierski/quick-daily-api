<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserCall;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class UserCall
 * @package App\Application\Domain\UseCase\UserCall
 */
class UserCall
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * UserCall constructor.
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
     * @param UserCallRequest $request
     * @param UserCallPresenterInterface $presenter
     */
    public function execute(
        UserCallRequest $request,
        UserCallPresenterInterface $presenter)
    {
        $response = new UserCallResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
