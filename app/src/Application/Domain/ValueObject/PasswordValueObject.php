<?php
declare(strict_types=1);


namespace App\Application\Domain\ValueObject;


use App\Application\Domain\Exception\ValidateException;

/**
 * Class PasswordValueObject
 * @package App\Application\Domain\ValueObject
 */
class PasswordValueObject implements ValueObjectInterface
{
    /** @var string $password */
    private $password;

    /**
     * PasswordValueObject constructor.
     * @param string $password
     * @throws ValidateException
     */
    public function __construct(string $password)
    {
        $this->validate($password);
        $this->password = $password;
    }

    /**
     * @param string $password
     * @throws ValidateException
     */
    private function validate(string $password): void
    {
        if (strlen($password) < 8) {
            throw new ValidateException('Password too short!');
        }
    }

    /**
     * @param PasswordValueObject $password
     * @return bool
     */
    public function equal(PasswordValueObject $password)
    {
        return $password->value() === $this->value();
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->password;
    }

    public function __toString()
    {
        return $this->password;
    }
}