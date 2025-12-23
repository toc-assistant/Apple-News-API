<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

/**
 * Motion behavior for device motion-based parallax.
 *
 * The motion behavior creates a parallax effect based on device motion,
 * making components appear to float in 3D space as the user tilts their device.
 * This is similar to the iOS home screen parallax effect.
 *
 * @see https://developer.apple.com/documentation/apple_news/motion
 */
final class Motion implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'motion';
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

