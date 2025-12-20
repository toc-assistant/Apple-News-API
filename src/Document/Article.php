<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document;

use TomGould\AppleNews\Document\Components\Component;
use TomGould\AppleNews\Document\Layouts\Layout;
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;
use TomGould\AppleNews\Document\Styles\DocumentStyle;
use JsonSerializable;
use JsonException;

/**
 * Represents an Apple News Format (ANF) article document.
 *
 * The Article class is the root of the document tree. It holds the content
 * (components), layouts, text styles, and metadata. When serialized to JSON,
 * it produces the `article.json` file required by the Apple News API.
 *
 * @see https://developer.apple.com/documentation/apple_news/articledocument
 */
final class Article implements JsonSerializable
{
    /**
     * The supported version of Apple News Format.
     */
    private const CURRENT_VERSION = '1.24';

    /** @var array<Component> */
    private array $components = [];

    /** @var array<string, mixed> */
    private array $componentLayouts = [];

    /** @var array<string, ComponentTextStyle> */
    private array $componentTextStyles = [];

    /** @var array<string, mixed> */
    private array $componentStyles = [];

    private ?Metadata $metadata = null;
    private ?DocumentStyle $documentStyle = null;

    /** @var array<string, mixed> */
    private array $autoplacement = [];

    /**
     * @param string $identifier Unique ID for the article (for your internal reference).
     * @param string $title The article title (not necessarily displayed, but used in metadata).
     * @param string $language ISO language code (e.g., 'en', 'fr').
     * @param Layout $layout The column system layout for the article.
     * @param string $version The ANF version.
     */
    public function __construct(
        private readonly string $identifier,
        private readonly string $title,
        private readonly string $language,
        private readonly Layout $layout,
        private readonly string $version = self::CURRENT_VERSION
    ) {
    }

    /**
     * Static factory to create a new article with a standard default layout.
     *
     * @param string $identifier Your internal unique ID.
     * @param string $title Article title.
     * @param string $language ISO language code.
     * @param int $columns Number of grid columns (default 7).
     * @param int $width Grid width in points (default 1024).
     * @return self
     */
    public static function create(
        string $identifier,
        string $title,
        string $language = 'en',
        int $columns = 7,
        int $width = 1024
    ): self {
        return new self(
            $identifier,
            $title,
            $language,
            new Layout($columns, $width)
        );
    }

    /**
     * Add a single component to the article.
     *
     * @param Component $component Any component extending the base Component class.
     * @return self
     */
    public function addComponent(Component $component): self
    {
        $this->components[] = $component;
        return $this;
    }

    /**
     * Add multiple components at once.
     *
     * @param array<Component> $components
     * @return self
     */
    public function addComponents(array $components): self
    {
        foreach ($components as $component) {
            $this->addComponent($component);
        }
        return $this;
    }

    /**
     * Define a reusable component layout by name.
     *
     * @param string $name The name of the layout (used in Component::setLayout()).
     * @param array<string, mixed> $layout Associative array of layout properties.
     * @return self
     * @see https://developer.apple.com/documentation/apple_news/componentlayout
     */
    public function addComponentLayout(string $name, array $layout): self
    {
        $this->componentLayouts[$name] = $layout;
        return $this;
    }

    /**
     * Define a reusable text style by name.
     *
     * @param string $name Name of the style (used in TextComponent::setTextStyle()).
     * @param ComponentTextStyle $style Style object.
     * @return self
     * @see https://developer.apple.com/documentation/apple_news/componenttextstyle
     */
    public function addComponentTextStyle(string $name, ComponentTextStyle $style): self
    {
        $this->componentTextStyles[$name] = $style;
        return $this;
    }

    /**
     * Define a reusable component style (borders, fills, etc.) by name.
     *
     * @param string $name Name of the style (used in Component::setStyle()).
     * @param array<string, mixed> $style Associative array of style properties.
     * @return self
     * @see https://developer.apple.com/documentation/apple_news/componentstyle
     */
    public function addComponentStyle(string $name, array $style): self
    {
        $this->componentStyles[$name] = $style;
        return $this;
    }

    /**
     * Set the article-level metadata.
     *
     * @param Metadata $metadata
     * @return self
     */
    public function setMetadata(Metadata $metadata): self
    {
        $this->metadata = $metadata;
        return $this;
    }

    /**
     * Set the overall document style (e.g., background color).
     *
     * @param DocumentStyle $style
     * @return self
     */
    public function setDocumentStyle(DocumentStyle $style): self
    {
        $this->documentStyle = $style;
        return $this;
    }

    /**
     * Set autoplacement configuration for ads or related articles.
     *
     * @param array<string, mixed> $autoplacement
     * @return self
     * @see https://developer.apple.com/documentation/apple_news/autoplacement
     */
    public function setAutoplacement(array $autoplacement): self
    {
        $this->autoplacement = $autoplacement;
        return $this;
    }

    /**
     * Get the article identifier.
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Get the article title.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get all components currently in the article.
     *
     * @return array<Component>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    /**
     * Convert the entire article to a JSON string.
     *
     * @param int $flags JSON encoding flags.
     * @return string
     * @throws JsonException if serialization fails.
     */
    public function toJson(int $flags = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES): string
    {
        return json_encode($this, $flags | JSON_THROW_ON_ERROR);
    }

    /**
     * Required for JsonSerializable implementation.
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [
            'version' => $this->version,
            'identifier' => $this->identifier,
            'title' => $this->title,
            'language' => $this->language,
            'layout' => $this->layout,
            'components' => array_map(
                fn(Component $c) => $c->jsonSerialize(),
                $this->components
            ),
        ];

        if ($this->metadata !== null) {
            $data['metadata'] = $this->metadata;
        }

        if ($this->documentStyle !== null) {
            $data['documentStyle'] = $this->documentStyle;
        }

        if (!empty($this->componentLayouts)) {
            $data['componentLayouts'] = $this->componentLayouts;
        }

        if (!empty($this->componentTextStyles)) {
            $data['componentTextStyles'] = array_map(
                fn(ComponentTextStyle $s) => $s->jsonSerialize(),
                $this->componentTextStyles
            );
        }

        if (!empty($this->componentStyles)) {
            $data['componentStyles'] = $this->componentStyles;
        }

        if (!empty($this->autoplacement)) {
            $data['autoplacement'] = $this->autoplacement;
        }

        return $data;
    }
}

