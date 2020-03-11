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
    public function generateDocsYaml( )
    {
        $openapi = \OpenApi\scan('./../src/Controller');
        $yaml= $openapi->toYaml();
        return new Response($yaml, Response::HTTP_OK);
    }
}

/**
 * @OA\Schema(
 *    schema="ErrorResponse",
 *    type = "object",
 *    @OA\Property(
 *        property = "error",
 *        type = "object",
 *        @OA\Property( property = "code", type = "string", example="1001"),
 *        @OA\Property( property = "message", type = "string", example="General error"),
 *        @OA\Property( property = "userMessage", type = "string", example="Failed! Something has gone wrong. Please contact a system administrator.")
 *    ),
 * ),
 *
 * @OA\Schema(
 *    schema="id",
 *    type="integer",
 *    example=123,
 * ),
 *
 * @OA\Components(
 *     @OA\Response(
 *         response="generalError",
 *         description="Internal Server Error",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="invalidToken",
 *         description="Invalid token",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
 *     ),
 *     @OA\Response(
 *         response="badRequest",
 *         description="Bad Request. Path parameters do not reflect any resources in the database and/or body parameter are invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
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