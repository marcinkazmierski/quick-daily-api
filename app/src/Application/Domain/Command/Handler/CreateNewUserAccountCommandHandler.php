<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\Handler;

use App\Application\Domain\Command\CommandInterface;
use App\Application\Domain\Command\CreateNewUserAccountCommand;
use App\Application\Domain\Entity\User;
use App\Application\Domain\Exception\ValidateException;
use App\Application\Domain\Repository\UserRepositoryInterface;

class CreateNewUserAccountCommandHandler implements CommandHandlerInterface
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * CreateNewUserAccountCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param CommandInterface $command
     * @throws \Throwable
     */
    public function handle(CommandInterface $command): void
    {
        if ($command instanceof CreateNewUserAccountCommand) {
            $user = new User();
            $encodedPassword = $this->userRepository->encodePassword($user, $command->getPassword()->value());
            $user->setPassword($encodedPassword);
            $user->setEmail($command->getEmail()->value());
            $user->setNick($command->getNick()->value());
            $this->userRepository->save($user);
        } else {
            throw new ValidateException("Invalid Command Handler!");
        }
    }
}
