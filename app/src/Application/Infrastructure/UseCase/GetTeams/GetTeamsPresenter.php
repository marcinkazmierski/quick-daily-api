<?php
declare(strict_types=1);
namespace App\Application\Infrastructure\UseCase\GetTeams;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\UseCase\GetTeams\GetTeamsPresenterInterface;
use App\Application\Domain\UseCase\GetTeams\GetTeamsResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GetTeamsPresenter
 * @package App\Application\Infrastructure\UseCase\GetTeams
 */
class GetTeamsPresenter extends AbstractPresenter implements GetTeamsPresenterInterface
{
    /**
     * @var GetTeamsResponse $response
     */
    private $response;

    /**
     * @param GetTeamsResponse $response
     */
    public function present(GetTeamsResponse $response): void
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
