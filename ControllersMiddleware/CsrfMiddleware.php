<?php

namespace Prokl\SymfonyMiddlewareBundle\ControllersMiddleware;

use Prokl\SymfonyMiddlewareBundle\ControllersMiddleware\Exceptions\WrongCsrfException;
use Prokl\SymfonyMiddlewareBundle\MiddlewareInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class CsrfMiddleware
 * @package Local\Services\ControllerMiddleware
 *
 * @since 19.11.2020
 */
class CsrfMiddleware implements MiddlewareInterface
{
    /**
     * @var CsrfTokenManagerInterface $csrfTokenManager CSRF токен менеджер.
     */
    private $csrfTokenManager;

    /**
     * CsrfMiddleware constructor.
     *
     * @param CsrfTokenManagerInterface $csrfTokenManager CSRF токен менеджер.
     */
    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    /**
     * @inheritDoc
     *
     * @throws WrongCsrfException Невалидный токен.
     */
    public function handle(Request $request): ?Response
    {
        $typeRequest = (string)$request->server->get('REQUEST_METHOD', '');
        $token = (string)$request->query->get('csrf_token');

        if ($typeRequest !== 'GET') {
            $token = (string)$request->request->get('csrf_token');
        }

        $bValidToken = $this->csrfTokenManager->isTokenValid(
            new CsrfToken('app', $token)
        );

        if (!$bValidToken) {
            throw new WrongCsrfException('Security error: Invalid CSRF token.');
        }

        return null;
    }
}
