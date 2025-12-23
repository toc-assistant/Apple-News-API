<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Response;

/**
 * Links associated with an article response.
 *
 * Contains URLs for related API resources such as the channel,
 * the article itself, and any sections the article belongs to.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/articlelinksresponse
 */
final class ArticleLinks
{
    /**
     * Create a new ArticleLinks instance.
     *
     * @param string|null  $channel  URL to the channel resource containing this article.
     * @param string|null  $self     URL to this article resource.
     * @param list<string> $sections URLs to section resources this article belongs to.
     */
    public function __construct(
        public readonly ?string $channel = null,
        public readonly ?string $self = null,
        /** @var list<string> */
        public readonly array $sections = [],
    ) {
    }

    /**
     * Create an ArticleLinks instance from API response data.
     *
     * @param array<string, mixed> $data The links data from the API response.
     *
     * @return self A new ArticleLinks instance populated with the response data.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            channel: $data['channel'] ?? null,
            self: $data['self'] ?? null,
            sections: $data['sections'] ?? [],
        );
    }
}

