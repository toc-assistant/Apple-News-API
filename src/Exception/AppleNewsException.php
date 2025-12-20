<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Exception;

use Exception;
use Throwable;

/**
 * Base exception class for all errors returned by the Apple News API.
 *
 * This class parses the standardized error format returned by Apple and
 * provides access to specific API error codes and key paths (field names).
 */
class AppleNewsException extends Exception
{
    /** @var string|null The specific Apple News API error code. */
    protected ?string $errorCode = null;

    /** @var string|null The field path in the request that caused the error. */
    protected ?string $keyPath = null;

    /**
     * @param string $message Exception message.
     * @param int $code HTTP status code.
     * @param Throwable|null $previous Previous exception.
     * @param string|null $errorCode API-specific error code.
     * @param string|null $keyPath Field path where error occurred.
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        ?string $errorCode = null,
        ?string $keyPath = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->keyPath = $keyPath;
    }

    /**
     * Get the specific Apple News API error code (e.g., INVALID_REVISION).
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Get the path to the field that failed validation.
     * @return string|null
     */
    public function getKeyPath(): ?string
    {
        return $this->keyPath;
    }

    /**
     * Factory method to create an exception from a standard API error response.
     *
     * @param array<string, mixed> $response Decoded JSON error response.
     * @param int $httpCode HTTP status code from the response.
     * @return self
     */
    public static function fromResponse(array $response, int $httpCode = 0): self
    {
        $errors = $response['errors'] ?? [];
        $firstError = $errors[0] ?? [];

        $message = $firstError['message'] ?? $response['message'] ?? 'Unknown Apple News API error';
        $errorCode = $firstError['code'] ?? null;
        $keyPath = $firstError['keyPath'] ?? null;

        return new self($message, $httpCode, null, $errorCode, $keyPath);
    }
}

