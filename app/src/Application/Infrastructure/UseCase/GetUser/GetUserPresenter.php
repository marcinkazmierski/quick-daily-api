<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetUser;

use App\Application\Domain\Common\Factory\EntityResponseFactory\UserResponseFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\GetUser\GetUserPresenterInterface;
use App\Application\Domain\UseCase\GetUser\GetUserResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetUserPresenter
 * @package App\Application\Infrastructure\UseCase\GetUser
 */
class GetUserPresenter extends AbstractPresenter implements GetUserPresenterInterface
{
    /** @var UserResponseFactoryInterface */
    private $userResponseFactory;
    /**
     * @var GetUserResponse $response
     */
    private $response;

    /**
     * GetUserPresenter constructor.
     * @param UserResponseFactoryInterface $userResponseFactory
     */
    public function __construct(UserResponseFactoryInterface $userResponseFactory)
    {
        $this->userResponseFactory = $userResponseFactory;
    }


    /**
     * @param GetUserResponse $response
     */
    public function present(GetUserResponse $response): void
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
