<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Base class for all components that primarily contain text content.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/text
 */
abstract class TextComponent extends Component
{
    /** @var string|null Reference to a named text style. */
    protected ?string $textStyle = null;

    /** @var array<array<string, mixed>>|null Inline style overrides. */
    protected ?array $inlineTextStyles = null;

    /** @var string|null The text format (none, html, markdown). */
    protected ?string $format = null;

    /** @var array<array<string, mixed>>|null Additions (links) applied to text ranges. */
    protected ?array $additions = null;

    /**
     * @param string $text The raw text content.
     */
    public function __construct(
        protected readonly string $text
    ) {
    }

    /**
     * Set the text style name.
     * @param string $textStyle
     * @return static
     */
    public function setTextStyle(string $textStyle): static
    {
        $this->textStyle = $textStyle;
        return $this;
    }

    /**
     * Define specific styles for ranges of text within this component.
     * @param array<array<string, mixed>> $styles
     * @return static
     */
    public function setInlineTextStyles(array $styles): static
    {
        $this->inlineTextStyles = $styles;
        return $this;
    }

    /**
     * Set the format of the text content ('html' or 'markdown').
     * @param string $format
     * @return static
     */
    public function setFormat(string $format): static
    {
        $this->format = $format;
        return $this;
    }

    /**
     * Set additions (link ranges) for the text component.
     *
     * Additions allow you to apply links to specific ranges of text.
     * Note: Additions are not supported when format is 'html' or 'markdown'.
     *
     * @param array<array<string, mixed>> $additions Array of addition objects with rangeStart, rangeLength, and link.
     * @return static
     * @see https://developer.apple.com/documentation/applenewsformat/addition
     */
    public function setAdditions(array $additions): static
    {
        $this->additions = $additions;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();
        $data['text'] = $this->text;

        if ($this->textStyle !== null) {
            $data['textStyle'] = $this->textStyle;
        }

        if ($this->inlineTextStyles !== null) {
            $data['inlineTextStyles'] = $this->inlineTextStyles;
        }

        if ($this->format !== null) {
            $data['format'] = $this->format;
        }

        if ($this->additions !== null) {
            $data['additions'] = $this->additions;
        }

        return $data;
    }
}
