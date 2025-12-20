<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for embedding X/Twitter posts.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/tweet
 */
final class Tweet extends Component
{
    /**
     * @param string $url The direct URL to the Tweet.
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'tweet';
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
