<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface MiddlewareInterface
 * @package Prokl\SymfonyMiddlewareBundle
 */
interface MiddlewareInterface
{
    /**
     * @param Request $request
     *
     * @return Response|null
     */
    public function handle(Request $request): ?Response;
}
