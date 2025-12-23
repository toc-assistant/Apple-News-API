<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document;

use DateTimeInterface;
use JsonSerializable;
use TomGould\AppleNews\Document\Issue;

/**
 * Article metadata for Apple News Format.
 *
 * Metadata provides information about the article that is not part of the
 * document content itself, such as authors, canonical URLs, and keywords.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/metadata
 */
final class Metadata implements JsonSerializable
{
    /** @var array<string> List of author names. */
    private array $authors = [];

    /** @var string|null Canonical URL of the original article. */
    private ?string $canonicalURL = null;

    /** @var string|null ISO 8601 creation date. */
    private ?string $dateCreated = null;

    /** @var string|null ISO 8601 modification date. */
    private ?string $dateModified = null;

    /** @var string|null ISO 8601 publication date. */
    private ?string $datePublished = null;

    /** @var string|null Short summary of the article. */
    private ?string $excerpt = null;

    /** @var string|null CMS or tool that generated the article. */
    private ?string $generatorIdentifier = null;

    /** @var string|null Name of the generator tool. */
    private ?string $generatorName = null;

    /** @var string|null Version of the generator tool. */
    private ?string $generatorVersion = null;

    /** @var array<string> List of tags/keywords. */
    private array $keywords = [];

    /** @var array<array<string, string>> Relationship links. */
    private array $links = [];

    /** @var string|null URL for the article's tile image. */
    private ?string $thumbnailURL = null;

    /** @var bool|null Whether the toolbar should be transparent. */
    private ?bool $transparentToolbar = null;

    /** @var string|null URL for a video to play in the article tile. */
    private ?string $videoURL = null;

    /**
     * Content generation type indicator.
     *
     * Set to "AI" for AI-generated content as required by Apple policy.
     */
    private ?string $contentGenerationType = null;

    /**
     * Campaign data for advertising targeting.
     *
     * @var array<string, list<string>>|null
     */
    private ?array $campaignData = null;

    /**
     * Issue information for magazine/periodical content.
     */
    private ?Issue $issue = null;

    /**
     * Add an author name.
     * @param string $author
     * @return self
     */
    public function addAuthor(string $author): self
    {
        $this->authors[] = $author;
        return $this;
    }

    /**
     * Set the canonical URL.
     * @param string $url
     * @return self
     */
    public function setCanonicalURL(string $url): self
    {
        $this->canonicalURL = $url;
        return $this;
    }

    /**
     * Set the date the article was created.
     * @param DateTimeInterface|string $date
     * @return self
     */
    public function setDateCreated(DateTimeInterface|string $date): self
    {
        $this->dateCreated = $date instanceof DateTimeInterface
            ? $date->format('c')
            : $date;
        return $this;
    }

    /**
     * Set the date the article was last modified.
     * @param DateTimeInterface|string $date
     * @return self
     */
    public function setDateModified(DateTimeInterface|string $date): self
    {
        $this->dateModified = $date instanceof DateTimeInterface
            ? $date->format('c')
            : $date;
        return $this;
    }

    /**
     * Set the date the article was published.
     * @param DateTimeInterface|string $date
     * @return self
     */
    public function setDatePublished(DateTimeInterface|string $date): self
    {
        $this->datePublished = $date instanceof DateTimeInterface
            ? $date->format('c')
            : $date;
        return $this;
    }

    /**
     * Set the article excerpt/summary.
     * @param string $excerpt
     * @return self
     */
    public function setExcerpt(string $excerpt): self
    {
        $this->excerpt = $excerpt;
        return $this;
    }

    /**
     * Set the generator identifier (e.g., 'Drupal').
     * @param string $identifier
     * @return self
     */
    public function setGeneratorIdentifier(string $identifier): self
    {
        $this->generatorIdentifier = $identifier;
        return $this;
    }

    /**
     * Set the name of the tool that generated this document.
     * @param string $name
     * @return self
     */
    public function setGeneratorName(string $name): self
    {
        $this->generatorName = $name;
        return $this;
    }

    /**
     * Set the version string for the generator tool.
     * @param string $version
     * @return self
     */
    public function setGeneratorVersion(string $version): self
    {
        $this->generatorVersion = $version;
        return $this;
    }

    /**
     * Add a single keyword.
     * @param string $keyword
     * @return self
     */
    public function addKeyword(string $keyword): self
    {
        $this->keywords[] = $keyword;
        return $this;
    }

    /**
     * Add multiple keywords at once.
     * @param array<string> $keywords
     * @return self
     */
    public function addKeywords(array $keywords): self
    {
        foreach ($keywords as $keyword) {
            $this->addKeyword($keyword);
        }
        return $this;
    }

    /**
     * Add a link to a related article or resource.
     * @param string $url Target URL.
     * @param string $relationship Relationship type (e.g., 'related').
     * @return self
     */
    public function addLinkedArticle(string $url, string $relationship): self
    {
        $this->links[] = [
            'URL' => $url,
            'relationship' => $relationship,
        ];
        return $this;
    }

    /**
     * Set the thumbnail image URL for article discovery.
     * @param string $url
     * @return self
     */
    public function setThumbnailURL(string $url): self
    {
        $this->thumbnailURL = $url;
        return $this;
    }

