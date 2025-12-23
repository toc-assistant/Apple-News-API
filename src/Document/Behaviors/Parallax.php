<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

/**
 * Parallax behavior for scroll-based parallax effects.
 *
 * The parallax behavior makes a component move at a different rate than
 * the scroll speed, creating a depth effect. The factor determines how
 * much slower (< 1) or faster (> 1) the component moves relative to scroll.
 *
 * @see https://developer.apple.com/documentation/apple_news/parallax
 */
final class Parallax implements BehaviorInterface
{
    /**
     * Create a new Parallax behavior.
     *
     * @param float $factor The parallax factor. Values less than 1.0 make the component
     *                      scroll slower than the content (appearing further away).
     *                      Typical values range from 0.5 to 0.9.
     */
    public function __construct(
        private readonly float $factor = 0.9
    ) {
    }

    /**
     * Create a Parallax with a specific factor.
     *
     * @param float $factor The parallax factor (0.0 to 2.0 typical range).
     *
     * @return self A new Parallax instance.
     */
    public static function withFactor(float $factor): self
    {
        return new self($factor);
    }

    /**
     * Create a subtle parallax effect.
     *
     * @return self A Parallax with factor 0.9.
     */
    public static function subtle(): self
    {
        return new self(0.9);
    }

    /**
     * Create a moderate parallax effect.
     *
     * @return self A Parallax with factor 0.7.
     */
    public static function moderate(): self
    {
        return new self(0.7);
    }

    /**
     * Create a strong parallax effect.
     *
     * @return self A Parallax with factor 0.5.
     */
    public static function strong(): self
    {
        return new self(0.5);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'parallax';
    }

    /**
     * Get the parallax factor.
     *
     * @return float The factor value.
     */
    public function getFactor(): float
    {
        return $this->factor;
    }

    /**
     * {@inheritdoc}
     *
     * @return array{type: string, factor: float}
     */
    public function jsonSerialize(): array
    {
        return [
            'type' => $this->getType(),
            'factor' => $this->factor,
        ];
    }
}

