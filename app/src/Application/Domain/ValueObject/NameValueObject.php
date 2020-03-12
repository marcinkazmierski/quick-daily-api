<?php
declare(strict_types=1);


namespace App\Application\Domain\ValueObject;


use App\Application\Domain\Exception\ValidateException;

class NameValueObject implements ValueObjectInterface
{
    /** @var string */
    private $name;

    /**
     * NameValueObject constructor.
     * @param string $name
     * @throws ValidateException
     */
    public function __construct(string $name)
    {
        $this->validate($name);
        $this->name = $name;
    }

    /**
     * @param string $name
     * @throws ValidateException
     */
    public function validate(string $name): void
    {
        if (empty($name)) {
            throw new ValidateException('Empty name!');
        } elseif (!is_string($name)) {
            throw new ValidateException('Invalid name!');
        } elseif (!preg_match('/^[0-9a-zA-ZęóąśłżźćńĘÓĄŚŁŻŹĆŃ ]+$/', $name)) {
            throw new ValidateException('Not allowed characters used: ' . $name);
        }
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}