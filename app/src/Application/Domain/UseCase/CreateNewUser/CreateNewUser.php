<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateNewUser;

use App\Application\Domain\Command\Bus\CommandBusInterface;
use App\Application\Domain\Command\CreateNewUserAccountCommand;
use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Repository\UserRepositoryInterface;
use App\Application\Domain\ValueObject\EmailValueObject;
use App\Application\Domain\ValueObject\NameValueObject;
use App\Application\Domain\ValueObject\PasswordValueObject;

/**
 * Class CreateNewUser
 * @package App\Application\Domain\UseCase\CreateNewUser
 */
class CreateNewUser
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /** @var CommandBusInterface */
    private $commandBus;

    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * CreateNewUser constructor.
     * @param UserRepositoryInterface $userRepository
     * @param CommandBusInterface $commandBus
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct(UserRepositoryInterface $userRepository, CommandBusInterface $commandBus, ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory)
    {
        $this->userRepository = $userRepository;
        $this->commandBus = $commandBus;
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
            $email = new EmailValueObject($request->getEmail());
            $nick = new NameValueObject($request->getNick());
            $password = new PasswordValueObject($request->getPassword());

            $command = new CreateNewUserAccountCommand($email, $password, $nick);
            $this->commandBus->handle($command);

            $user = $this->userRepository->getUserByEmailAndPassword($email->value(), $password->value());

            $response->setUser($user);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
