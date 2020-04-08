<?php
declare(strict_types=1);

namespace App\Application\Domain\Command\Bus;

use App\Application\Domain\Command\CommandInterface;
use App\Application\Domain\Command\HandlerResolver\HandlerResolverInterface;

class SimpleCommandBus implements CommandBusInterface
{
    /** @var HandlerResolverInterface */
    protected $handlerResolver;

    /**
     * SimpleCommandBus constructor.
     * @param HandlerResolverInterface $handlerResolver
     */
    public function __construct(HandlerResolverInterface $handlerResolver)
    {
        $this->handlerResolver = $handlerResolver;
    }

    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command): void
    {
        $handler = $this->handlerResolver->handler($command);
        $handler->handle($command);
    }
}
