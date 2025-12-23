<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for text styles.
 *
 * Allows text style properties like font, color, and size
 * to change based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaltextstyle
 */
class ConditionalTextStyle implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * The text color.
     */
    private ?string $textColor = null;

    /**
     * The background color.
     */
    private ?string $backgroundColor = null;

    /**
     * The font name.
     */
    private ?string $fontName = null;

    /**
     * The font size in points.
     */
    private ?int $fontSize = null;

    /**
     * The font weight.
     */
    private ?int $fontWeight = null;

    /**
     * The font width.
     */
    private ?string $fontWidth = null;

    /**
     * The font style.
     */
    private ?string $fontStyle = null;

    /**
     * The line height in points.
     */
    private ?float $lineHeight = null;

    /**
     * The letter spacing (tracking).
     */
    private ?float $tracking = null;

    /**
     * The text alignment.
     */
    private ?string $textAlignment = null;

    /**
     * The text shadow.
     *
     * @var array<string, mixed>|null
     */
    private ?array $textShadow = null;

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
     * Set the font name.
     *
     * @param string $fontName The font name.
     *
     * @return $this
     */
    public function setFontName(string $fontName): self
    {
        $this->fontName = $fontName;
        return $this;
    }

    /**
     * Set the font size.
     *
     * @param int $size The size in points.
     *
     * @return $this
     */
    public function setFontSize(int $size): self
    {
        $this->fontSize = $size;
        return $this;
    }

    /**
     * Set the font weight.
     *
     * @param int $weight The weight (100-900).
     *
     * @return $this
     */
    public function setFontWeight(int $weight): self
    {
        $this->fontWeight = $weight;
        return $this;
    }

    /**
     * Set the font width.
     *
     * @param string $width The width value.
     *
     * @return $this
     */
    public function setFontWidth(string $width): self
    {
        $this->fontWidth = $width;
        return $this;
    }

    /**
     * Set the font style.
     *
     * @param string $style The style ('normal', 'italic', 'oblique').
     *
     * @return $this
     */
    public function setFontStyle(string $style): self
    {
        $this->fontStyle = $style;
        return $this;
    }

    /**
     * Set the line height.
     *
     * @param float $height The line height in points.
     *
     * @return $this
     */
    public function setLineHeight(float $height): self
    {
        $this->lineHeight = $height;
        return $this;
    }

    /**
     * Set the tracking (letter spacing).
     *
     * @param float $tracking The tracking value.
     *
     * @return $this
     */
    public function setTracking(float $tracking): self
    {
        $this->tracking = $tracking;
        return $this;
    }

    /**
     * Set the text alignment.
     *
     * @param string $alignment One of 'left', 'center', 'right', 'justified'.
     *
     * @return $this
     */
    public function setTextAlignment(string $alignment): self
    {
        $this->textAlignment = $alignment;
        return $this;
    }

    /**
     * Set the text shadow.
     *
     * @param array<string, mixed> $shadow The shadow configuration.
     *
     * @return $this
     */
    public function setTextShadow(array $shadow): self
    {
        $this->textShadow = $shadow;
        return $this;
    }

    /**
     * Create a dark mode text style.
     *
     * @param string $textColor The dark mode text color.
     *
     * @return self A new instance.
     */
    public static function darkMode(string $textColor): self
    {
        return (new self())
            ->addCondition(Condition::darkMode())
            ->setTextColor($textColor);
    }

    /**
     * Create a light mode text style.
     *
     * @param string $textColor The light mode text color.
     *
     * @return self A new instance.
     */
    public static function lightMode(string $textColor): self
    {
        return (new self())
            ->addCondition(Condition::lightMode())
            ->setTextColor($textColor);
    }

    /**
     * Create a smaller text style for compact screens.
     *
     * @param int $fontSize The smaller font size.
     *
     * @return self A new instance.
     */
    public static function compactSize(int $fontSize): self
    {
        return (new self())
            ->addCondition(Condition::compactWidth())
            ->setFontSize($fontSize);
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

        if ($this->textColor !== null) {
            $data['textColor'] = $this->textColor;
        }

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        if ($this->fontName !== null) {
            $data['fontName'] = $this->fontName;
        }

        if ($this->fontSize !== null) {
            $data['fontSize'] = $this->fontSize;
        }

        if ($this->fontWeight !== null) {
            $data['fontWeight'] = $this->fontWeight;
        }

        if ($this->fontWidth !== null) {
            $data['fontWidth'] = $this->fontWidth;
        }

        if ($this->fontStyle !== null) {
            $data['fontStyle'] = $this->fontStyle;
        }

        if ($this->lineHeight !== null) {
            $data['lineHeight'] = $this->lineHeight;
        }

        if ($this->tracking !== null) {
            $data['tracking'] = $this->tracking;
        }

        if ($this->textAlignment !== null) {
            $data['textAlignment'] = $this->textAlignment;
        }

        if ($this->textShadow !== null) {
            $data['textShadow'] = $this->textShadow;
        }

        return $data;
    }
}

