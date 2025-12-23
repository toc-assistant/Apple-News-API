<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Response;

/**
 * Throttling information returned by Create and Update Article endpoints.
 *
 * This object provides rate limit information to help you implement smart
 * request scheduling and avoid hitting API rate limits. It is included in
 * the Meta object of Create and Update Article responses.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/throttling
 */
final class Throttling
{
    /**
     * Create a new Throttling instance.
     *
     * @param int|null $estimatedDelayInSeconds Estimated delay in seconds before the next request can be processed.
     * @param int|null $queueSize               Number of requests currently queued for processing.
     * @param int|null $quotaAvailable          Number of requests remaining in the current quota period.
     */
    public function __construct(
        public readonly ?int $estimatedDelayInSeconds = null,
        public readonly ?int $queueSize = null,
        public readonly ?int $quotaAvailable = null,
    ) {
    }

    /**
     * Create a Throttling instance from API response data.
     *
     * @param array<string, mixed> $data The throttling data from the API response.
     *
     * @return self A new Throttling instance populated with the response data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            estimatedDelayInSeconds: isset($data['estimatedDelayInSeconds']) ? (int) $data['estimatedDelayInSeconds'] : null,
            queueSize: isset($data['queueSize']) ? (int) $data['queueSize'] : null,
            quotaAvailable: isset($data['quotaAvailable']) ? (int) $data['quotaAvailable'] : null,
        );
    }

    /**
     * Check if we should delay before making another request.
     *
     * Returns true if estimatedDelayInSeconds is set and greater than zero,
     * indicating that the API is requesting a delay before the next request.
     *
     * @return bool True if a delay is recommended before the next request.
     */
    public function shouldDelay(): bool
    {
        return $this->estimatedDelayInSeconds !== null && $this->estimatedDelayInSeconds > 0;
    }

    /**
     * Check if quota is exhausted or nearly exhausted.
     *
     * Use this to proactively pause requests before hitting rate limits.
     *
     * @param int $threshold The minimum quota level to consider "low". Defaults to 10.
     *
     * @return bool True if quotaAvailable is at or below the threshold.
     */
    public function isQuotaLow(int $threshold = 10): bool
    {
        return $this->quotaAvailable !== null && $this->quotaAvailable <= $threshold;
    }
}