    /**
     * Enable or disable transparent toolbar in the news app.
     * @param bool $transparent
     * @return self
     */
    public function setTransparentToolbar(bool $transparent): self
    {
        $this->transparentToolbar = $transparent;
        return $this;
    }

    /**
     * Set the video URL to be used in the article tile.
     * @param string $url
     * @return self
     */
    public function setVideoURL(string $url): self
    {
        $this->videoURL = $url;
        return $this;
    }

    /**
     * Set the content generation type.
     *
     * Use "AI" to indicate that the article content was generated by artificial
     * intelligence. This disclosure is required by Apple policy for AI-generated content.
     *
     * @param string $type The content generation type (e.g., "AI").
     *
     * @return $this
     */
    public function setContentGenerationType(string $type): self
    {
        $this->contentGenerationType = $type;
        return $this;
    }

    /**
     * Mark the content as AI-generated.
     *
     * Convenience method that sets contentGenerationType to "AI".
     * Use this for any content that was primarily generated by AI.
     *
     * @return $this
     */
    public function setAsAIGenerated(): self
    {
        $this->contentGenerationType = 'AI';
        return $this;
    }

    /**
     * Set campaign data for advertising targeting.
     *
     * Campaign data allows you to provide key-value pairs that can be used
     * for advertising targeting. Each key maps to an array of string values.
     *
     * Example:
     * ```php
     * $metadata->setCampaignData([
     *     'sport' => ['football', 'basketball'],
     *     'region' => ['west-coast']
     * ]);
     * ```
     *
     * @param array<string, list<string>> $campaignData Key-value pairs for ad targeting.
     *
     * @return $this
     */
    public function setCampaignData(array $campaignData): self
    {
        $this->campaignData = $campaignData;
        return $this;
    }

    /**
     * Add a campaign data entry.
     *
     * Adds or merges values for a specific campaign data key.
     *
     * @param string       $key    The campaign data key.
     * @param list<string> $values The values to associate with this key.
     *
     * @return $this
     */
    public function addCampaignData(string $key, array $values): self
    {
        if ($this->campaignData === null) {
            $this->campaignData = [];
        }

        if (!isset($this->campaignData[$key])) {
            $this->campaignData[$key] = [];
        }

        $this->campaignData[$key] = array_values(
            array_unique(array_merge($this->campaignData[$key], $values))
        );

        return $this;
    }

    /**
     * Set the issue information for magazine/periodical content.
     *
     * Use this to associate the article with a specific publication issue.
     *
     * @param Issue $issue The issue object.
     *
     * @return $this
     */
    public function setIssue(Issue $issue): self
    {
        $this->issue = $issue;
        return $this;
    }

    /**
     * Set issue information from an array.
     *
     * Convenience method to set issue data without creating an Issue object.
     *
     * Example:
     * ```php
     * $metadata->setIssueFromArray([
     *     'issueIdentifier' => 'issue-2024-01',
     *     'issueDate' => '2024-01-15',
     *     'issueName' => 'January 2024'
     * ]);
     * ```
     *
     * @param array<string, mixed> $issueData The issue data.
     *
     * @return $this
     */
    public function setIssueFromArray(array $issueData): self
    {
        $this->issue = Issue::fromArray($issueData);
        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if (!empty($this->authors)) {
            $data['authors'] = $this->authors;
        }

        if ($this->canonicalURL !== null) {
            $data['canonicalURL'] = $this->canonicalURL;
        }

        if ($this->dateCreated !== null) {
            $data['dateCreated'] = $this->dateCreated;
        }

        if ($this->dateModified !== null) {
            $data['dateModified'] = $this->dateModified;
        }

        if ($this->datePublished !== null) {
            $data['datePublished'] = $this->datePublished;
        }

        if ($this->excerpt !== null) {
            $data['excerpt'] = $this->excerpt;
        }

        if ($this->generatorIdentifier !== null) {
            $data['generatorIdentifier'] = $this->generatorIdentifier;
        }

        if ($this->generatorName !== null) {
            $data['generatorName'] = $this->generatorName;
        }

        if ($this->generatorVersion !== null) {
            $data['generatorVersion'] = $this->generatorVersion;
        }

        if (!empty($this->keywords)) {
            $data['keywords'] = $this->keywords;
        }

        if (!empty($this->links)) {
            $data['links'] = $this->links;
        }

        if ($this->thumbnailURL !== null) {
            $data['thumbnailURL'] = $this->thumbnailURL;
        }

        if ($this->transparentToolbar !== null) {
            $data['transparentToolbar'] = $this->transparentToolbar;
        }

        if ($this->videoURL !== null) {
            $data['videoURL'] = $this->videoURL;
        }

        if ($this->contentGenerationType !== null) {
            $data['contentGenerationType'] = $this->contentGenerationType;
        }

        if ($this->campaignData !== null && !empty($this->campaignData)) {
            $data['campaignData'] = $this->campaignData;
        }

        if ($this->issue !== null && !$this->issue->isEmpty()) {
            $data['issue'] = $this->issue->jsonSerialize();
        }

        return $data;
    }
}
