<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for table row styles.
 *
 * Allows table row appearance to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaltablerowstyle
 */
final class ConditionalTableRowStyle implements ConditionalInterface
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
     * The row height.
     */
    private ?int $height = null;

    /**
     * The divider configuration.
     *
     * @var array<string, mixed>|null
     */
    private ?array $divider = null;

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
     * Set the row height.
     *
     * @param int $height The height in points.
     *
     * @return $this
     */
    public function setHeight(int $height): self
    {
        $this->height = $height;
        return $this;
    }

    /**
     * Set the divider configuration.
     *
     * @param array<string, mixed> $divider The divider configuration.
     *
     * @return $this
     */
    public function setDivider(array $divider): self
    {
        $this->divider = $divider;
        return $this;
    }

    /**
     * Create a dark mode row style.
     *
     * @param string $backgroundColor The dark mode background.
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

        if ($this->height !== null) {
            $data['height'] = $this->height;
        }

        if ($this->divider !== null) {
            $data['divider'] = $this->divider;
        }

        return $data;
    }
}

