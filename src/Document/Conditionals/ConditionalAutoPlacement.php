<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\AdvertisementAutoPlacement;
use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional auto-placement configuration.
 *
 * Allows ad placement settings to change based on conditions,
 * such as disabling ads on small screens.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionalautoplacement
 */
final class ConditionalAutoPlacement implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * The advertisement configuration.
     */
    private ?AdvertisementAutoPlacement $advertisement = null;

    /**
     * Whether auto-placement is enabled.
     */
    private ?bool $enabled = null;

    /**
     * Add a condition.
     *
     * @param Condition $condition The condition to add.
     *
     * @return $this
     */
    public function addCondition(Condition $condition): self
    {
        $this->conditions[] = $condition;
        return $this;
    }

    /**
     * Set the advertisement configuration.
     *
     * @param AdvertisementAutoPlacement $advertisement The ad configuration.
     *
     * @return $this
     */
    public function setAdvertisement(AdvertisementAutoPlacement $advertisement): self
    {
        $this->advertisement = $advertisement;
        return $this;
    }

    /**
     * Set whether auto-placement is enabled.
     *
     * @param bool $enabled Whether enabled.
     *
     * @return $this
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Create a conditional that disables ads on compact screens.
     *
     * @return self A new instance.
     */
    public static function disableOnCompact(): self
    {
        return (new self())
            ->addCondition(Condition::compactWidth())
            ->setAdvertisement(AdvertisementAutoPlacement::disabled());
    }

    /**
     * {@inheritdoc}
     */
    public function hasConditions(): bool
    {
        return !empty($this->conditions);
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if (!empty($this->conditions)) {
            $data['conditions'] = array_map(
                fn(Condition $c) => $c->jsonSerialize(),
                $this->conditions
            );
        }

        if ($this->advertisement !== null) {
            $data['advertisement'] = $this->advertisement->jsonSerialize();
        }

        if ($this->enabled !== null) {
            $data['enabled'] = $this->enabled;
        }

        return $data;
    }
}

