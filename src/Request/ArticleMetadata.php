<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Request;

use TomGould\AppleNews\Enum\MaturityRating;
use JsonSerializable;

/**
 * Builder for API-level metadata sent with Create and Update Article requests.
 *
 * This class handles metadata fields that control how Apple News processes and
 * displays your article. It is separate from the ANF Metadata class which handles
 * document-level metadata like authors and publication dates.
 *
 * Usage:
 * ```php
 * $metadata = (new ArticleMetadata())
 *     ->setIsSponsored(true)
 *     ->setMaturityRating(MaturityRating::GENERAL)
 *     ->addSection('https://news-api.apple.com/sections/123');
 *
 * $client->createArticle($channelId, $article, $metadata->toArray());
 * ```
 *
 * @see https://developer.apple.com/documentation/applenewsapi/create_an_article
 * @see https://developer.apple.com/documentation/applenewsapi/update_an_article
 */
final class ArticleMetadata implements JsonSerializable
{
    /**
     * Whether the article contains sponsored content.
     *
     * Required by Apple policy for sponsored/paid content.
     */
    private ?bool $isSponsored = null;

    /**
     * Whether the article should be considered for featuring in Apple News.
     */
    private ?bool $isCandidateToBeFeatured = null;

    /**
     * Whether the article is in preview mode (not publicly visible).
     */
    private ?bool $isPreview = null;

    /**
     * Whether the article is temporarily hidden from the News feed.
     *
     * Note: This field is only applicable for Update Article requests.
     */
    private ?bool $isHidden = null;

    /**
     * Content maturity rating for the article.
     */
    private ?MaturityRating $maturityRating = null;

    /**
     * ISO 3166-1 alpha-2 country codes for content targeting.
     *
     * @var list<string>
     */
    private array $targetTerritoryCountryCodes = [];

    /**
     * Section URLs to assign the article to.
     *
     * @var list<string>
     */
    private array $sections = [];

    /**
     * Mark the article as sponsored content.
     *
     * Apple requires this to be set to true for any paid or sponsored content.
     * Failure to properly disclose sponsored content may result in channel removal.
     *
     * @param bool $isSponsored Whether the article is sponsored.
     *
     * @return $this
     */
    public function setIsSponsored(bool $isSponsored): self
    {
        $this->isSponsored = $isSponsored;
        return $this;
    }

    /**
     * Set whether the article should be considered for featuring.
     *
     * When true, the article may be selected by Apple News editors for
     * prominent placement. Not all articles marked as candidates will be featured.
     *
     * @param bool $isCandidateToBeFeatured Whether the article can be featured.
     *
     * @return $this
     */
    public function setIsCandidateToBeFeatured(bool $isCandidateToBeFeatured): self
    {
        $this->isCandidateToBeFeatured = $isCandidateToBeFeatured;
        return $this;
    }

    /**
     * Set whether the article is in preview mode.
     *
     * Preview articles are only visible to channel members and are not
     * published to the public Apple News feed.
     *
     * @param bool $isPreview Whether the article is a preview.
     *
     * @return $this
     */
    public function setIsPreview(bool $isPreview): self
    {
        $this->isPreview = $isPreview;
        return $this;
    }

    /**
     * Set whether the article is hidden from the News feed.
     *
     * Hidden articles remain accessible via direct link but do not appear
     * in channel feeds or search results. This is only applicable for
     * Update Article requests.
     *
     * @param bool $isHidden Whether the article is hidden.
     *
     * @return $this
     */
    public function setIsHidden(bool $isHidden): self
    {
        $this->isHidden = $isHidden;
        return $this;
    }

    /**
     * Set the content maturity rating.
     *
     * The maturity rating helps Apple News determine the appropriate
     * audience for your content.
     *
     * @param MaturityRating $maturityRating The content rating.
     *
     * @return $this
     */
    public function setMaturityRating(MaturityRating $maturityRating): self
    {
        $this->maturityRating = $maturityRating;
        return $this;
    }

