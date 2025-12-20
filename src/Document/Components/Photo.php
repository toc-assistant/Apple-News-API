<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for displaying single images in an article.
 *
 * Supports remote URLs and local bundle resources.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/photo
 */
final class Photo extends Component
{
    private ?string $caption = null;
    private ?string $accessibilityCaption = null;
    private ?bool $explicitContent = null;

    /**
     * @param string $url The image URL (bundle://... or http...).
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    /**
     * Create a photo referencing a file in the multipart bundle.
     * @param string $filename
     * @return self
     */
    public static function fromBundle(string $filename): self
    {
        return new self('bundle://' . $filename);
    }

    /**
     * Create a photo referencing an external image URL.
     * @param string $url
     * @return self
     */
    public static function fromUrl(string $url): self
    {
        return new self($url);
    }

    public function getRole(): string
    {
        return 'photo';
    }

    /**
     * Set a visible caption.
     * @param string $caption
     * @return self
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Set a VoiceOver accessibility description.
     * @param string $caption
     * @return self
     */
    public function setAccessibilityCaption(string $caption): self
    {
        $this->accessibilityCaption = $caption;
        return $this;
    }

    /**
     * Mark the image as explicit content.
     * @param bool $explicit
     * @return self
     */
    public function setExplicitContent(bool $explicit): self
    {
        $this->explicitContent = $explicit;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();
        $data['URL'] = $this->url;

        if ($this->caption !== null) {
            $data['caption'] = $this->caption;
        }

        if ($this->accessibilityCaption !== null) {
            $data['accessibilityCaption'] = $this->accessibilityCaption;
        }

        if ($this->explicitContent !== null) {
            $data['explicitContent'] = $this->explicitContent;
        }

        return $data;
    }
}
