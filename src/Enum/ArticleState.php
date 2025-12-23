<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Enum;

/**
 * Article processing states returned by the Apple News API.
 *
 * Represents the current state of an article in the Apple News publishing pipeline.
 * Use the helper methods to check common state conditions.
 *
 * @see https://developer.apple.com/documentation/applenewsapi/article
 */
enum ArticleState: string
{
    /** The article has been published and is processing. */
    case PROCESSING = 'PROCESSING';

    /** The article has been published, has finished processing, and is visible in the News app. */
    case LIVE = 'LIVE';

    /** A previous version of the article is visible in the News app, and an update is currently in processing. */
    case PROCESSING_UPDATE = 'PROCESSING_UPDATE';

    /** The article was previously visible in the News app, but was taken down. */
    case TAKEN_DOWN = 'TAKEN_DOWN';

    /** The article failed during processing and isn't visible in the News app. */
    case FAILED_PROCESSING = 'FAILED_PROCESSING';

    /** A previous version of the article is visible in the News app, but an update failed during processing. */
    case FAILED_PROCESSING_UPDATE = 'FAILED_PROCESSING_UPDATE';

    /** The article is a duplicate of another article and isn't visible in the News app. */
    case DUPLICATE = 'DUPLICATE';

    /**
     * Check if the article is currently visible in the News app.
     *
     * Returns true for LIVE and PROCESSING_UPDATE states, as both indicate
     * that some version of the article is publicly accessible.
     *
     * @return bool True if the article is visible to users.
     */
    public function isLive(): bool
    {
        return $this === self::LIVE || $this === self::PROCESSING_UPDATE;
    }

    /**
     * Check if the article is currently being processed.
     *
     * Returns true for PROCESSING and PROCESSING_UPDATE states.
     *
     * @return bool True if the article is in a processing state.
     */
    public function isProcessing(): bool
    {
        return $this === self::PROCESSING || $this === self::PROCESSING_UPDATE;
    }

    /**
     * Check if the article processing has failed.
     *
     * Returns true for FAILED_PROCESSING and FAILED_PROCESSING_UPDATE states.
     *
     * @return bool True if the article failed to process.
     */
    public function hasFailed(): bool
    {
        return $this === self::FAILED_PROCESSING || $this === self::FAILED_PROCESSING_UPDATE;
    }
}

