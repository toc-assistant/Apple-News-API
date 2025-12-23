<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

/**
 * Horizontal stack display for arranging components horizontally.
 *
 * The horizontal_stack display arranges child components in a horizontal
 * row, typically used for side-by-side layouts.
 *
 * @see https://developer.apple.com/documentation/apple_news/horizontalstackdisplay
 */
final class HorizontalStackDisplay implements ContentDisplayInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'horizontal_stack';
    }

    /**
     * {@inheritdoc}
     *
     * @return array{type: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}

