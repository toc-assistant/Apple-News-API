<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * The main title component for an article.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/title
 */
final class Title extends TextComponent
{
    public function getRole(): string
    {
        return 'title';
    }
}
