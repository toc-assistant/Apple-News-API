<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

use TomGould\AppleNews\Document\Layouts\ContentDisplayInterface;

/**
 * A container component used to group other components together.
 *
 * Containers are useful for applying shared layouts, backgrounds, or behaviors
 * to a set of child components.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/container
 */
class Container extends Component
{
    /** @var array<Component> Child components. */
    protected array $components = [];

    /** @var string|array<string, mixed>|null Layout mode for child components. */
    protected string|array|null $contentDisplay = null;

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
     * Set the content display mode using a string or array.
     *
     * @param string|array<string, mixed> $contentDisplay The display mode or configuration.
     *
     * @return $this
     */
    public function setContentDisplay(string|array $contentDisplay): self
    {
        $this->contentDisplay = $contentDisplay;
        return $this;
    }

    /**
     * Set the content display mode using a typed ContentDisplay object.
     *
     * This method provides type-safe content display configuration:
     * ```php
     * $container->setContentDisplayObject(new HorizontalStackDisplay());
     * $container->setContentDisplayObject(CollectionDisplay::grid(20, 20));
     * ```
     *
     * @param ContentDisplayInterface $contentDisplay The content display object.
     *
     * @return $this
     */
    public function setContentDisplayObject(ContentDisplayInterface $contentDisplay): self
    {
        $this->contentDisplay = $contentDisplay->jsonSerialize();
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
