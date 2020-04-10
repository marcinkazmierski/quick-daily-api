<?php
declare(strict_types=1);

namespace App\Application\Domain\Command;

use App\Application\Domain\ValueObject\EmailValueObject;
use App\Application\Domain\ValueObject\NameValueObject;
use App\Application\Domain\ValueObject\PasswordValueObject;

class CreateNewUserAccountCommand implements CommandInterface
{
    /** @var EmailValueObject $email */
    private $email;

    /** @var PasswordValueObject $password */
    private $password;

    /** @var NameValueObject */
    private $nick;

    /**
     * CreateNewUserAccountCommand constructor.
     * @param EmailValueObject $email
     * @param PasswordValueObject $password
     * @param NameValueObject $nick
     */
    public function __construct(EmailValueObject $email, PasswordValueObject $password, NameValueObject $nick)
    {
        $this->email = $email;
        $this->password = $password;
        $this->nick = $nick;
    }

    /**
     * @return EmailValueObject
     */
    public function getEmail(): EmailValueObject
    {
        return $this->email;
    }

    /**
     * @return PasswordValueObject
     */
    public function getPassword(): PasswordValueObject
    {
        return $this->password;
    }

    /**
     * @return NameValueObject
     */
    public function getNick(): NameValueObject
    {
        return $this->nick;
    }
}
