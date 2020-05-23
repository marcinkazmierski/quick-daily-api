<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\LeftUserCall;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\LeftUserCall\LeftUserCallPresenterInterface;
use App\Application\Domain\UseCase\LeftUserCall\LeftUserCallResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LeftUserCallPresenter
 * @package App\Application\Infrastructure\UseCase\LeftUserCall
 */
class LeftUserCallPresenter extends AbstractPresenter implements LeftUserCallPresenterInterface
{
    /**
     * @var LeftUserCallResponse $response
     */
    private $response;

    /**
     * @param LeftUserCallResponse $response
     */
    public function present(LeftUserCallResponse $response): void
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
