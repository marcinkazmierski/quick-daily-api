<?php
declare(strict_types=1);

namespace App\Application\Infrastructure\UseCase\GetTeams;

use App\Application\Domain\Common\Factory\EntityResponseFactory\TeamResponseFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\Common\Mapper\ResponseFieldMapper;
use App\Application\Domain\Entity\Team;
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
    /** @var TeamResponseFactoryInterface */
    private $teamResponseFactory;
    /**
     * @var GetTeamsResponse $response
     */
    private $response;

    /**
     * GetTeamsPresenter constructor.
     * @param TeamResponseFactoryInterface $teamResponseFactory
     */
    public function __construct(TeamResponseFactoryInterface $teamResponseFactory)
    {
        $this->teamResponseFactory = $teamResponseFactory;
    }

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

        $teams = [];
        /** @var Team $team */
        foreach ($this->response->getTeams() as $team) {
            $teams[] = $this->teamResponseFactory->create($team);
        }

        return new JsonResponse([ResponseFieldMapper::TEAM_SECTION => $teams], JsonResponse::HTTP_OK);
    }
}
