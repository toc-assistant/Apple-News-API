<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for table cell styles.
 *
 * Allows table cell appearance to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaltablecellstyle
 */
final class ConditionalTableCellStyle implements ConditionalInterface
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
     * The text color.
     */
    private ?string $textColor = null;

    /**
     * The horizontal alignment.
     */
    private ?string $horizontalAlignment = null;

    /**
     * The vertical alignment.
     */
    private ?string $verticalAlignment = null;

    /**
     * The padding.
     *
     * @var int|array<string, mixed>|null
     */
    private int|array|null $padding = null;

    /**
     * The minimum width.
     */
    private ?int $minimumWidth = null;

    /**
     * The cell width.
     */
    private ?int $width = null;

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
     * Set the text color.
     *
     * @param string $color The color in hex format.
     *
     * @return $this
     */
    public function setTextColor(string $color): self
    {
        $this->textColor = $color;
        return $this;
    }

    /**
     * Set the horizontal alignment.
     *
     * @param string $alignment One of 'left', 'center', 'right'.
     *
     * @return $this
     */
    public function setHorizontalAlignment(string $alignment): self
    {
        $this->horizontalAlignment = $alignment;
        return $this;
    }

    /**
     * Set the vertical alignment.
     *
     * @param string $alignment One of 'top', 'center', 'bottom'.
     *
     * @return $this
     */
    public function setVerticalAlignment(string $alignment): self
    {
        $this->verticalAlignment = $alignment;
        return $this;
    }

    /**
     * Set the padding.
     *
     * @param int|array<string, mixed> $padding The padding.
     *
     * @return $this
     */
    public function setPadding(int|array $padding): self
    {
        $this->padding = $padding;
        return $this;
    }

    /**
     * Set the minimum width.
     *
     * @param int $width The minimum width in points.
     *
     * @return $this
     */
    public function setMinimumWidth(int $width): self
    {
        $this->minimumWidth = $width;
        return $this;
    }

    /**
     * Set the cell width.
     *
     * @param int $width The width in points.
     *
     * @return $this
     */
    public function setWidth(int $width): self
    {
        $this->width = $width;
        return $this;
    }

    /**
     * Create a dark mode cell style.
     *
     * @param string      $backgroundColor The dark mode background.
     * @param string|null $textColor       Optional dark mode text color.
     *
     * @return self A new instance.
     */
    public static function darkMode(string $backgroundColor, ?string $textColor = null): self
    {
        $style = (new self())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor($backgroundColor);

        if ($textColor !== null) {
            $style->setTextColor($textColor);
        }

        return $style;
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

        if ($this->textColor !== null) {
            $data['textColor'] = $this->textColor;
        }

        if ($this->horizontalAlignment !== null) {
            $data['horizontalAlignment'] = $this->horizontalAlignment;
        }

        if ($this->verticalAlignment !== null) {
            $data['verticalAlignment'] = $this->verticalAlignment;
        }

        if ($this->padding !== null) {
            $data['padding'] = $this->padding;
        }

        if ($this->minimumWidth !== null) {
            $data['minimumWidth'] = $this->minimumWidth;
        }

        if ($this->width !== null) {
            $data['width'] = $this->width;
        }

        return $data;
    }
}

