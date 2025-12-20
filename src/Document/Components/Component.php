<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

use JsonSerializable;

/**
 * Base class for all Apple News Format (ANF) components.
 *
 * All content in an Apple News article is built using components. This base
 * class provides common properties like layouts, styles, and behaviors.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/component
 */
abstract class Component implements JsonSerializable
{
    /** @var string|null A unique identifier for this component instance. */
    protected ?string $identifier = null;

    /** @var string|null Reference to a named layout defined in Article. */
    protected ?string $layout = null;

    /** @var string|null Reference to a named style defined in Article. */
    protected ?string $style = null;

    /** @var string|null Anchor configuration for pinning components. */
    protected ?string $anchor = null;

    /** @var array<string, mixed>|null Animation settings for the component. */
    protected ?array $animation = null;

    /** @var array<string, mixed>|null Behavior settings (e.g., Parallax). */
    protected ?array $behavior = null;

    /** @var bool Whether the component is hidden by default. */
    protected bool $hidden = false;

    /** @var array<string, mixed>|null Conditional properties based on orientation/device. */
    protected ?array $conditional = null;

    /**
     * Get the role name for the component (e.g., 'body', 'photo', 'heading1').
     * @return string
     */
    abstract public function getRole(): string;

    /**
     * Set a unique identifier for this component.
     * @param string $identifier
     * @return static
     */
    public function setIdentifier(string $identifier): static
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Set the layout name or inline layout.
     * @param string $layout Reference to a name in componentLayouts.
     * @return static
     */
    public function setLayout(string $layout): static
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Set the style name.
     * @param string $style Reference to a name in componentStyles.
     * @return static
     */
    public function setStyle(string $style): static
    {
        $this->style = $style;
        return $this;
    }

    /**
     * Set the anchor configuration.
     * @param string $anchor
     * @return static
     */
    public function setAnchor(string $anchor): static
    {
        $this->anchor = $anchor;
        return $this;
    }

    /**
     * Set component animation.
     *
     * @param array<string, mixed> $animation Animation properties.
     * @return static
     * @see https://developer.apple.com/documentation/applenewsformat/fadeinanimation
     */
    public function setAnimation(array $animation): static
    {
        $this->animation = $animation;
        return $this;
    }

    /**
     * Set component behavior.
     *
     * @param array<string, mixed> $behavior Behavior properties (e.g., parallax).
     * @return static
     * @see https://developer.apple.com/documentation/applenewsformat/parallax
     */
    public function setBehavior(array $behavior): static
    {
        $this->behavior = $behavior;
        return $this;
    }

    /**
     * Set whether the component is hidden.
     * @param bool $hidden
     * @return static
     */
    public function setHidden(bool $hidden): static
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Set conditional properties for the component.
     *
     * @param array<string, mixed> $conditional Array of conditions.
     * @return static
     * @see https://developer.apple.com/documentation/applenewsformat/condition
     */
    public function setConditional(array $conditional): static
    {
        $this->conditional = $conditional;
        return $this;
    }

    /**
     * Get the base properties common to all components for JSON serialization.
     *
     * @return array<string, mixed>
     */
    protected function getBaseProperties(): array
    {
        $data = ['role' => $this->getRole()];

        if ($this->identifier !== null) {
            $data['identifier'] = $this->identifier;
        }

        if ($this->layout !== null) {
            $data['layout'] = $this->layout;
        }

        if ($this->style !== null) {
            $data['style'] = $this->style;
        }

        if ($this->anchor !== null) {
            $data['anchor'] = $this->anchor;
        }

        if ($this->animation !== null) {
            $data['animation'] = $this->animation;
        }

        if ($this->behavior !== null) {
            $data['behavior'] = $this->behavior;
        }

        if ($this->hidden) {
            $data['hidden'] = true;
        }

        if ($this->conditional !== null) {
            $data['conditional'] = $this->conditional;
        }

        return $data;
    }

    /**
     * Implementation of JsonSerializable.
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->getBaseProperties();
    }
}
