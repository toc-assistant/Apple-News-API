<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

use JsonSerializable;

/**
 * Interface for all ANF content display types.
 *
 * Content displays control how child components are arranged within
 * container components like Section, Chapter, and Container.
 *
 * @see https://developer.apple.com/documentation/apple_news/collectiondisplay
 * @see https://developer.apple.com/documentation/apple_news/horizontalstackdisplay
 */
interface ContentDisplayInterface extends JsonSerializable
{
    /**
     * Get the content display type identifier.
     *
     * @return string The display type (e.g., 'horizontal_stack', 'collection').
     */
    public function getType(): string;
}

