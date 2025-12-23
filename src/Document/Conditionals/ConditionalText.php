<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

/**
 * Conditional properties for text components.
 *
 * Allows text-specific properties like textStyle to change
 * based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaltext
 */
final class ConditionalText extends ConditionalComponent
{
    /**
     * The text style reference.
     */
    private ?string $textStyle = null;

    /**
     * Inline text styles.
     *
     * @var array<string, mixed>|null
     */
    private ?array $inlineTextStyles = null;

    /**
     * Set the text style reference.
     *
     * @param string $textStyle The text style name.
     *
     * @return $this
     */
    public function setTextStyle(string $textStyle): self
    {
        $this->textStyle = $textStyle;
        return $this;
    }

    /**
     * Set inline text styles.
     *
     * @param array<string, mixed> $styles The inline styles.
     *
     * @return $this
     */
    public function setInlineTextStyles(array $styles): self
    {
        $this->inlineTextStyles = $styles;
        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        if ($this->textStyle !== null) {
            $data['textStyle'] = $this->textStyle;
        }

        if ($this->inlineTextStyles !== null) {
            $data['inlineTextStyles'] = $this->inlineTextStyles;
        }

        return $data;
    }
}

