<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;
use App\Application\Domain\UseCase\GetUser\GetUser;
use App\Application\Domain\UseCase\GetUser\GetUserPresenterInterface;
use App\Application\Domain\UseCase\GetUser\GetUserRequest;
use App\Application\Domain\UseCase\LeftUserCall\LeftUserCall;
use App\Application\Domain\UseCase\LeftUserCall\LeftUserCallPresenterInterface;
use App\Application\Domain\UseCase\LeftUserCall\LeftUserCallRequest;
use App\Application\Domain\UseCase\UserCall\UserCall;
use App\Application\Domain\UseCase\UserCall\UserCallPresenterInterface;
use App\Application\Domain\UseCase\UserCall\UserCallRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * @Route("/api/v1/users")
 *
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * Init user call in team.
     *
     * @OA\Post(
     *     path="/api/v1/users/call",
     *     description="Init user call",
     *     tags = {"Call"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="callId", ref="#/components/schemas/text"),
     *          @OA\Property(property="teamId", ref="#/components/schemas/id"),
     *      ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Todo",
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/invalidToken"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "/call",
     *     methods={"POST"},
     *     name="init-user-call"
     * )
     * @param Request $request
     * @param UserCall $usecase
     * @param UserCallPresenterInterface $presenter
     * @return JsonResponse
     */
    public function call(
        Request $request,
        UserCall $usecase,
        UserCallPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $content = json_decode($request->getContent(), true);

        $callId = (string)($content[RequestFieldMapper::CALL_ID] ?? '');
        $teamId = (int)($content[RequestFieldMapper::TEAM_ID] ?? 0);

        $input = new UserCallRequest($currentUser, $callId, $teamId);
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }


    /**
     * @Route(
     *     "/current",
     *     methods={"GET"},
     *     name="get-current-user"
     * )
     * @param Request $request
     * @param GetUser $usecase
     * @param GetUserPresenterInterface $presenter
     * @return JsonResponse
     */
    public function getCurrentUser(
        Request $request,
        GetUser $usecase,
        GetUserPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $input = new GetUserRequest($currentUser, '');
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }

    /**
     * @Route(
     *     "/{callId}",
     *     methods={"GET"},
     *     name="get-user-by-callid"
     * )
     * @param Request $request
     * @param string $callId
     * @param GetUser $usecase
     * @param GetUserPresenterInterface $presenter
     * @return JsonResponse
     */
    public function getUserByCallId(
        Request $request,
        string $callId,
        GetUser $usecase,
        GetUserPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $content = json_decode($request->getContent(), true);

        $input = new GetUserRequest($currentUser, $callId);
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }

    /**
     * Left user call in team.
     *
     * @OA\Post(
     *     path="/api/v1/users/call/left",
     *     description="Left user call",
     *     tags = {"Call"},
     *     @OA\Parameter(ref="#/components/parameters/X-AUTH-TOKEN"),
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="callId", ref="#/components/schemas/text"),
     *          @OA\Property(property="teamId", ref="#/components/schemas/id"),
     *      ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Done.",
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/invalidToken"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "/call/left",
     *     methods={"POST"},
     *     name="left-user-call"
     * )
     * @param Request $request
     * @param LeftUserCall $usecase
     * @param LeftUserCallPresenterInterface $presenter
     * @return JsonResponse
     */
    public function leftCall(
        Request $request,
        LeftUserCall $usecase,
        LeftUserCallPresenterInterface $presenter
    ): JsonResponse
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $content = json_decode($request->getContent(), true);

        $callId = (string)($content[RequestFieldMapper::CALL_ID] ?? '');
        $teamId = (int)($content[RequestFieldMapper::TEAM_ID] ?? 0);

        $input = new LeftUserCallRequest($currentUser, $callId, $teamId);
        $usecase->execute($input, $presenter);
        return $presenter->view();
    }
}
