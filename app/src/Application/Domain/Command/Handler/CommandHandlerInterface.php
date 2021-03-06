<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\Handler;


use App\Application\Domain\Command\CommandInterface;

interface CommandHandlerInterface
{
    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command): void;
}
