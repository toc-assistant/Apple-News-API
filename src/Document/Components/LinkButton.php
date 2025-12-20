<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * A call-to-action button that links to an external URL or article section.
 *
 * @see https://developer.apple.com/documentation/apple_news/linkbutton
 */
final class LinkButton extends Component
{
    private ?string $textStyle = null;

    /**
     * @param string $text The button label.
     * @param string $url The target URL.
     */
    public function __construct(
        private readonly string $text,
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'link_button';
    }

    /**
     * Apply a text style to the button label.
     * @param string $textStyle
     * @return self
     */
    public function setTextStyle(string $textStyle): self
    {
        $this->textStyle = $textStyle;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();
        $data['text'] = $this->text;
        $data['URL'] = $this->url;

        if ($this->textStyle !== null) {
            $data['textStyle'] = $this->textStyle;
        }

        return $data;
    }
}

