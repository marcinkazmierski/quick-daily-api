<?php
declare(strict_types=1);


namespace App\Application\Domain\ValueObject;


/**
 * Interface ValueObjectInterface
 * @package App\Application\Domain\ValueObject
 */
interface ValueObjectInterface
{
    /**
     * @return mixed
     */
    public function value();
}