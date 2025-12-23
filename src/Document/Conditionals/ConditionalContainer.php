<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

/**
 * Conditional properties for container components.
 *
 * Extends ConditionalComponent with container-specific properties
 * like contentDisplay.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalcontainer
 */
final class ConditionalContainer extends ConditionalComponent
{
    /**
     * The content display configuration.
     *
     * @var string|array<string, mixed>|null
     */
    private string|array|null $contentDisplay = null;

    /**
     * Set the content display.
     *
     * @param string|array<string, mixed> $contentDisplay The display mode.
     *
     * @return $this
     */
    public function setContentDisplay(string|array $contentDisplay): self
    {
        $this->contentDisplay = $contentDisplay;
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

        if ($this->contentDisplay !== null) {
            $data['contentDisplay'] = $this->contentDisplay;
        }

        return $data;
    }
}

