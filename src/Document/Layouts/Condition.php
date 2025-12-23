<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Layouts;

use JsonSerializable;

/**
 * Condition object for conditional component properties.
 *
 * Conditions allow components to have different properties based on
 * device characteristics like screen size, orientation, or platform.
 *
 * @see https://developer.apple.com/documentation/apple_news/condition
 */
final class Condition implements JsonSerializable
{
    /**
     * Valid platform values.
     */
    public const PLATFORM_ANY = 'any';
    public const PLATFORM_IOS = 'ios';
    public const PLATFORM_MACOS = 'macos';

    /**
     * Valid size class values.
     */
    public const SIZE_CLASS_ANY = 'any';
    public const SIZE_CLASS_COMPACT = 'compact';
    public const SIZE_CLASS_REGULAR = 'regular';

    /**
     * Valid subscription status values.
     */
    public const SUBSCRIPTION_BUNDLE = 'bundle';
    public const SUBSCRIPTION_SUBSCRIBED = 'subscribed';

    /**
     * Valid view location values.
     */
    public const VIEW_ARTICLE = 'article';
    public const VIEW_ISSUE_TABLE_OF_CONTENTS = 'issue_table_of_contents';
    public const VIEW_ISSUE = 'issue';

    /**
     * Valid preferred color scheme values.
     */
    public const COLOR_SCHEME_ANY = 'any';
    public const COLOR_SCHEME_LIGHT = 'light';
    public const COLOR_SCHEME_DARK = 'dark';

    /**
     * The platform to match.
     */
    private ?string $platform = null;

    /**
     * The maximum number of columns.
     */
    private ?int $maxColumns = null;

    /**
     * The minimum number of columns.
     */
    private ?int $minColumns = null;

    /**
     * The maximum content size category.
     */
    private ?string $maxContentSizeCategory = null;

    /**
     * The minimum content size category.
     */
    private ?string $minContentSizeCategory = null;

    /**
     * The maximum viewport aspect ratio.
     */
    private ?float $maxViewportAspectRatio = null;

    /**
     * The minimum viewport aspect ratio.
     */
    private ?float $minViewportAspectRatio = null;

    /**
     * The maximum viewport width in points.
     */
    private ?int $maxViewportWidth = null;

    /**
     * The minimum viewport width in points.
     */
    private ?int $minViewportWidth = null;

    /**
     * The maximum specified width.
     */
    private ?int $maxSpecifiedWidth = null;

    /**
     * The minimum specified width.
     */
    private ?int $minSpecifiedWidth = null;

    /**
     * The horizontal size class.
     */
    private ?string $horizontalSizeClass = null;

    /**
     * The vertical size class.
     */
    private ?string $verticalSizeClass = null;

    /**
     * The subscription status.
     *
     * @var list<string>|null
     */
    private ?array $subscriptionStatus = null;

    /**
     * The view location.
     */
    private ?string $viewLocation = null;

    /**
     * The preferred color scheme.
     */
    private ?string $preferredColorScheme = null;

    /**
     * Set the platform.
     *
     * @param string $platform One of 'any', 'ios', 'macos'.
     *
     * @return $this
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * Set the maximum columns.
     *
     * @param int $columns Maximum column count.
     *
     * @return $this
     */
    public function setMaxColumns(int $columns): self
    {
        $this->maxColumns = $columns;
        return $this;
    }

    /**
     * Set the minimum columns.
     *
     * @param int $columns Minimum column count.
     *
     * @return $this
     */
    public function setMinColumns(int $columns): self
    {
        $this->minColumns = $columns;
        return $this;
    }

    /**
     * Set the maximum viewport width.
     *
     * @param int $width Maximum width in points.
     *
     * @return $this
     */
    public function setMaxViewportWidth(int $width): self
    {
        $this->maxViewportWidth = $width;
        return $this;
    }

    /**
     * Set the minimum viewport width.
     *
     * @param int $width Minimum width in points.
     *
     * @return $this
     */
    public function setMinViewportWidth(int $width): self
    {
        $this->minViewportWidth = $width;
        return $this;
    }

    /**
     * Set the maximum viewport aspect ratio.
     *
     * @param float $ratio Maximum aspect ratio (width/height).
     *
     * @return $this
     */
    public function setMaxViewportAspectRatio(float $ratio): self
    {
        $this->maxViewportAspectRatio = $ratio;
        return $this;
    }

    /**
     * Set the minimum viewport aspect ratio.
     *
     * @param float $ratio Minimum aspect ratio (width/height).
     *
     * @return $this
     */
    public function setMinViewportAspectRatio(float $ratio): self
    {
        $this->minViewportAspectRatio = $ratio;
        return $this;
    }

    /**
     * Set the maximum specified width.
     *
     * @param int $width Maximum width.
     *
     * @return $this
     */
    public function setMaxSpecifiedWidth(int $width): self
    {
        $this->maxSpecifiedWidth = $width;
        return $this;
    }

    /**
     * Set the minimum specified width.
     *
     * @param int $width Minimum width.
     *
     * @return $this
     */
    public function setMinSpecifiedWidth(int $width): self
    {
        $this->minSpecifiedWidth = $width;
        return $this;
    }

    /**
     * Set the horizontal size class.
     *
     * @param string $sizeClass One of 'any', 'compact', 'regular'.
     *
     * @return $this
     */
    public function setHorizontalSizeClass(string $sizeClass): self
    {
        $this->horizontalSizeClass = $sizeClass;
        return $this;
    }

