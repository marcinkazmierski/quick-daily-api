<?php
declare(strict_types=1);

namespace App\Controller;

use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationToken;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenPresenterInterface;
use App\Application\Domain\UseCase\GenerateAuthenticationToken\GenerateAuthenticationTokenRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;


/**
 * @Route("/api/v1/auth")
 *
 * Class AuthenticationController
 * @package App\Controller
 */
class AuthenticationController extends AbstractController
{
    /**
     * User authentication
     *
     * @OA\Post(
     *     path="/api/v1/auth/authenticate",
     *     description="User authentication. Receive access token for further auth.",
     *     tags = {"Authentication"},
     *     @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="email", ref="#/components/schemas/email"),
     *          @OA\Property(property="password", ref="#/components/schemas/password")
     *      ),
     *     ),
     *     @OA\Response(
     *      response="200",
     *      description="Return user X-AUTH-TOKEN",
     *      @OA\JsonContent(
     *          type = "object",
     *          @OA\Property(property="token", ref="#/components/schemas/token"),
     *          @OA\Property(property="id", ref="#/components/schemas/id")
     *      )
     *     ),
     *     @OA\Response(response="400", ref="#/components/responses/badRequest"),
     *     @OA\Response(response="500", ref="#/components/responses/generalError"),
     * ),
     *
     * @Route(
     *     "/authenticate",
     *     methods={"POST"},
     *     name="authenticate"
     * )
     *
     * @param Request $request
     * @param GenerateAuthenticationToken $authentication
     * @param GenerateAuthenticationTokenPresenterInterface $presenter
     * @return JsonResponse
     */
    public function authenticate(
        Request $request,
        GenerateAuthenticationToken $authentication,
        GenerateAuthenticationTokenPresenterInterface $presenter
    )
    {
        $content = json_decode($request->getContent(), true);
        $email = (string)($content[RequestFieldMapper::USER_EMAIL] ?? '');
        $password = (string)($content[RequestFieldMapper::PASSWORD] ?? '');

        $authenticationRequest = new GenerateAuthenticationTokenRequest($email, $password);
        $authentication->execute($authenticationRequest, $presenter);
        return $presenter->view();
    }
}
