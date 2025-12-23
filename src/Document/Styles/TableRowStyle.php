<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Styles;

use JsonSerializable;

/**
 * Style for table rows.
 *
 * @see https://developer.apple.com/documentation/apple_news/tablerowstyle
 */
final class TableRowStyle implements JsonSerializable
{
    /**
     * The background color.
     */
    private ?string $backgroundColor = null;

    /**
     * The row divider.
     */
    private ?TableStrokeStyle $divider = null;

    /**
     * The row height.
     */
    private ?int $height = null;

    /**
     * Conditional styles.
     *
     * @var list<array<string, mixed>>|null
     */
    private ?array $conditional = null;

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
     * Set the row divider.
     *
     * @param TableStrokeStyle $divider The divider stroke.
     *
     * @return $this
     */
    public function setDivider(TableStrokeStyle $divider): self
    {
        $this->divider = $divider;
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
     * Set conditional styles.
     *
     * @param list<array<string, mixed>> $conditional The conditional styles.
     *
     * @return $this
     */
    public function setConditional(array $conditional): self
    {
        $this->conditional = $conditional;
        return $this;
    }

    /**
     * Create a zebra stripe style for alternating rows.
     *
     * @param string $color Background color for the row.
     *
     * @return self A style configured for striped rows (use with odd/even selector).
     */
    public static function zebraStripe(string $color): self
    {
        return (new self())->setBackgroundColor($color);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        if ($this->divider !== null) {
            $data['divider'] = $this->divider->jsonSerialize();
        }

        if ($this->height !== null) {
            $data['height'] = $this->height;
        }

        if ($this->conditional !== null) {
            $data['conditional'] = $this->conditional;
        }

        return $data;
    }
}

