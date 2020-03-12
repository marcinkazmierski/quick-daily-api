<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\CreateNewUser;

/**
 * Interface CreateNewUserPresenterInterface
 * @package App\Application\Domain\UseCase\CreateNewUser
 */
interface CreateNewUserPresenterInterface
{
    /**
     * @param CreateNewUserResponse $response
     */
    public function present(CreateNewUserResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
