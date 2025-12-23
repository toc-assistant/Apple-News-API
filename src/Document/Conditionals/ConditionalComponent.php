<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for any component.
 *
 * Allows component properties like hidden, anchor, layout, and style
 * to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalcomponent
 */
class ConditionalComponent implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    protected array $conditions = [];

    /**
     * Whether the component is hidden.
     */
    protected ?bool $hidden = null;

    /**
     * The anchor configuration.
     */
    protected ?string $anchor = null;

    /**
     * The layout reference.
     */
    protected ?string $layout = null;

    /**
     * The style reference.
     */
    protected ?string $style = null;

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
     * Set multiple conditions.
     *
     * @param list<Condition> $conditions The conditions.
     *
     * @return $this
     */
    public function setConditions(array $conditions): self
    {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * Set whether the component is hidden.
     *
     * @param bool $hidden Whether hidden.
     *
     * @return $this
     */
    public function setHidden(bool $hidden): self
    {
        $this->hidden = $hidden;
        return $this;
    }

    /**
     * Set the anchor.
     *
     * @param string $anchor The anchor reference.
     *
     * @return $this
     */
    public function setAnchor(string $anchor): self
    {
        $this->anchor = $anchor;
        return $this;
    }

    /**
     * Set the layout reference.
     *
     * @param string $layout The layout name.
     *
     * @return $this
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Set the style reference.
     *
     * @param string $style The style name.
     *
     * @return $this
     */
    public function setStyle(string $style): self
    {
        $this->style = $style;
        return $this;
    }

    /**
     * Create a conditional that hides on compact width.
     *
     * @return self A new instance.
     */
    public static function hiddenOnCompact(): self
    {
        return (new self())
            ->addCondition(Condition::compactWidth())
            ->setHidden(true);
    }

    /**
     * Create a conditional that shows only on regular width.
     *
     * @return self A new instance.
     */
    public static function visibleOnRegular(): self
    {
        return (new self())
            ->addCondition(Condition::regularWidth())
            ->setHidden(false);
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

        if ($this->hidden !== null) {
            $data['hidden'] = $this->hidden;
        }

        if ($this->anchor !== null) {
            $data['anchor'] = $this->anchor;
        }

        if ($this->layout !== null) {
            $data['layout'] = $this->layout;
        }

        if ($this->style !== null) {
            $data['style'] = $this->style;
        }

        return $data;
    }
}

