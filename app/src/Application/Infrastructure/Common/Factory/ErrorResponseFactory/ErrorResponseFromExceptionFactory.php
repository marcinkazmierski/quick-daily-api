<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Common\Factory\ErrorResponseFactory;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\Common\Response\ErrorResponse;
use App\Application\Domain\Exception\InvalidCredentialsException;
use App\Application\Domain\Exception\InvalidUserStatusException;
use App\Application\Domain\Exception\ValidateException;
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

        switch (get_class($exception)) {
            case ValidateException::class:
                $userMessage = 'Invalid request';
                $errorCode = ErrorCodeMapper::ERROR_INVALID_REQUEST;
                break;
            case InvalidCredentialsException::class:
                $userMessage = 'Invalid user credentials';
                $errorCode = ErrorCodeMapper::ERROR_INVALID_REQUEST;
                break;
            case InvalidUserStatusException::class:
                $userMessage = 'Invalid user status';
                $errorCode = ErrorCodeMapper::ERROR_INVALID_USER_STATUS;
                break;
            default:
                $userMessage = 'General error';
                $errorCode = ErrorCodeMapper::ERROR_GENERAL;
        }

        return new ErrorResponse($errorCode, $message, $userMessage);
    }
}
