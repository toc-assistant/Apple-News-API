<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Response;

/**
 * Warning message returned by the Apple News API for non-fatal issues.
 *
 * Warnings indicate problems that did not prevent the request from succeeding,
 * but may affect how the article appears or behaves. You should review warnings
 * and address them when possible.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/warning
 */
final class Warning
{
    /**
     * Create a new Warning instance.
     *
     * @param string      $code    The warning code identifying the type of warning.
     * @param string|null $keyPath The path to the field that triggered the warning, if applicable.
     * @param string|null $message A human-readable description of the warning.
     */
    public function __construct(
        public readonly string $code,
        public readonly ?string $keyPath = null,
        public readonly ?string $message = null,
    ) {
    }

    /**
     * Create a Warning instance from API response data.
     *
     * @param array<string, mixed> $data The warning data from the API response.
     *
     * @return self A new Warning instance populated with the response data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data['code'] ?? 'UNKNOWN',
            keyPath: $data['keyPath'] ?? null,
            message: $data['message'] ?? null,
        );
    }

    /**
     * Create multiple Warning instances from an array of warning data.
     *
     * @param array<int, array<string, mixed>> $warnings Array of warning data from the API response.
     *
     * @return list<self> List of Warning instances.
     */
    public static function fromArrayList(array $warnings): array
    {
        return array_map(
            static fn(array $warning) => self::fromArray($warning),
            $warnings
        );
    }
}

