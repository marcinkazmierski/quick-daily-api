<?php
declare(strict_types=1);

namespace App\Command;

use App\Application\Domain\Entity\User;
use App\Application\Domain\Repository\UserRepositoryInterface;
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

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * CreateNewUserCommand constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserRepositoryInterface $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userRepository = $userRepository;
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
        try {
            //todo: validation
            $nick = (string)$input->getArgument(self::PARAM_NICK);
            $email = (string)$input->getArgument(self::PARAM_EMAIL);
            $password = (string)$input->getArgument(self::PARAM_PASSWORD);

            $user = new User();
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $password);
            $user->setPassword($encodedPassword);
            $user->setEmail($email);
            $user->setNick($nick);
            $this->userRepository->save($user);
            $this->io->success(
                sprintf('New account created! ID: "%d"', $user->getId())
            );
            return 0;
        } catch (\Throwable $exception) {
            $this->io->error(
                sprintf('Exception "%s"', $exception->getMessage())
            );
            return 1;
        }
    }
}