    /**
     * Add a target territory country code.
     *
     * Use ISO 3166-1 alpha-2 country codes (e.g., 'US', 'GB', 'CA').
     * When set, the article will only be visible to users in the specified countries.
     *
     * @param string $countryCode ISO 3166-1 alpha-2 country code.
     *
     * @return $this
     */
    public function addTargetTerritory(string $countryCode): self
    {
        $normalized = strtoupper(trim($countryCode));
        if (!in_array($normalized, $this->targetTerritoryCountryCodes, true)) {
            $this->targetTerritoryCountryCodes[] = $normalized;
        }
        return $this;
    }

    /**
     * Add multiple target territory country codes.
     *
     * @param list<string> $countryCodes Array of ISO 3166-1 alpha-2 country codes.
     *
     * @return $this
     */
    public function addTargetTerritories(array $countryCodes): self
    {
        foreach ($countryCodes as $code) {
            $this->addTargetTerritory($code);
        }
        return $this;
    }

    /**
     * Set all target territory country codes, replacing any existing values.
     *
     * @param list<string> $countryCodes Array of ISO 3166-1 alpha-2 country codes.
     *
     * @return $this
     */
    public function setTargetTerritories(array $countryCodes): self
    {
        $this->targetTerritoryCountryCodes = [];
        return $this->addTargetTerritories($countryCodes);
    }

    /**
     * Add a section URL to assign the article to.
     *
     * Articles can belong to multiple sections. Use the full API URL
     * format: https://news-api.apple.com/sections/{sectionId}
     *
     * @param string $sectionUrl The full section API URL.
     *
     * @return $this
     */
    public function addSection(string $sectionUrl): self
    {
        if (!in_array($sectionUrl, $this->sections, true)) {
            $this->sections[] = $sectionUrl;
        }
        return $this;
    }

    /**
     * Add a section by ID (convenience method).
     *
     * This method constructs the full API URL from the section ID.
     *
     * @param string $sectionId The section identifier.
     * @param string $apiBase   The API base URL. Defaults to production.
     *
     * @return $this
     */
    public function addSectionById(string $sectionId, string $apiBase = 'https://news-api.apple.com'): self
    {
        return $this->addSection(rtrim($apiBase, '/') . '/sections/' . $sectionId);
    }

    /**
     * Add multiple section URLs.
     *
     * @param list<string> $sectionUrls Array of section API URLs.
     *
     * @return $this
     */
    public function addSections(array $sectionUrls): self
    {
        foreach ($sectionUrls as $url) {
            $this->addSection($url);
        }
        return $this;
    }

    /**
     * Set all section URLs, replacing any existing values.
     *
     * @param list<string> $sectionUrls Array of section API URLs.
     *
     * @return $this
     */
    public function setSections(array $sectionUrls): self
    {
        $this->sections = [];
        return $this->addSections($sectionUrls);
    }

    /**
     * Convert the metadata to an array suitable for the API request.
     *
     * Only non-null values are included in the output.
     *
     * @return array<string, mixed> The metadata array for the API request.
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->isSponsored !== null) {
            $data['isSponsored'] = $this->isSponsored;
        }

        if ($this->isCandidateToBeFeatured !== null) {
            $data['isCandidateToBeFeatured'] = $this->isCandidateToBeFeatured;
        }

        if ($this->isPreview !== null) {
            $data['isPreview'] = $this->isPreview;
        }

        if ($this->isHidden !== null) {
            $data['isHidden'] = $this->isHidden;
        }

        if ($this->maturityRating !== null) {
            $data['maturityRating'] = $this->maturityRating->value;
        }

        if (!empty($this->targetTerritoryCountryCodes)) {
            $data['targetTerritoryCountryCodes'] = $this->targetTerritoryCountryCodes;
        }

        if (!empty($this->sections)) {
            $data['links'] = ['sections' => $this->sections];
        }

        return $data;
    }

    /**
     * Check if any metadata has been set.
     *
     * @return bool True if at least one metadata field has been set.
     */
    public function isEmpty(): bool
    {
        return empty($this->toArray());
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}

