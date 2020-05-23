<?php
declare(strict_types=1);
namespace App\Application\Domain\UseCase\LeftUserCall;

/**
 * Interface LeftUserCallPresenterInterface
 * @package App\Application\Domain\UseCase\LeftUserCall
 */
interface LeftUserCallPresenterInterface
{
    /**
     * @param LeftUserCallResponse $response
     */
    public function present(LeftUserCallResponse $response): void;

    /**
     * @return mixed
     */
    public function view();
}
