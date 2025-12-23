<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Enum;

/**
 * Content maturity rating for Apple News articles.
 *
 * This rating helps Apple News determine the appropriate audience for your content
 * and affects whether the article appears in certain contexts (e.g., Kids mode).
 *
 * @see https://developer.apple.com/documentation/applenewsapi/create_an_article
 */
enum MaturityRating: string
{
    /**
     * Content suitable for children.
     *
     * Use this for content specifically designed for or appropriate for young audiences.
     */
    case KIDS = 'KIDS';

    /**
     * Content suitable for general audiences.
     *
     * This is the default rating and appropriate for most news content.
     */
    case GENERAL = 'GENERAL';

    /**
     * Content intended for mature audiences only.
     *
     * Use this for content containing adult themes, graphic content,
     * or material not suitable for younger readers.
     */
    case MATURE = 'MATURE';
}

