<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GenerateAuthenticationToken;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Exception\InvalidCredentialsException;
use App\Application\Domain\Exception\InvalidUserStatusException;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;

/**
 * Class GenerateAuthenticationToken
 * @package App\Application\Domain\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationToken
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var UserTokenRepositoryInterface */
    private $userUserTokenRepository;

    /**
     * GenerateAuthenticationToken constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserRepositoryInterface $userRepository
     * @param UserTokenRepositoryInterface $userUserTokenRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserRepositoryInterface $userRepository, UserTokenRepositoryInterface $userUserTokenRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userRepository = $userRepository;
        $this->userUserTokenRepository = $userUserTokenRepository;
    }


    /**
     * @param GenerateAuthenticationTokenRequest $request
     * @param GenerateAuthenticationTokenPresenterInterface $presenter
     */
    public function execute(
        GenerateAuthenticationTokenRequest $request,
        GenerateAuthenticationTokenPresenterInterface $presenter)
    {
        $response = new GenerateAuthenticationTokenResponse();
        try {
            try {
                $user = $this->userRepository->getUserByEmailAndPassword($request->getEmail(), $request->getPassword());
            } catch (EntityNotFoundException $e) {
                throw new InvalidCredentialsException("Invalid login or password");
            }
            if ($user->getStatus() !== 1) {
                throw new InvalidUserStatusException(sprintf("User account is not active"));
            }

            $token = $this->userUserTokenRepository->generateToken($user);
            $response->setTokenKey($token->getTokenKey());
            $response->setUser($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
