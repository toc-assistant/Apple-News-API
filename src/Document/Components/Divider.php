<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * A visual separator line used between other components.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/divider
 */
final class Divider extends Component
{
    private ?array $stroke = null;

    public function getRole(): string
    {
        return 'divider';
    }

    /**
     * Define the style of the line (color, width).
     * @param array<string, mixed> $stroke
     * @return self
     */
    public function setStroke(array $stroke): self
    {
        $this->stroke = $stroke;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();

        if ($this->stroke !== null) {
            $data['stroke'] = $this->stroke;
        }

        return $data;
    }
}
