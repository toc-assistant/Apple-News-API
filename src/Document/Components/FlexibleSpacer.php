<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Flexible spacer component for dynamic spacing in horizontal stacks.
 *
 * The flexible_spacer component expands to fill available space in a
 * horizontal stack layout, pushing other components apart.
 *
 * @see https://developer.apple.com/documentation/apple_news/flexiblespacer
 */
final class FlexibleSpacer extends Component
{
    /**
     * {@inheritdoc}
     */
    public function getRole(): string
    {
        return 'flexible_spacer';
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->getBaseProperties();
    }
}

