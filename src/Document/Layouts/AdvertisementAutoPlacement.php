<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

use JsonSerializable;

/**
 * Advertisement auto-placement configuration.
 *
 * Controls how advertisements are automatically placed within the article.
 *
 * @see https://developer.apple.com/documentation/apple_news/advertisementautoplacement
 */
final class AdvertisementAutoPlacement implements JsonSerializable
{
    /**
     * Whether banner ads are enabled.
     */
    private ?bool $bannerType = null;

    /**
     * Distance from article start before first ad (in points or % of content).
     */
    private ?int $distanceFromMedia = null;

    /**
     * Whether ads are enabled.
     */
    private ?bool $enabled = null;

    /**
     * Frequency of ads (number of components between ads).
     */
    private ?int $frequency = null;

    /**
     * Layout for the advertisement component.
     */
    private ?string $layout = null;

    /**
     * Set whether banner type ads are enabled.
     *
     * @param bool $enabled Whether banners are enabled.
     *
     * @return $this
     */
    public function setBannerType(bool $enabled): self
    {
        $this->bannerType = $enabled;
        return $this;
    }

    /**
     * Set the distance from media before placing an ad.
     *
     * @param int $distance Distance in points.
     *
     * @return $this
     */
    public function setDistanceFromMedia(int $distance): self
    {
        $this->distanceFromMedia = $distance;
        return $this;
    }

    /**
     * Set whether ads are enabled.
     *
     * @param bool $enabled Whether ads are enabled.
     *
     * @return $this
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Set the frequency of ads.
     *
     * @param int $frequency Number of components between ads.
     *
     * @return $this
     */
    public function setFrequency(int $frequency): self
    {
        $this->frequency = $frequency;
        return $this;
    }

    /**
     * Set the layout reference for ads.
     *
     * @param string $layout Layout name.
     *
     * @return $this
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;
        return $this;
    }

    /**
     * Create a disabled advertisement placement.
     *
     * @return self A new instance with ads disabled.
     */
    public static function disabled(): self
    {
        return (new self())->setEnabled(false);
    }

    /**
     * Create an advertisement placement with specific frequency.
     *
     * @param int $frequency Number of components between ads.
     *
     * @return self A new instance.
     */
    public static function withFrequency(int $frequency): self
    {
        return (new self())
            ->setEnabled(true)
            ->setFrequency($frequency);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->bannerType !== null) {
            $data['bannerType'] = $this->bannerType;
        }

        if ($this->distanceFromMedia !== null) {
            $data['distanceFromMedia'] = $this->distanceFromMedia;
        }

        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }

        if ($this->frequency !== null) {
            $data['frequency'] = $this->frequency;
        }

        if ($this->layout !== null) {
            $data['layout'] = $this->layout;
        }

        return $data;
    }
}

