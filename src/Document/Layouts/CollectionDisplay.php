<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

/**
 * Collection display for grid-like component arrangements.
 *
 * The collection display arranges child components in a flexible grid,
 * with control over alignment, distribution, and spacing.
 *
 * @see https://developer.apple.com/documentation/apple_news/collectiondisplay
 */
final class CollectionDisplay implements ContentDisplayInterface
{
    /**
     * Valid alignment values.
     */
    public const ALIGN_LEFT = 'left';
    public const ALIGN_CENTER = 'center';
    public const ALIGN_RIGHT = 'right';

    /**
     * Valid distribution values.
     */
    public const DISTRIBUTE_WIDE = 'wide';
    public const DISTRIBUTE_NARROW = 'narrow';

    /**
     * Horizontal alignment of components.
     */
    private ?string $alignment = null;

    /**
     * Distribution of components across columns.
     */
    private ?string $distribution = null;

    /**
     * Spacing between rows in points.
     */
    private ?int $rowSpacing = null;

    /**
     * Spacing between columns in points.
     */
    private ?int $gutter = null;

    /**
     * Whether to vary column widths for visual interest.
     */
    private ?bool $variableSizing = null;

    /**
     * The width of each item as a column count.
     */
    private ?int $widths = null;

    /**
     * The minimum width of each item in points.
     */
    private ?int $minimumWidth = null;

    /**
     * The maximum width of each item in points.
     */
    private ?int $maximumWidth = null;

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'collection';
    }

    /**
     * Set the horizontal alignment.
     *
     * @param string $alignment One of 'left', 'center', 'right'.
     *
     * @return $this
     */
    public function setAlignment(string $alignment): self
    {
        $this->alignment = $alignment;
        return $this;
    }

    /**
     * Set the distribution.
     *
     * @param string $distribution One of 'wide', 'narrow'.
     *
     * @return $this
     */
    public function setDistribution(string $distribution): self
    {
        $this->distribution = $distribution;
        return $this;
    }

    /**
     * Set the row spacing in points.
     *
     * @param int $spacing Spacing between rows.
     *
     * @return $this
     */
    public function setRowSpacing(int $spacing): self
    {
        $this->rowSpacing = $spacing;
        return $this;
    }

    /**
     * Set the gutter (column spacing) in points.
     *
     * @param int $gutter Spacing between columns.
     *
     * @return $this
     */
    public function setGutter(int $gutter): self
    {
        $this->gutter = $gutter;
        return $this;
    }

    /**
     * Set whether to use variable sizing.
     *
     * @param bool $variable Whether to vary column widths.
     *
     * @return $this
     */
    public function setVariableSizing(bool $variable): self
    {
        $this->variableSizing = $variable;
        return $this;
    }

    /**
     * Set the item widths as column count.
     *
     * @param int $widths Number of columns each item spans.
     *
     * @return $this
     */
    public function setWidths(int $widths): self
    {
        $this->widths = $widths;
        return $this;
    }

    /**
     * Set the minimum item width in points.
     *
     * @param int $width Minimum width.
     *
     * @return $this
     */
    public function setMinimumWidth(int $width): self
    {
        $this->minimumWidth = $width;
        return $this;
    }

    /**
     * Set the maximum item width in points.
     *
     * @param int $width Maximum width.
     *
     * @return $this
     */
    public function setMaximumWidth(int $width): self
    {
        $this->maximumWidth = $width;
        return $this;
    }

    /**
     * Create a centered collection display.
     *
     * @return self A new CollectionDisplay instance.
     */
    public static function centered(): self
    {
        return (new self())->setAlignment(self::ALIGN_CENTER);
    }

    /**
     * Create a grid-like collection with specified spacing.
     *
     * @param int $gutter     Column spacing in points.
     * @param int $rowSpacing Row spacing in points.
     *
     * @return self A new CollectionDisplay instance.
     */
    public static function grid(int $gutter = 20, int $rowSpacing = 20): self
    {
        return (new self())
            ->setGutter($gutter)
            ->setRowSpacing($rowSpacing);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [
            'type' => $this->getType(),
        ];

        if ($this->alignment !== null) {
            $data['alignment'] = $this->alignment;
        }

        if ($this->distribution !== null) {
            $data['distribution'] = $this->distribution;
        }

        if ($this->rowSpacing !== null) {
            $data['rowSpacing'] = $this->rowSpacing;
        }

        if ($this->gutter !== null) {
            $data['gutter'] = $this->gutter;
        }

        if ($this->variableSizing !== null) {
            $data['variableSizing'] = $this->variableSizing;
        }

        if ($this->widths !== null) {
            $data['widths'] = $this->widths;
        }

        if ($this->minimumWidth !== null) {
            $data['minimumWidth'] = $this->minimumWidth;
        }

        if ($this->maximumWidth !== null) {
            $data['maximumWidth'] = $this->maximumWidth;
        }

        return $data;
    }
}

