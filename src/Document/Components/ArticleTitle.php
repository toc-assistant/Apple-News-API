<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document\Components;

/**
 * Article title component with enhanced formatting options.
 *
 * The article_title component is similar to the title component but offers
 * additional formatting options and is specifically designed for the main
 * article title that appears in feeds.
 *
 * @see https://developer.apple.com/documentation/applenewsformat/articletitle
 */
final class ArticleTitle extends TextComponent
{
    /**
     * {@inheritdoc}
     */
    public function getRole(): string
    {
        return 'article_title';
    }
}
