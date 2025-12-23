<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Response;

/**
 * Meta object wrapping throttling information from Create/Update Article responses.
 *
 * The Meta object is returned as part of Create Article and Update Article
 * responses and contains information about rate limiting and request quotas.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/meta
 */
final class Meta
{
    /**
     * Create a new Meta instance.
     *
     * @param Throttling|null $throttling Throttling information for rate limit management.
     */
    public function __construct(
        public readonly ?Throttling $throttling = null,
    ) {
    }

    /**
     * Create a Meta instance from API response data.
     *
     * @param array<string, mixed> $data The meta data from the API response.
     *
     * @return self A new Meta instance populated with the response data.
     */
    public static function fromArray(array $data): self
    {
        $throttling = null;
        if (isset($data['throttling']) && is_array($data['throttling'])) {
            $throttling = Throttling::fromArray($data['throttling']);
        }

        return new self(throttling: $throttling);
    }
}

