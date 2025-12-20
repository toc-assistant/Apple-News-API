<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * A container component used to group other components together.
 *
 * Containers are useful for applying shared layouts, backgrounds, or behaviors
 * to a set of child components.
 *
 * @see https://developer.apple.com/documentation/apple_news/container
 */
class Container extends Component
{
    /** @var array<Component> Child components. */
    protected array $components = [];

    /** @var string|null Layout mode for child components. */
    protected ?string $contentDisplay = null;

    public function getRole(): string
    {
        return 'container';
    }

    /**
     * Add a child component to this container.
     * @param Component $component
     * @return self
     */
    public function addComponent(Component $component): self
    {
        $this->components[] = $component;
        return $this;
    }

    /**
     * Set the content display mode (e.g., for horizontal scrolling).
     * @param string $contentDisplay
     * @return self
     */
    public function setContentDisplay(string $contentDisplay): self
    {
        $this->contentDisplay = $contentDisplay;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();

        if (!empty($this->components)) {
            $data['components'] = array_map(
                fn(Component $c) => $c->jsonSerialize(),
                $this->components
            );
        }

        if ($this->contentDisplay !== null) {
            $data['contentDisplay'] = $this->contentDisplay;
        }

        return $data;
    }
}

