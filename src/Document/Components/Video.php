<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for displaying native hosted videos.
 *
 * @see https://developer.apple.com/documentation/apple_news/video-component
 */
final class Video extends Component
{
    private ?string $caption = null;
    private ?string $stillURL = null;
    private ?string $accessibilityCaption = null;
    private ?bool $explicitContent = null;

    /**
     * @param string $url Direct URL to the video file.
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'video';
    }

    /**
     * Set the visible caption.
     * @param string $caption
     * @return self
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Set the thumbnail image URL to show before the video plays.
     * @param string $stillURL
     * @return self
     */
    public function setStillURL(string $stillURL): self
    {
        $this->stillURL = $stillURL;
        return $this;
    }

    /**
     * Set VoiceOver accessibility caption.
     * @param string $caption
     * @return self
     */
    public function setAccessibilityCaption(string $caption): self
    {
        $this->accessibilityCaption = $caption;
        return $this;
    }

    /**
     * Mark video as containing explicit content.
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

        if ($this->stillURL !== null) {
            $data['stillURL'] = $this->stillURL;
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

