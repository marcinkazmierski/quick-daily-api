<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\RegisterUser;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\RegisterUser\RegisterUserPresenterInterface;
use App\Application\Domain\UseCase\RegisterUser\RegisterUserResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RegisterUserPresenter
 * @package App\Application\Infrastructure\UseCase\RegisterUser
 */
class RegisterUserPresenter extends AbstractPresenter implements RegisterUserPresenterInterface
{
    /**
     * @var RegisterUserResponse $response
     */
    private $response;

    /**
     * @param RegisterUserResponse $response
     */
    public function present(RegisterUserResponse $response): void
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
        
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
