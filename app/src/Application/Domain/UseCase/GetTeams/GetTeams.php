<?php
declare(strict_types=1);

namespace App\Application\Domain\UseCase\GetTeams;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;

/**
 * Class GetTeams
 * @package App\Application\Domain\UseCase\GetTeams
 */
class GetTeams
{
    /** @var ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory */
    private $errorResponseFromExceptionFactory;

    /**
     * GetTeams constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     */
    public function __construct
    (
        ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
    )
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
    }

    /**
     * @param GetTeamsRequest $request
     * @param GetTeamsPresenterInterface $presenter
     */
    public function execute(
        GetTeamsRequest $request,
        GetTeamsPresenterInterface $presenter)
    {
        $response = new GetTeamsResponse();
        try {
            $teams = $request->getUser()->getTeams()->toArray();
            $response->setTeams($teams);
        } catch (\Throwable $e) {
            $error = $this->errorResponseFromExceptionFactory->create($e);
            $response->setError($error);
        }
        $presenter->present($response);
    }
}
