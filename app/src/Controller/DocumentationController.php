<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Info(title="Quick Daily REST API", version="0.1")
 * @Route("")
 *
 * Class DocumentationController
 * @package App\Controller
 */
class DocumentationController extends AbstractController
{
    /**
     * Homepage - documentation page.
     *
     * @OA\Get(
     *     path="/",
     *     description="Documentation page",
     *     tags={"Documentation"},
     *     @OA\Response(response="200", description="Swagger documentation page")
     * )
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="documentation"
     * )
     *
     * @return Response
     */
    public function ui()
    {
        return $this->render('pages/documentation/ui.html.twig', []);
    }

    /**
     * @Route(
     *     "/yaml",
     *     methods={"GET"},
     *     name="documentation_api_yaml"
     * )
     *
     * @return Response
     */
    public function generateDocsYaml()
    {
        $openapi = \OpenApi\scan('./../src/Controller');
        $yaml = $openapi->toYaml();
        return new Response($yaml, Response::HTTP_OK);
    }
}

/**
 * == SCHEMAS ==
 * @OA\Schema(
 *    schema="ErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1xxx"),
 *        @OA\Property( property = "message", type = "string", example="XXX"),
 *        @OA\Property( property = "userMessage", type = "string", example="XXX")
 *    ),
 * ),
 * @OA\Schema(
 *    schema="GeneralErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1001"),
 *        @OA\Property( property = "message", type = "string", example="General error"),
 *        @OA\Property( property = "userMessage", type = "string", example="Failed! Something has gone wrong. Please contact a system administrator.")
 *    ),
 * ),
 * @OA\Schema(
 *    schema="InvalidTokenErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1004"),
 *        @OA\Property( property = "message", type = "string", example="Access Denied!"),
 *        @OA\Property( property = "userMessage", type = "string", example="Invalid user X-AUTH-TOKEN")
 *    ),
 * ),
 * @OA\Schema(
 *    schema="BadRequestErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1002"),
 *        @OA\Property( property = "message", type = "string", example="Invalid request"),
 *        @OA\Property( property = "userMessage", type = "string", example="XXX")
 *    ),
 * ),
 *
 * @OA\Schema(
 *    schema="id",
 *    type="integer",
 *    example=123,
 * ),
 *
 * @OA\Schema(
 *     schema="text",
 *     description="Some text",
 *     type="string",
 *     example="Lorem ipsum dolor sit amet...",
 * ),
 *
 * @OA\Schema(
 *     schema="email",
 *     description="User email",
 *     type="string",
 *     example="test@test.pl",
 * ),
 *
 * @OA\Schema(
 *     schema="password",
 *     description="User account password",
 *     type="string",
 *     example="SecretPassword",
 * ),
 *
 * @OA\Schema(
 *     schema="token",
 *     description="User auth access token",
 *     type="string",
 *     example="1a4ee6defb35d3ec89fef66321284ae4137ba0c48c5c63de90ea7956e13cd975a51cceae0b2a1111e7e561a5ed0e",
 * ),
 *
 * @OA\Schema(
 *     schema="User",
 *     type = "object",
 *     @OA\Property(property="id", ref="#/components/schemas/id"),
 *     @OA\Property(property="name", ref="#/components/schemas/text"),
 *     @OA\Property(property="nick", ref="#/components/schemas/text"),
 *     @OA\Property(property="email", ref="#/components/schemas/email"),
 *     @OA\Property(property="status", ref="#/components/schemas/userStatus"),
 * ),
 *
 * @OA\Schema(
 *    schema="userStatus",
 *    type="integer",
 *    example=1,
 *    description="User account status: 1-active"
 * ),
 *
 * @OA\Schema(
 *     schema="Team",
 *     type = "object",
 *     @OA\Property(property="id", ref="#/components/schemas/id"),
 *     @OA\Property(property="name", ref="#/components/schemas/text"),
 *     @OA\Property(property="description", ref="#/components/schemas/text"),
 *     @OA\Property(property="image", ref="#/components/schemas/text"),
 * ),
 *
 * == PARAMETERS ==
 * @OA\Parameter(
 *      name="X-AUTH-TOKEN",
 *      in="header",
 *      required=true,
 *      description="User access token",
 *      @OA\Schema(ref="#/components/schemas/token"),
 * ),
 *
 * == COMPONENTS ==
 * @OA\Components(
 *     @OA\Response(
 *         response="generalError",
 *         description="Internal Server Error",
 *         @OA\JsonContent(ref="#/components/schemas/GeneralErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="invalidToken",
 *         description="Invalid token",
 *         @OA\JsonContent(ref="#/components/schemas/InvalidTokenErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="badRequest",
 *         description="Bad Request. Path parameters do not reflect any resources in the database and/or body parameter are invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/BadRequestErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="noContent",
 *         description="No Content. The server successfully processed the request and is not returning any content.",
 *     ),
 *     @OA\Response(
 *         response="created",
 *         description="The request has been fulfilled, resulting in the creation of a new resource.",
 *     ),
 * ),
 */