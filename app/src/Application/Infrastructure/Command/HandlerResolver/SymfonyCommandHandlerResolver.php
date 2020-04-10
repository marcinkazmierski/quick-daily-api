<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\Command\HandlerResolver;

use App\Application\Domain\Command\CommandInterface;
use App\Application\Domain\Command\Handler\CommandHandlerInterface;
use App\Application\Domain\Command\HandlerResolver\HandlerResolverInterface;
use App\Application\Domain\Exception\CommandHandlerNotFoundException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SymfonyCommandHandlerResolver implements HandlerResolverInterface
{
    /** @var ContainerInterface */
    private $container;

    /**
     * SymfonyCommandHandlerResolver constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param CommandInterface $command
     * @return CommandHandlerInterface
     * @throws CommandHandlerNotFoundException
     */
    public function handler(CommandInterface $command): CommandHandlerInterface
    {
        try {
            $handlerContainerName = $this->getHandlerName($command);

            if (!$this->container->has($handlerContainerName)) {
                throw new CommandHandlerNotFoundException(get_class($command));
            }

            $commandHandler = $this->container->get($handlerContainerName);
            if ($commandHandler instanceof CommandHandlerInterface) {
                return $commandHandler;
            }
        } catch (\Throwable $e) {
            // todo: logger
        }
        throw new CommandHandlerNotFoundException(get_class($command));
    }

    /**
     * @param $command
     * @return string
     * @throws \ReflectionException
     */
    private function getHandlerName($command): string
    {
        $name = (new \ReflectionClass($command))->getShortName();
        $name = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));;
        $handlerName = str_replace('_command', '', $name);
        return 'app.command_handler.' . $handlerName;
    }
}
