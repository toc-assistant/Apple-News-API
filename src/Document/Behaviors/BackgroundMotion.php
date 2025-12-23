<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

/**
 * BackgroundMotion behavior for background motion effects.
 *
 * The background_motion behavior applies motion effects to the background
 * of a component, creating depth as the user tilts their device.
 *
 * @see https://developer.apple.com/documentation/apple_news/backgroundmotion
 */
final class BackgroundMotion implements BehaviorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'background_motion';
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

