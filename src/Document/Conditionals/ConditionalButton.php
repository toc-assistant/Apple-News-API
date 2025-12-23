<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

/**
 * Conditional properties for button components.
 *
 * Allows button-specific properties like textStyle to change
 * based on conditions.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalbutton
 */
final class ConditionalButton extends ConditionalComponent
{
    /**
     * The text style reference.
     */
    private ?string $textStyle = null;

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

        return $data;
    }
}