    /**
     * Set the vertical size class.
     *
     * @param string $sizeClass One of 'any', 'compact', 'regular'.
     *
     * @return $this
     */
    public function setVerticalSizeClass(string $sizeClass): self
    {
        $this->verticalSizeClass = $sizeClass;
        return $this;
    }

    /**
     * Set the maximum content size category.
     *
     * @param string $category The content size category.
     *
     * @return $this
     */
    public function setMaxContentSizeCategory(string $category): self
    {
        $this->maxContentSizeCategory = $category;
        return $this;
    }

    /**
     * Set the minimum content size category.
     *
     * @param string $category The content size category.
     *
     * @return $this
     */
    public function setMinContentSizeCategory(string $category): self
    {
        $this->minContentSizeCategory = $category;
        return $this;
    }

    /**
     * Set the subscription status.
     *
     * @param list<string> $status Array of subscription statuses.
     *
     * @return $this
     */
    public function setSubscriptionStatus(array $status): self
    {
        $this->subscriptionStatus = $status;
        return $this;
    }

    /**
     * Set the view location.
     *
     * @param string $location One of 'article', 'issue_table_of_contents', 'issue'.
     *
     * @return $this
     */
    public function setViewLocation(string $location): self
    {
        $this->viewLocation = $location;
        return $this;
    }

    /**
     * Set the preferred color scheme.
     *
     * @param string $scheme One of 'any', 'light', 'dark'.
     *
     * @return $this
     */
    public function setPreferredColorScheme(string $scheme): self
    {
        $this->preferredColorScheme = $scheme;
        return $this;
    }

    /**
     * Create a condition for iOS platform only.
     *
     * @return self A new Condition instance.
     */
    public static function iOS(): self
    {
        return (new self())->setPlatform(self::PLATFORM_IOS);
    }

    /**
     * Create a condition for macOS platform only.
     *
     * @return self A new Condition instance.
     */
    public static function macOS(): self
    {
        return (new self())->setPlatform(self::PLATFORM_MACOS);
    }

    /**
     * Create a condition for compact horizontal size class.
     *
     * @return self A new Condition instance.
     */
    public static function compactWidth(): self
    {
        return (new self())->setHorizontalSizeClass(self::SIZE_CLASS_COMPACT);
    }

    /**
     * Create a condition for regular horizontal size class.
     *
     * @return self A new Condition instance.
     */
    public static function regularWidth(): self
    {
        return (new self())->setHorizontalSizeClass(self::SIZE_CLASS_REGULAR);
    }

    /**
     * Create a condition for dark mode.
     *
     * @return self A new Condition instance.
     */
    public static function darkMode(): self
    {
        return (new self())->setPreferredColorScheme(self::COLOR_SCHEME_DARK);
    }

    /**
     * Create a condition for light mode.
     *
     * @return self A new Condition instance.
     */
    public static function lightMode(): self
    {
        return (new self())->setPreferredColorScheme(self::COLOR_SCHEME_LIGHT);
    }

    /**
     * Create a condition for a viewport width range.
     *
     * @param int|null $min Minimum width in points.
     * @param int|null $max Maximum width in points.
     *
     * @return self A new Condition instance.
     */
    public static function viewportWidth(?int $min = null, ?int $max = null): self
    {
        $condition = new self();

        if ($min !== null) {
            $condition->setMinViewportWidth($min);
        }

        if ($max !== null) {
            $condition->setMaxViewportWidth($max);
        }

        return $condition;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->platform !== null) {
            $data['platform'] = $this->platform;
        }

        if ($this->maxColumns !== null) {
            $data['maxColumns'] = $this->maxColumns;
        }

        if ($this->minColumns !== null) {
            $data['minColumns'] = $this->minColumns;
        }

        if ($this->maxContentSizeCategory !== null) {
            $data['maxContentSizeCategory'] = $this->maxContentSizeCategory;
        }

        if ($this->minContentSizeCategory !== null) {
            $data['minContentSizeCategory'] = $this->minContentSizeCategory;
        }

        if ($this->maxViewportAspectRatio !== null) {
            $data['maxViewportAspectRatio'] = $this->maxViewportAspectRatio;
        }

        if ($this->minViewportAspectRatio !== null) {
            $data['minViewportAspectRatio'] = $this->minViewportAspectRatio;
        }

        if ($this->maxViewportWidth !== null) {
            $data['maxViewportWidth'] = $this->maxViewportWidth;
        }

        if ($this->minViewportWidth !== null) {
            $data['minViewportWidth'] = $this->minViewportWidth;
        }

        if ($this->maxSpecifiedWidth !== null) {
            $data['maxSpecifiedWidth'] = $this->maxSpecifiedWidth;
        }

        if ($this->minSpecifiedWidth !== null) {
            $data['minSpecifiedWidth'] = $this->minSpecifiedWidth;
        }

        if ($this->horizontalSizeClass !== null) {
            $data['horizontalSizeClass'] = $this->horizontalSizeClass;
        }

        if ($this->verticalSizeClass !== null) {
            $data['verticalSizeClass'] = $this->verticalSizeClass;
        }

        if ($this->subscriptionStatus !== null) {
            $data['subscriptionStatus'] = $this->subscriptionStatus;
        }

        if ($this->viewLocation !== null) {
            $data['viewLocation'] = $this->viewLocation;
        }

        if ($this->preferredColorScheme !== null) {
            $data['preferredColorScheme'] = $this->preferredColorScheme;
        }

        return $data;
    }
}

