<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use JsonSerializable;

/**
 * Interface for all conditional objects.
 *
 * Conditional objects allow properties to change based on device
 * characteristics, user preferences, or viewing context.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalcomponent
 */
interface ConditionalInterface extends JsonSerializable
{
    /**
     * Check if any conditions have been set.
     *
     * @return bool True if conditions exist.
     */
    public function hasConditions(): bool;
}

