<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\UserCall;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\UserCall\UserCallPresenterInterface;
use App\Application\Domain\UseCase\UserCall\UserCallResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserCallPresenter
 * @package App\Application\Infrastructure\UseCase\UserCall
 */
class UserCallPresenter extends AbstractPresenter implements UserCallPresenterInterface
{
    /**
     * @var UserCallResponse $response
     */
    private $response;

    /**
     * @param UserCallResponse $response
     */
    public function present(UserCallResponse $response): void
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
