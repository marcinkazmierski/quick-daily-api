<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\Bus;

use App\Application\Domain\Command\CommandInterface;

interface CommandBusInterface
{
    /**
     * @param CommandInterface $command
     * @throws \App\Application\Domain\Exception\CommandHandlerNotFoundException
     */
    public function handle(CommandInterface $command): void;
}