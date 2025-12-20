<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for embedding Instagram posts.
 *
 * @see https://developer.apple.com/documentation/apple_news/instagram
 */
final class Instagram extends Component
{
    /**
     * @param string $url The direct URL to the Instagram post.
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'instagram';
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();
        $data['URL'] = $this->url;
        return $data;
    }
}

