<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

/**
 * Conditional properties for section components.
 *
 * Extends ConditionalContainer with section-specific properties
 * like scene.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalsection
 */
final class ConditionalSection extends ConditionalComponent
{
    /**
     * The content display configuration.
     *
     * @var string|array<string, mixed>|null
     */
    private string|array|null $contentDisplay = null;

    /**
     * The scene configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $scene = null;

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
     * Set the scene.
     *
     * @param array<string, mixed> $scene The scene configuration.
     *
     * @return $this
     */
    public function setScene(array $scene): self
    {
        $this->scene = $scene;
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

        if ($this->scene !== null) {
            $data['scene'] = $this->scene;
        }

        return $data;
    }
}

