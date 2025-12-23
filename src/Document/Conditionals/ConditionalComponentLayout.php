<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for component layouts.
 *
 * Allows layout properties like margin, padding, and column span
 * to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalcomponentlayout
 */
final class ConditionalComponentLayout implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * The column start position.
     */
    private ?int $columnStart = null;

    /**
     * The column span.
     */
    private ?int $columnSpan = null;

    /**
     * The margin configuration.
     *
     * @var int|array<string, mixed>|null
     */
    private int|array|null $margin = null;

    /**
     * The content inset.
     *
     * @var int|array<string, mixed>|null
     */
    private int|array|null $contentInset = null;

    /**
     * The padding.
     *
     * @var int|array<string, mixed>|null
     */
    private int|array|null $padding = null;

    /**
     * The minimum height.
     *
     * @var int|string|null
     */
    private int|string|null $minimumHeight = null;

    /**
     * The maximum width.
     *
     * @var int|string|null
     */
    private int|string|null $maximumWidth = null;

    /**
     * The minimum width.
     *
     * @var int|string|null
     */
    private int|string|null $minimumWidth = null;

    /**
     * The horizontal content alignment.
     */
    private ?string $horizontalContentAlignment = null;

    /**
     * Whether to ignore document margin.
     */
    private ?bool $ignoreDocumentMargin = null;

    /**
     * Whether to ignore document gutter.
     */
    private ?bool $ignoreDocumentGutter = null;

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
     * Set the column start.
     *
     * @param int $columnStart The starting column.
     *
     * @return $this
     */
    public function setColumnStart(int $columnStart): self
    {
        $this->columnStart = $columnStart;
        return $this;
    }

    /**
     * Set the column span.
     *
     * @param int $columnSpan Number of columns to span.
     *
     * @return $this
     */
    public function setColumnSpan(int $columnSpan): self
    {
        $this->columnSpan = $columnSpan;
        return $this;
    }

    /**
     * Set the margin.
     *
     * @param int|array<string, mixed> $margin The margin value or configuration.
     *
     * @return $this
     */
    public function setMargin(int|array $margin): self
    {
        $this->margin = $margin;
        return $this;
    }

    /**
     * Set the content inset.
     *
     * @param int|array<string, mixed> $inset The inset value or configuration.
     *
     * @return $this
     */
    public function setContentInset(int|array $inset): self
    {
        $this->contentInset = $inset;
        return $this;
    }

    /**
     * Set the padding.
     *
     * @param int|array<string, mixed> $padding The padding value or configuration.
     *
     * @return $this
     */
    public function setPadding(int|array $padding): self
    {
        $this->padding = $padding;
        return $this;
    }

    /**
     * Set the minimum height.
     *
     * @param int|string $height The minimum height.
     *
     * @return $this
     */
    public function setMinimumHeight(int|string $height): self
    {
        $this->minimumHeight = $height;
        return $this;
    }

    /**
     * Set the maximum width.
     *
     * @param int|string $width The maximum width.
     *
     * @return $this
     */
    public function setMaximumWidth(int|string $width): self
    {
        $this->maximumWidth = $width;
        return $this;
    }

    /**
     * Set the minimum width.
     *
     * @param int|string $width The minimum width.
     *
     * @return $this
     */
    public function setMinimumWidth(int|string $width): self
    {
        $this->minimumWidth = $width;
        return $this;
    }

    /**
     * Set the horizontal content alignment.
     *
     * @param string $alignment One of 'left', 'center', 'right'.
     *
     * @return $this
     */
    public function setHorizontalContentAlignment(string $alignment): self
    {
        $this->horizontalContentAlignment = $alignment;
        return $this;
    }

    /**
     * Set whether to ignore document margin.
     *
     * @param bool $ignore Whether to ignore.
     *
     * @return $this
     */
    public function setIgnoreDocumentMargin(bool $ignore): self
    {
        $this->ignoreDocumentMargin = $ignore;
        return $this;
    }

    /**
     * Set whether to ignore document gutter.
     *
     * @param bool $ignore Whether to ignore.
     *
     * @return $this
     */
    public function setIgnoreDocumentGutter(bool $ignore): self
    {
        $this->ignoreDocumentGutter = $ignore;
        return $this;
    }

    /**
     * Create a full-width layout for compact devices.
     *
     * @return self A new instance.
     */
    public static function fullWidthOnCompact(): self
    {
        return (new self())
            ->addCondition(Condition::compactWidth())
            ->setIgnoreDocumentMargin(true)
            ->setIgnoreDocumentGutter(true);
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

        if ($this->columnStart !== null) {
            $data['columnStart'] = $this->columnStart;
        }

        if ($this->columnSpan !== null) {
            $data['columnSpan'] = $this->columnSpan;
        }

        if ($this->margin !== null) {
            $data['margin'] = $this->margin;
        }

        if ($this->contentInset !== null) {
            $data['contentInset'] = $this->contentInset;
        }

        if ($this->padding !== null) {
            $data['padding'] = $this->padding;
        }

        if ($this->minimumHeight !== null) {
            $data['minimumHeight'] = $this->minimumHeight;
        }

        if ($this->maximumWidth !== null) {
            $data['maximumWidth'] = $this->maximumWidth;
        }

        if ($this->minimumWidth !== null) {
            $data['minimumWidth'] = $this->minimumWidth;
        }

        if ($this->horizontalContentAlignment !== null) {
            $data['horizontalContentAlignment'] = $this->horizontalContentAlignment;
        }

        if ($this->ignoreDocumentMargin !== null) {
            $data['ignoreDocumentMargin'] = $this->ignoreDocumentMargin;
        }

        if ($this->ignoreDocumentGutter !== null) {
            $data['ignoreDocumentGutter'] = $this->ignoreDocumentGutter;
        }

        return $data;
    }
}

