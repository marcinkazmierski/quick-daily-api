<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\LeftUserCall;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class LeftUserCall
 * @package App\Application\Domain\UseCase\LeftUserCall
 */
class LeftUserCall
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * LeftUserCall constructor.
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
     * @param LeftUserCallRequest $request
     * @param LeftUserCallPresenterInterface $presenter
     */
    public function execute(
        LeftUserCallRequest $request,
        LeftUserCallPresenterInterface $presenter)
    {
        $response = new LeftUserCallResponse();
        try {
            //TODO
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
