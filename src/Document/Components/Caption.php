<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * A standard text component for captions.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/caption
 */
final class Caption extends TextComponent
{
    public function getRole(): string
    {
        return 'caption';
    }
}
