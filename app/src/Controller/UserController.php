<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Entity\User;
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
}
