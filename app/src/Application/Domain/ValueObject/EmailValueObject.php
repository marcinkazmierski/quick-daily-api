<?php
declare(strict_types=1);

namespace App\Application\Domain\ValueObject;

use App\Application\Domain\Exception\ValidateException;

/**
 * Class EmailValueObject
 * @package App\Application\Domain\ValueObject
 */
class EmailValueObject implements ValueObjectInterface
{
    /** @var string $email */
    private $email;

    /**
     * EmailValueObject constructor.
     * @param string $email
     * @throws ValidateException
     */
    public function __construct(string $email)
    {
        $this->validate($email);
        $this->email = strtolower($email);
    }

    /**
     * @param string $email
     * @throws ValidateException
     */
    private function validate(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException('Invalid email!');
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }
}