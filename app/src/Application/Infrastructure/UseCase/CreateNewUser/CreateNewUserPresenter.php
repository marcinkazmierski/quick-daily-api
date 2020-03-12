<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\CreateNewUser;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserPresenterInterface;
use App\Application\Domain\UseCase\CreateNewUser\CreateNewUserResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

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
