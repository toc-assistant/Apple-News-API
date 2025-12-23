<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Response;

use DateTimeImmutable;
use TomGould\AppleNews\Enum\ArticleState;

/**
 * Complete response from Create, Read, and Update Article endpoints.
 *
 * This class provides a typed representation of the article data returned
 * by the Apple News API, including metadata, state information, throttling
 * data, and any warnings generated during processing.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/articleresponse
 */
final class ArticleResponse
{
    /**
     * Create a new ArticleResponse instance.
     *
     * @param string                 $id                      The unique identifier for the article.
     * @param string                 $type                    The resource type (always "article").
     * @param string                 $title                   The article title from the Apple News Format document.
     * @param string                 $revision                The current revision token for optimistic locking.
     * @param ArticleState|null      $state                   The current processing state of the article.
     * @param string|null            $shareUrl                The public URL to the article in Apple News.
     * @param DateTimeImmutable|null $createdAt               When the article was first created.
     * @param DateTimeImmutable|null $modifiedAt              When the article was last modified.
     * @param bool|null              $isSponsored             Whether the article is marked as sponsored content.
     * @param bool|null              $isPreview               Whether the article is in preview mode.
     * @param bool|null              $isCandidateToBeFeatured Whether the article can be featured in Apple News.
     * @param bool|null              $isHidden                Whether the article is hidden from feeds.
     * @param string|null            $maturityRating          Content maturity rating (KIDS, GENERAL, MATURE).
     * @param ArticleLinks|null      $links                   Related API resource URLs.
     * @param Meta|null              $meta                    Metadata including throttling information.
     * @param list<Warning>          $warnings                Non-fatal warnings from the API.
     * @param array<string, mixed>   $rawData                 Raw response data for unmapped fields.
     */
    public function __construct(
        public readonly string $id,
        public readonly string $type,
        public readonly string $title,
        public readonly string $revision,
        public readonly ?ArticleState $state = null,
        public readonly ?string $shareUrl = null,
        public readonly ?DateTimeImmutable $createdAt = null,
        public readonly ?DateTimeImmutable $modifiedAt = null,
        public readonly ?bool $isSponsored = null,
        public readonly ?bool $isPreview = null,
        public readonly ?bool $isCandidateToBeFeatured = null,
        public readonly ?bool $isHidden = null,
        public readonly ?string $maturityRating = null,
        public readonly ?ArticleLinks $links = null,
        public readonly ?Meta $meta = null,
        public readonly array $warnings = [],
        /** @var array<string, mixed> Raw response data for any fields not explicitly mapped */
        public readonly array $rawData = [],
    ) {
    }

    /**
     * Create an ArticleResponse instance from the raw API response.
     *
     * This factory method handles the nested structure of the API response,
     * extracting data from the 'data', 'links', and 'meta' keys as appropriate.
     *
     * @param array<string, mixed> $response The full API response array.
     *
     * @return self A new ArticleResponse instance populated with the response data.
     */
    public static function fromApiResponse(array $response): self
    {
        $data = $response['data'] ?? $response;
        
        $state = null;
        if (isset($data['state'])) {
            $state = ArticleState::tryFrom($data['state']);
        }

        $links = null;
        if (isset($response['links']) && is_array($response['links'])) {
            $links = ArticleLinks::fromArray($response['links']);
        }

        $meta = null;
        if (isset($response['meta']) && is_array($response['meta'])) {
            $meta = Meta::fromArray($response['meta']);
        }

        $warnings = [];
        if (isset($data['warnings']) && is_array($data['warnings'])) {
            $warnings = Warning::fromArrayList($data['warnings']);
        }

        return new self(
            id: $data['id'] ?? '',
            type: $data['type'] ?? 'article',
            title: $data['title'] ?? '',
            revision: $data['revision'] ?? '',
            state: $state,
            shareUrl: $data['shareUrl'] ?? null,
            createdAt: isset($data['createdAt']) ? new DateTimeImmutable($data['createdAt']) : null,
            modifiedAt: isset($data['modifiedAt']) ? new DateTimeImmutable($data['modifiedAt']) : null,
            isSponsored: $data['isSponsored'] ?? null,
            isPreview: $data['isPreview'] ?? null,
            isCandidateToBeFeatured: $data['isCandidateToBeFeatured'] ?? null,
            isHidden: $data['isHidden'] ?? null,
            maturityRating: $data['maturityRating'] ?? null,
            links: $links,
            meta: $meta,
            warnings: $warnings,
            rawData: $data,
        );
    }

    /**
     * Get throttling information from the response.
     *
     * Convenience method to access throttling data without navigating
     * through the meta object.
     *
     * @return Throttling|null The throttling information, or null if not available.
     */
    public function getThrottling(): ?Throttling
    {
        return $this->meta?->throttling;
    }

    /**
     * Check if the response contains any warnings.
     *
     * @return bool True if there are one or more warnings.
     */
    public function hasWarnings(): bool
    {
        return count($this->warnings) > 0;
    }
}

