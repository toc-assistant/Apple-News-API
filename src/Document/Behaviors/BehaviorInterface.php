<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Behaviors;

use JsonSerializable;

/**
 * Interface for all ANF component behaviors.
 *
 * Behaviors control how components respond to user interaction,
 * device motion, and scrolling.
 *
 * @see https://developer.apple.com/documentation/apple_news/behavior
 */
interface BehaviorInterface extends JsonSerializable
{
    /**
     * Get the behavior type identifier.
     *
     * @return string The behavior type (e.g., 'parallax', 'springy').
     */
    public function getType(): string;
}

