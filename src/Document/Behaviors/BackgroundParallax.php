<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

/**
 * BackgroundParallax behavior for scroll-based background parallax.
 *
 * The background_parallax behavior applies a parallax effect to the
 * background of a component as the user scrolls, creating depth.
 *
 * @see https://developer.apple.com/documentation/apple_news/backgroundparallax
 */
final class BackgroundParallax implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'background_parallax';
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

