<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Styles;

use JsonSerializable;

/**
 * Global styles applied to the entire article document.
 *
 * @see https://developer.apple.com/documentation/apple_news/documentstyle
 */
final class DocumentStyle implements JsonSerializable
{
    private ?string $backgroundColor = null;

    /**
     * Set the global background color of the article.
     * @param string $color Hex code or named color.
     * @return self
     */
    public function setBackgroundColor(string $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        return $data;
    }
}

