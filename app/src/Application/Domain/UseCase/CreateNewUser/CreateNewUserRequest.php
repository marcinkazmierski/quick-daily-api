<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\CreateNewUser;

/**
 * Class CreateNewUserRequest
 * @package App\Application\Domain\UseCase\CreateNewUser
 */
class CreateNewUserRequest
{
    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /** @var string */
    private $nick;

    /**
     * CreateNewUserRequest constructor.
     * @param string $email
     * @param string $password
     * @param string $nick
     */
    public function __construct(string $email, string $password, string $nick)
    {
        $this->email = $email;
        $this->password = $password;
        $this->nick = $nick;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getNick(): string
    {
        return $this->nick;
    }
}
