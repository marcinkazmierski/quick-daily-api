<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Common\Factory\ErrorResponseFactory;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Common\Response\ErrorResponse;
use Psr\Log\LoggerInterface;

class ErrorResponseFromExceptionFactory implements ErrorResponseFromExceptionFactoryInterface
{
    /** @var LoggerInterface */
    private $logger;

    /**
     * ErrorResponseFromExceptionFactory constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * todo: translator
     * @param \Throwable $exception
     * @return ErrorResponse
     */
    public function create(\Throwable $exception): ErrorResponse
    {
        $this->logger->error('ErrorResponseFromExceptionFactory:create', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        $message = $exception->getMessage();
        $errorCode = '1001'; // TODO, const
        return new ErrorResponse($errorCode, $message, $message);
    }
}
