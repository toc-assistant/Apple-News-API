<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * A heading component (supports levels 1 through 6).
 *
 * @see https://developer.apple.com/documentation/apple_news/heading
 */
final class Heading extends TextComponent
{
    /**
     * @param string $text Heading text.
     * @param int $level Heading level (1-6).
     */
    public function __construct(
        string $text,
        private readonly int $level = 1
    ) {
        parent::__construct($text);
    }

    public function getRole(): string
    {
        if ($this->level === 1) {
            return 'heading1';
        }

        return 'heading' . min(max($this->level, 1), 6);
    }
}

