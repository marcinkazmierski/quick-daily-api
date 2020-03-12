<?php
declare(strict_types=1);

namespace App\Command;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepositoryInterface;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUser;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserPresenterInterface;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * A console command for creating a new user account
 *
 *
 *     $ php bin/console user:create EMAIL NICK PASSWORD
 */
class CreateNewUserCommand extends Command
{
    const PARAM_NICK = 'nick';
    const PARAM_EMAIL = 'email';
    const PARAM_PASSWORD = 'password';

    protected static $defaultName = 'user:create';

    /** @var SymfonyStyle */
    protected $io;

    /** @var CreateNewUser */
    protected $useCase;

    /** @var CreateNewUserPresenterInterface */
    protected $presenter;

    /**
     * CreateNewUserCommand constructor.
     * @param CreateNewUser $useCase
     * @param CreateNewUserPresenterInterface $presenter
     */
    public function __construct(CreateNewUser $useCase, CreateNewUserPresenterInterface $presenter)
    {
        $this->useCase = $useCase;
        $this->presenter = $presenter;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->addArgument(
                self::PARAM_EMAIL,
                InputArgument::REQUIRED,
                'Email'
            )
            ->addArgument(
                self::PARAM_NICK,
                InputArgument::REQUIRED,
                'Nick'
            )
            ->addArgument(
                self::PARAM_PASSWORD,
                InputArgument::REQUIRED,
                'Password'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $nick = (string)$input->getArgument(self::PARAM_NICK);
        $email = (string)$input->getArgument(self::PARAM_EMAIL);
        $password = (string)$input->getArgument(self::PARAM_PASSWORD);

        $request = new CreateNewUserRequest($email, $password, $nick);
        $this->useCase->execute($request, $this->presenter);

        $result = $this->presenter->view();

        if ($result['status'] === 'success') {
            $this->io->success($result['message']);
            return 0;
        }

        $this->io->error($result['message']);
        return 1;

    }
}
