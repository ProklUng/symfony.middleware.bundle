<?php
declare(strict_types=1);

namespace Prokl\SymfonyMiddlewareBundle\Middleware;

/**
 * Class MiddlewareEnum
 * @package Prokl\SymfonyMiddlewareBundle\Middleware
 */
abstract class MiddlewareEnum
{
    public const ALIAS_SUFFIX = 'middleware.alias';
    public const GLOBAL_TAG = 'middleware.global';
    public const CONTROLLER_TAG = 'middleware.controller';
}
