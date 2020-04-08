<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\HandlerResolver;


use App\Application\Domain\Command\CommandInterface;
use App\Application\Domain\Command\Handler\CommandHandlerInterface;

interface HandlerResolverInterface
{
    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     */
    public function handler(CommandInterface $command): CommandHandlerInterface;
}