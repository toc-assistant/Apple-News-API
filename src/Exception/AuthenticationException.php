<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Exception;

/**
 * Exception thrown specifically when API authentication fails (401/403 errors).
 */
class AuthenticationException extends AppleNewsException
{
}

