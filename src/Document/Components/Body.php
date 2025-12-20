<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * The standard text component for body paragraphs.
 *
 * @see https://developer.apple.com/documentation/apple_news/body
 */
final class Body extends TextComponent
{
    public function getRole(): string
    {
        return 'body';
    }
}

