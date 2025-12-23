<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

use JsonSerializable;

/**
 * Auto-placement configuration for automatic component insertion.
 *
 * The AutoPlacement object controls how advertisements and other components
 * are automatically placed throughout the article.
 *
 * @see https://developer.apple.com/documentation/apple_news/autoplacement
 */
final class AutoPlacement implements JsonSerializable
{
    /**
     * Advertisement auto-placement configuration.
     */
    private ?AdvertisementAutoPlacement $advertisement = null;

    /**
     * Conditional auto-placement configurations.
     *
     * @var list<array<string, mixed>>|null
     */
    private ?array $conditional = null;

    /**
     * Set the advertisement auto-placement.
     *
     * @param AdvertisementAutoPlacement $advertisement The advertisement configuration.
     *
     * @return $this
     */
    public function setAdvertisement(AdvertisementAutoPlacement $advertisement): self
    {
        $this->advertisement = $advertisement;
        return $this;
    }

    /**
     * Set conditional auto-placements.
     *
     * @param list<array<string, mixed>> $conditional Array of conditional placements.
     *
     * @return $this
     */
    public function setConditional(array $conditional): self
    {
        $this->conditional = $conditional;
        return $this;
    }

    /**
     * Add a conditional auto-placement.
     *
     * @param Condition                       $condition     The condition to match.
     * @param AdvertisementAutoPlacement|null $advertisement Optional ad config for this condition.
     *
     * @return $this
     */
    public function addConditional(Condition $condition, ?AdvertisementAutoPlacement $advertisement = null): self
    {
        if ($this->conditional === null) {
            $this->conditional = [];
        }

        $entry = [
            'conditions' => [$condition->jsonSerialize()],
        ];

        if ($advertisement !== null) {
            $entry['advertisement'] = $advertisement->jsonSerialize();
        }

        $this->conditional[] = $entry;
        return $this;
    }

    /**
     * Create an AutoPlacement with ads disabled.
     *
     * @return self A new AutoPlacement instance.
     */
    public static function withAdsDisabled(): self
    {
        return (new self())->setAdvertisement(AdvertisementAutoPlacement::disabled());
    }

    /**
     * Create an AutoPlacement with specific ad frequency.
     *
     * @param int $frequency Number of components between ads.
     *
     * @return self A new AutoPlacement instance.
     */
    public static function withAdFrequency(int $frequency): self
    {
        return (new self())->setAdvertisement(
            AdvertisementAutoPlacement::withFrequency($frequency)
        );
    }

    /**
     * Check if the auto-placement has any configuration.
     *
     * @return bool True if any configuration is set.
     */
    public function isEmpty(): bool
    {
        return $this->advertisement === null && $this->conditional === null;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->advertisement !== null) {
            $data['advertisement'] = $this->advertisement->jsonSerialize();
        }

        if ($this->conditional !== null) {
            $data['conditional'] = $this->conditional;
        }

        return $data;
    }
}

