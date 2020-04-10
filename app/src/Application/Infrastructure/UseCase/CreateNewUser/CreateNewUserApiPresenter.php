<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\CreateNewUser;

use App\Application\Domain\Common\Factory\EntityResponseFactory\UserResponseFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserPresenterInterface;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateNewUserApiPresenter
 * @package App\Application\Infrastructure\UseCase\CreateNewUser
 */
class CreateNewUserApiPresenter extends AbstractPresenter implements CreateNewUserPresenterInterface
{
    /** @var UserResponseFactoryInterface */
    private $userResponseFactory;

    /**
     * @var CreateNewUserResponse $response
     */
    private $response;

    /**
     * CreateNewUserApiPresenter constructor.
     * @param UserResponseFactoryInterface $userResponseFactory
     */
    public function __construct(UserResponseFactoryInterface $userResponseFactory)
    {
        $this->userResponseFactory = $userResponseFactory;
    }


    /**
     * @param CreateNewUserResponse $response
     */
    public function present(CreateNewUserResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * @return JsonResponse
     */
    public function view()
    {
        if ($this->response->hasError()) {
            switch ($this->response->getError()->getCode()) {
                case ErrorCodeMapper::ERROR_GENERAL:
                    $statusCode = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                    break;
                default:
                    $statusCode = JsonResponse::HTTP_BAD_REQUEST;
            }
            return $this->viewErrorResponse($this->response->getError(), $statusCode);
        }

        $data = $this->userResponseFactory->create($this->response->getUser());
        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
