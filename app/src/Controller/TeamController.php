<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\GetTeams\GetTeams;
use App\Application\Domain\UseCase\GetTeams\GetTeamsPresenterInterface;
use App\Application\Domain\UseCase\GetTeams\GetTeamsRequest;
use App\Application\Domain\UseCase\GetTeamUsers\GetTeamUsers;
use App\Application\Domain\UseCase\GetTeamUsers\GetTeamUsersPresenterInterface;
use App\Application\Domain\UseCase\GetTeamUsers\GetTeamUsersRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/v1/teams")
 *
 * Class TeamController
 * @package App\Controller
 */
class TeamController extends AbstractController
{

    /**
     * Get user teams.
     *
     * @OA\Get(
     *     path="/api/v1/teams",
     *     description="Get user teams",
     *     tags = {"Team"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\Response(
     *      response="200",
     *      description="Array of teams",
     *      @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="teams", type="array", @OA\Items(ref="#/components/schemas/Team")),
     *      ),
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/invalidToken"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "",
     *     methods={"GET"},
     *     name="get-user-teams"
     * )
     * @param Request $request
     * @param GetTeams $usecase
     * @param GetTeamsPresenterInterface $presenter
     * @return JsonResponse
     */
    public function getTeams(
        Request $request,
        GetTeams $usecase,
        GetTeamsPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $content = json_decode($request->getContent(), true);

        $input = new GetTeamsRequest($currentUser);
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }

    /**
     *
     * @OA\Get(
     *     path="/api/v1/teams/{id}/users",
     *     description="Get user teams",
     *     tags = {"Team"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\Response(
     *      response="200",
     *      description="Array of teams",
     *      @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="teams", type="array", @OA\Items(ref="#/components/schemas/Team")),
     *      ),
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/invalidToken"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "/{id}/users",
     *     methods={"GET"},
     *     name="get-team-users"
     * )
     *
     * @param int $id
     * @param GetTeamUsers $usecase
     * @param GetTeamUsersPresenterInterface $presenter
     * @return JsonResponse
     */
    public function getUsersByTeam(
        int $id,
        GetTeamUsers $usecase,
        GetTeamUsersPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $input = new GetTeamUsersRequest($id, $currentUser);
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }
}
