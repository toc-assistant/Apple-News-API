<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for component styles.
 *
 * Allows style properties like backgroundColor, border, and opacity
 * to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalcomponentstyle
 */
final class ConditionalComponentStyle implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * The background color.
     */
    private ?string $backgroundColor = null;

    /**
     * The fill configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $fill = null;

    /**
     * The border configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $border = null;

    /**
     * The shadow configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $shadow = null;

    /**
     * The opacity (0.0 to 1.0).
     */
    private ?float $opacity = null;

    /**
     * The mask configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $mask = null;

    /**
     * Add a condition.
     *
     * @param Condition $condition The condition to add.
     *
     * @return $this
     */
    public function addCondition(Condition $condition): self
    {
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Set the background color.
     *
     * @param string $color The color in hex format.
     *
     * @return $this
     */
    public function setBackgroundColor(string $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * Set the fill configuration.
     *
     * @param array<string, mixed> $fill The fill configuration.
     *
     * @return $this
     */
    public function setFill(array $fill): self
    {
        $this->fill = $fill;
        return $this;
    }

    /**
     * Set the border configuration.
     *
     * @param array<string, mixed> $border The border configuration.
     *
     * @return $this
     */
    public function setBorder(array $border): self
    {
        $this->border = $border;
        return $this;
    }

    /**
     * Set the shadow configuration.
     *
     * @param array<string, mixed> $shadow The shadow configuration.
     *
     * @return $this
     */
    public function setShadow(array $shadow): self
    {
        $this->shadow = $shadow;
        return $this;
    }

    /**
     * Set the opacity.
     *
     * @param float $opacity Opacity from 0.0 to 1.0.
     *
     * @return $this
     */
    public function setOpacity(float $opacity): self
    {
        $this->opacity = max(0.0, min(1.0, $opacity));
        return $this;
    }

    /**
     * Set the mask configuration.
     *
     * @param array<string, mixed> $mask The mask configuration.
     *
     * @return $this
     */
    public function setMask(array $mask): self
    {
        $this->mask = $mask;
        return $this;
    }

    /**
     * Create a dark mode style.
     *
     * @param string $backgroundColor The dark mode background color.
     *
     * @return self A new instance.
     */
    public static function darkMode(string $backgroundColor): self
    {
        return (new self())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor($backgroundColor);
    }

    /**
     * Create a light mode style.
     *
     * @param string $backgroundColor The light mode background color.
     *
     * @return self A new instance.
     */
    public static function lightMode(string $backgroundColor): self
    {
        return (new self())
            ->addCondition(Condition::lightMode())
            ->setBackgroundColor($backgroundColor);
    }

    /**
     * {@inheritdoc}
     */
    public function hasConditions(): bool
    {
        return !empty($this->conditions);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if (!empty($this->conditions)) {
            $data['conditions'] = array_map(
                fn(Condition $c) => $c->jsonSerialize(),
                $this->conditions
            );
        }

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        if ($this->fill !== null) {
            $data['fill'] = $this->fill;
        }

        if ($this->border !== null) {
            $data['border'] = $this->border;
        }

        if ($this->shadow !== null) {
            $data['shadow'] = $this->shadow;
        }

        if ($this->opacity !== null) {
            $data['opacity'] = $this->opacity;
        }

        if ($this->mask !== null) {
            $data['mask'] = $this->mask;
        }

        return $data;
    }
}

