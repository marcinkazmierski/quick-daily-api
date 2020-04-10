<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\HandlerResolver;


use App\Application\Domain\Command\CommandInterface;
use App\Application\Domain\Command\Handler\CommandHandlerInterface;
use App\Application\Domain\Exception\CommandHandlerNotFoundException;

interface HandlerResolverInterface
{
    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     * @throws CommandHandlerNotFoundException
     */
    public function handler(CommandInterface $command): CommandHandlerInterface;
}