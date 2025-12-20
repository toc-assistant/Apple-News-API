<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Component for displaying a collection of images as a gallery.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/gallery
 */
final class Gallery extends Component
{
    /** @var array<array<string, mixed>> List of gallery images. */
    private array $items = [];

    public function getRole(): string
    {
        return 'gallery';
    }

    /**
     * Add an image to the gallery.
     *
     * @param string $url Image URL (bundle:// or http).
     * @param string|null $caption Optional visible caption.
     * @param string|null $accessibilityCaption Optional VoiceOver caption.
     * @return self
     */
    public function addItem(string $url, ?string $caption = null, ?string $accessibilityCaption = null): self
    {
        $item = ['URL' => $url];

        if ($caption !== null) {
            $item['caption'] = $caption;
        }

        if ($accessibilityCaption !== null) {
            $item['accessibilityCaption'] = $accessibilityCaption;
        }

        $this->items[] = $item;
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = $this->getBaseProperties();
        $data['items'] = $this->items;
        return $data;
    }
}
