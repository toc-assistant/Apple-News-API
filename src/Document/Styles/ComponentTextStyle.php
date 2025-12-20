<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Styles;

use JsonSerializable;

/**
 * Detailed text styling options for components.
 *
 * This class controls typography including fonts, colors, spacing, and alignment.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/componenttextstyle
 */
final class ComponentTextStyle implements JsonSerializable
{
    private ?string $fontName = null;
    private ?int $fontSize = null;
    private ?string $textColor = null;
    private ?string $textAlignment = null;
    private ?float $lineHeight = null;
    private ?float $tracking = null;
    private ?bool $hyphenation = null;
    private ?string $fontWeight = null;
    private ?string $fontStyle = null;
    private ?string $textDecoration = null;
    private ?string $textTransform = null;

    /** @var array<string, mixed>|null */
    private ?array $linkStyle = null;

    /** @var array<string, mixed>|null */
    private ?array $dropCapStyle = null;

    private ?string $backgroundColor = null;

    /** @var array<string, mixed>|null */
    private ?array $textShadow = null;

    private ?int $paragraphSpacingBefore = null;
    private ?int $paragraphSpacingAfter = null;
    private ?int $firstLineIndent = null;
    private ?int $hangingPunctuation = null;

    /**
     * Set the font family name.
     * @param string $fontName
     * @return self
     */
    public function setFontName(string $fontName): self
    {
        $this->fontName = $fontName;
        return $this;
    }

    /**
     * Set the font size in points.
     * @param int $fontSize
     * @return self
     */
    public function setFontSize(int $fontSize): self
    {
        $this->fontSize = $fontSize;
        return $this;
    }

    /**
     * Set the text color.
     * @param string $color
     * @return self
     */
    public function setTextColor(string $color): self
    {
        $this->textColor = $color;
        return $this;
    }

    /**
     * Set text alignment (left, center, right, justify).
     * @param string $alignment
     * @return self
     */
    public function setTextAlignment(string $alignment): self
    {
        $this->textAlignment = $alignment;
        return $this;
    }

    /**
     * Set the line height in points.
     * @param float $lineHeight
     * @return self
     */
    public function setLineHeight(float $lineHeight): self
    {
        $this->lineHeight = $lineHeight;
        return $this;
    }

    /**
     * Set letter spacing (tracking).
     * @param float $tracking
     * @return self
     */
    public function setTracking(float $tracking): self
    {
        $this->tracking = $tracking;
        return $this;
    }

    /**
     * Enable or disable automatic hyphenation.
     * @param bool $hyphenation
     * @return self
     */
    public function setHyphenation(bool $hyphenation): self
    {
        $this->hyphenation = $hyphenation;
        return $this;
    }

    /**
     * Set font weight (e.g., "bold", "100").
     * @param string $weight
     * @return self
     */
    public function setFontWeight(string $weight): self
    {
        $this->fontWeight = $weight;
        return $this;
    }

    /**
     * Set font style (normal, italic).
     * @param string $style
     * @return self
     */
    public function setFontStyle(string $style): self
    {
        $this->fontStyle = $style;
        return $this;
    }

    /**
     * Set text decoration (underline, line-through).
     * @param string $decoration
     * @return self
     */
    public function setTextDecoration(string $decoration): self
    {
        $this->textDecoration = $decoration;
        return $this;
    }

    /**
     * Set text transform (uppercase, lowercase, capitalize).
     * @param string $transform
     * @return self
     */
    public function setTextTransform(string $transform): self
    {
        $this->textTransform = $transform;
        return $this;
    }

    /**
     * Define styles for links within the text.
     * @param array<string, mixed> $style
     * @return self
     */
    public function setLinkStyle(array $style): self
    {
        $this->linkStyle = $style;
        return $this;
    }

    /**
     * Define the drop cap style for the first letter.
     * @param array<string, mixed> $style
     * @return self
     */
    public function setDropCapStyle(array $style): self
    {
        $this->dropCapStyle = $style;
        return $this;
    }

    /**
     * Set background color for the text span.
     * @param string $color
     * @return self
     */
    public function setBackgroundColor(string $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * Apply a shadow effect to the text.
     * @param array<string, mixed> $shadow
     * @return self
     */
    public function setTextShadow(array $shadow): self
    {
        $this->textShadow = $shadow;
        return $this;
    }

    /**
     * Set spacing before paragraphs.
     * @param int $spacing
     * @return self
     */
    public function setParagraphSpacingBefore(int $spacing): self
    {
        $this->paragraphSpacingBefore = $spacing;
        return $this;
    }

    /**
     * Set spacing after paragraphs.
     * @param int $spacing
     * @return self
     */
    public function setParagraphSpacingAfter(int $spacing): self
    {
        $this->paragraphSpacingAfter = $spacing;
        return $this;
    }

    /**
     * Set the indentation of the first line.
     * @param int $indent
     * @return self
     */
    public function setFirstLineIndent(int $indent): self
    {
        $this->firstLineIndent = $indent;
        return $this;
    }

    /**
     * Control hanging punctuation (e.g., quotes outside the alignment).
     * @param int $value
     * @return self
     */
    public function setHangingPunctuation(int $value): self
    {
        $this->hangingPunctuation = $value;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->fontName !== null) {
            $data['fontName'] = $this->fontName;
        }

        if ($this->fontSize !== null) {
            $data['fontSize'] = $this->fontSize;
        }

        if ($this->textColor !== null) {
            $data['textColor'] = $this->textColor;
        }

        if ($this->textAlignment !== null) {
            $data['textAlignment'] = $this->textAlignment;
        }

        if ($this->lineHeight !== null) {
            $data['lineHeight'] = $this->lineHeight;
        }

        if ($this->tracking !== null) {
            $data['tracking'] = $this->tracking;
        }

        if ($this->hyphenation !== null) {
            $data['hyphenation'] = $this->hyphenation;
        }

        if ($this->fontWeight !== null) {
            $data['fontWeight'] = $this->fontWeight;
        }

        if ($this->fontStyle !== null) {
            $data['fontStyle'] = $this->fontStyle;
        }

        if ($this->textDecoration !== null) {
            $data['textDecoration'] = $this->textDecoration;
        }

        if ($this->textTransform !== null) {
            $data['textTransform'] = $this->textTransform;
        }

        if ($this->linkStyle !== null) {
            $data['linkStyle'] = $this->linkStyle;
        }

        if ($this->dropCapStyle !== null) {
            $data['dropCapStyle'] = $this->dropCapStyle;
        }

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        if ($this->textShadow !== null) {
            $data['textShadow'] = $this->textShadow;
        }

        if ($this->paragraphSpacingBefore !== null) {
            $data['paragraphSpacingBefore'] = $this->paragraphSpacingBefore;
        }

        if ($this->paragraphSpacingAfter !== null) {
            $data['paragraphSpacingAfter'] = $this->paragraphSpacingAfter;
        }

        if ($this->firstLineIndent !== null) {
            $data['firstLineIndent'] = $this->firstLineIndent;
        }

        if ($this->hangingPunctuation !== null) {
            $data['hangingPunctuation'] = $this->hangingPunctuation;
        }

        return $data;
    }
}
