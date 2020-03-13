<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\UserCall;

/**
 * Interface UserCallPresenterInterface
 * @package App\Application\Domain\UseCase\UserCall
 */
interface UserCallPresenterInterface
{
    /**
     * @param UserCallResponse $response
     */
    public function present(UserCallResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
