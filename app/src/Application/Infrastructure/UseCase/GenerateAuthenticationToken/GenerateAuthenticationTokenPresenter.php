<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GenerateAuthenticationToken;

use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenResponse;
use App\Application\Infrastructure\Common\AbstractPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GenerateAuthenticationTokenPresenter
 * @package App\Application\Infrastructure\UseCase\GenerateAuthenticationToken
 */
class GenerateAuthenticationTokenPresenter extends AbstractPresenter implements GenerateAuthenticationTokenPresenterInterface
{
    /**
     * @var GenerateAuthenticationTokenResponse $response
     */
    private $response;

    /**
     * @param GenerateAuthenticationTokenResponse $response
     */
    public function present(GenerateAuthenticationTokenResponse $response): void
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

        $responseData = [
            ResponseFieldMapper::AUTH_TOKEN => $this->response->getTokenKey(),
            ResponseFieldMapper::USER_ID => $this->response->getUser()->getId(),
        ];

        return new JsonResponse($responseData, JsonResponse::HTTP_OK);
    }
}
