<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Conditionals;

use TomGould\AppleNews\Document\Layouts\Condition;

/**
 * Conditional properties for document styles.
 *
 * Allows document-level style properties to change based on conditions,
 * typically used for dark mode support.
 *
 * @see https://developer.apple.com/documentation/apple_news/conditionaldocumentstyle
 */
final class ConditionalDocumentStyle implements ConditionalInterface
{
    /**
     * The conditions that must be met.
     *
     * @var list<Condition>
     */
    private array $conditions = [];

    /**
     * The background color.
     */
    private ?string $backgroundColor = null;

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
     * Set the background color.
     *
     * @param string $color The color in hex format.
     *
     * @return $this
     */
    public function setBackgroundColor(string $color): self
    {
        $this->backgroundColor = $color;
        return $this;
    }

    /**
     * Create a dark mode document style.
     *
     * @param string $backgroundColor The dark mode background color.
     *
     * @return self A new instance.
     */
    public static function darkMode(string $backgroundColor = '#1C1C1E'): self
    {
        return (new self())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor($backgroundColor);
    }

    /**
     * Create a light mode document style.
     *
     * @param string $backgroundColor The light mode background color.
     *
     * @return self A new instance.
     */
    public static function lightMode(string $backgroundColor = '#FFFFFF'): self
    {
        return (new self())
            ->addCondition(Condition::lightMode())
            ->setBackgroundColor($backgroundColor);
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

        if ($this->backgroundColor !== null) {
            $data['backgroundColor'] = $this->backgroundColor;
        }

        return $data;
    }
}
