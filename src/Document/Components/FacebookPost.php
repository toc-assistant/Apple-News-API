<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for embedding Facebook posts.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/facebookpost
 */
final class FacebookPost extends Component
{
    /**
     * @param string $url The URL of the Facebook post.
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'facebook_post';
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
