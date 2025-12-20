<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for highlighting a quote within an article.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/pullquote
 */
final class Pullquote extends TextComponent
{
    public function getRole(): string
    {
        return 'pullquote';
    }
}
