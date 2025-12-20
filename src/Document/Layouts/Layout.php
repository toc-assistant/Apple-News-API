<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

use JsonSerializable;

/**
 * Defines the column system and base grid for an article.
 *
 * Every Apple News article requires a layout object to determine how components
 * are positioned relative to the grid columns.
 *
 * @see https://developer.apple.com/documentation/apple_news/layout
 */
final class Layout implements JsonSerializable
{
    /** @var int|null Space outside the content area. */
    private ?int $margin = null;

    /** @var int|null Space between columns. */
    private ?int $gutter = null;

    /**
     * @param int $columns Total number of columns in the grid.
     * @param int $width Total width of the article in points.
     */
    public function __construct(
        private readonly int $columns,
        private readonly int $width
    ) {
    }

    /**
     * Set the horizontal margin for the article content.
     * @param int $margin
     * @return self
     */
    public function setMargin(int $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * Set the space (gutter) between columns.
     * @param int $gutter
     * @return self
     */
    public function setGutter(int $gutter): self
    {
        $this->gutter = $gutter;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [
            'columns' => $this->columns,
            'width' => $this->width,
        ];

        if ($this->margin !== null) {
            $data['margin'] = $this->margin;
        }

        if ($this->gutter !== null) {
            $data['gutter'] = $this->gutter;
        }

        return $data;
    }
}

