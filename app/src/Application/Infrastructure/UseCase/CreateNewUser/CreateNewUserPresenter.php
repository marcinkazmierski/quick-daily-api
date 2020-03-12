<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\CreateNewUser;

use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserPresenterInterface;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;

/**
 * Class CreateNewUserPresenter
 * @package App\Application\Infrastructure\UseCase\CreateNewUser
 */
class CreateNewUserPresenter extends AbstractPresenter implements CreateNewUserPresenterInterface
{
    /**
     * @var CreateNewUserResponse $response
     */
    private $response;

    /**
     * @param CreateNewUserResponse $response
     */
    public function present(CreateNewUserResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function view()
    {
        if ($this->response->hasError()) {
            return [
                'status' => 'error',
                'message' => $this->response->getError()->getMessage(),
            ];
        }

        return [
            'status' => 'success',
            'message' => sprintf('New account created! ID: "%d"', $this->response->getUser()->getId()),
        ];
    }
}
