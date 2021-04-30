<?php

namespace Prokl\SymfonyMiddlewareBundle\ControllersMiddleware\Exceptions;

use Prokl\BaseException\BaseException;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

/**
 * Class WrongCsrfException
 * @package Local\Services\ControllerMiddleware\Exceptions
 *
 * @since 19.11.2020
 */
class WrongCsrfException extends BaseException implements RequestExceptionInterface
{
}
