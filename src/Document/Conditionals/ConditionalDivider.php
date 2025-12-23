<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

/**
 * Conditional properties for divider components.
 *
 * Allows divider-specific properties like stroke to change
 * based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaldivider
 */
final class ConditionalDivider extends ConditionalComponent
{
    /**
     * The stroke style configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $stroke = null;

    /**
     * Set the stroke style.
     *
     * @param array<string, mixed> $stroke The stroke configuration.
     *
     * @return $this
     */
    public function setStroke(array $stroke): self
    {
        $this->stroke = $stroke;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        if ($this->stroke !== null) {
            $data['stroke'] = $this->stroke;
        }

        return $data;
    }
}

