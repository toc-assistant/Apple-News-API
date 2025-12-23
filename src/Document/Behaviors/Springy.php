<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

/**
 * Springy behavior for device tilt-based movement.
 *
 * The springy behavior makes a component respond to device tilt with a
 * spring-like motion, creating a subtle 3D effect as the user moves
 * their device.
 *
 * @see https://developer.apple.com/documentation/apple_news/springy
 */
final class Springy implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'springy';
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

