<?php
declare(strict_types=1);

namespace App\Security;

use App\Application\Domain\Common\Factory\ErrorResponseFactory\ErrorResponseFromExceptionFactoryInterface;
use App\Application\Domain\Common\Mapper\ErrorCodeMapper;
use App\Application\Domain\Common\Mapper\ErrorResponseFieldMapper;
use App\Application\Domain\Common\Mapper\RequestFieldMapper;
use App\Application\Domain\Common\Response\ErrorResponse;
use App\Application\Domain\Exception\EntityNotFoundException;
use App\Application\Domain\Repository\UserTokenRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;


class TokenAuthenticatorMiddleware extends AbstractGuardAuthenticator
{
    const AUTHENTICATION_WHITELIST = [
        '#/api/v1/auth/authenticate#',
    ];

    /** @var ErrorResponseFromExceptionFactoryInterface */
    private $errorResponseFromExceptionFactory;

    /** @var UserTokenRepositoryInterface */
    private $userTokenRepository;

    /**
     * TokenAuthenticatorMiddleware constructor.
     * @param ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory
     * @param UserTokenRepositoryInterface $userTokenRepository
     */
    public function __construct(ErrorResponseFromExceptionFactoryInterface $errorResponseFromExceptionFactory, UserTokenRepositoryInterface $userTokenRepository)
    {
        $this->errorResponseFromExceptionFactory = $errorResponseFromExceptionFactory;
        $this->userTokenRepository = $userTokenRepository;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning false will cause this authenticator
     * to be skipped.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request)
    {
        foreach (self::AUTHENTICATION_WHITELIST as $item) {
            if (preg_match_all($item, $request->getRequestUri(), $result)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Called on every request. Return whatever credentials you want to
     * be passed to getUser() as $credentials.
     *
     * @param Request $request
     * @return mixed|string|null
     */
    public function getCredentials(Request $request)
    {
        return $request->headers->get(RequestFieldMapper::AUTH_TOKEN, '');
    }

    /**
     * @param mixed $credentials
     * @param UserProviderInterface $userProvider
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if (empty($credentials)) {
            // The token header was empty, authentication fails with 401
            return null;
        }

        try {
            $userToken = $this->userTokenRepository->getTokenByTokenKey($credentials);
            if ($userToken->getUser()->getStatus() === 1) {
                return $userToken->getUser();
            }
        } catch (EntityNotFoundException $exception) {
        }
        return null;
    }

    /**
     * @param mixed $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // check credentials - e.g. make sure the password is valid
        // no credential check is needed in this case

        // return true to cause authentication success
        return true;
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // on success, let the request continue
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return JsonResponse|Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $error = new ErrorResponse(ErrorCodeMapper::ERROR_INVALID_USER_TOKEN, "Access Denied!", "Invalid user X-AUTH-TOKEN");
        return new JsonResponse([ErrorResponseFieldMapper::ERROR_FIELD => $error->toArray()], Response::HTTP_FORBIDDEN);
    }

    /**
     * Called when authentication is needed, but it's not sent
     *
     * @param Request $request
     * @param AuthenticationException|null $authException
     * @return JsonResponse|Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = [
            // you might translate this message
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
