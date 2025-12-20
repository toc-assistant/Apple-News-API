<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Embeds third-party video content (YouTube, Vimeo, etc.).
 *
 * @see https://developer.apple.com/documentation/applenewsformat/embedwebvideo
 */
final class EmbedWebVideo extends Component
{
    private ?string $caption = null;
    private ?string $accessibilityCaption = null;
    private ?bool $explicitContent = null;
    private ?string $aspectRatio = null;

    /**
     * @param string $url The direct URL to the web video page.
     */
    public function __construct(
        private readonly string $url
    ) {
    }

    public function getRole(): string
    {
        return 'embedwebvideo';
    }

    /**
     * Set a visible caption for the video.
     * @param string $caption
     * @return self
     */
    public function setCaption(string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * Set a caption for VoiceOver users.
     * @param string $caption
     * @return self
     */
    public function setAccessibilityCaption(string $caption): self
    {
        $this->accessibilityCaption = $caption;
        return $this;
    }

    /**
     * Mark the video as containing explicit content.
     * @param bool $explicit
     * @return self
     */
    public function setExplicitContent(bool $explicit): self
    {
        $this->explicitContent = $explicit;
        return $this;
    }

    /**
     * Set the aspect ratio of the video player (e.g., "1.777" for 16:9).
     * @param string $aspectRatio
     * @return self
     */
    public function setAspectRatio(string $aspectRatio): self
    {
        $this->aspectRatio = $aspectRatio;
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

        if ($this->aspectRatio !== null) {
            $data['aspectRatio'] = $this->aspectRatio;
        }

        return $data;
    }
}
