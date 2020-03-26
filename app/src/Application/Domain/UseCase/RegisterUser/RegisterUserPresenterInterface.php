<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\RegisterUser;

/**
 * Interface RegisterUserPresenterInterface
 * @package App\Application\Domain\UseCase\RegisterUser
 */
interface RegisterUserPresenterInterface
{
    /**
     * @param RegisterUserResponse $response
     */
    public function present(RegisterUserResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
