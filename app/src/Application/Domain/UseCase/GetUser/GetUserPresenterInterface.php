<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\GetUser;

/**
 * Interface GetUserPresenterInterface
 * @package App\Application\Domain\UseCase\GetUser
 */
interface GetUserPresenterInterface
{
    /**
     * @param GetUserResponse $response
     */
    public function present(GetUserResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
