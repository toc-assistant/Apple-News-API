# Apple News API Cookbook

Advanced patterns, real-world recipes, and production-ready examples for the Apple News API PHP client.

---

## Table of Contents

1. [Complete Article Examples](#complete-article-examples)
2. [Component Reference](#component-reference)
3. [Layouts & Containers](#layouts--containers)
4. [Styling & Themes](#styling--themes)
5. [Dark Mode Support](#dark-mode-support)
6. [Background Fills](#background-fills)
7. [Animations & Behaviors](#animations--behaviors)
8. [Advertising Integration](#advertising-integration)
9. [API Operations](#api-operations)
10. [Production Patterns](#production-patterns)
11. [Common Pitfalls](#common-pitfalls)
12. [Debugging & Validation](#debugging--validation)

---

## Complete Article Examples

### Basic News Article

```php
<?php

use TomGould\AppleNews\Client\AppleNewsClient;
use TomGould\AppleNews\Document\Article;
use TomGould\AppleNews\Document\Metadata;
use TomGould\AppleNews\Document\Components\{Title, Body, Photo, Byline, Heading, Divider};
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

// 1. Create client
$factory = new HttpFactory();
$client = AppleNewsClient::create(
    keyId: $_ENV['APPLE_NEWS_KEY_ID'],
    keySecret: $_ENV['APPLE_NEWS_KEY_SECRET'],
    httpClient: new Client(['timeout' => 30]),
    requestFactory: $factory,
    streamFactory: $factory
);

// 2. Build article with standard 7-column layout
$article = Article::create(
    identifier: 'article-' . uniqid(),
    title: 'Breaking: Major Discovery Announced',
    language: 'en',
    columns: 7,
    width: 1024
);

// 3. Define reusable text styles
$bodyStyle = (new ComponentTextStyle())
    ->setFontName('Georgia')
    ->setFontSize(18)
    ->setLineHeight(28)
    ->setTextColor('#1a1a1a');

$headingStyle = (new ComponentTextStyle())
    ->setFontName('HelveticaNeue-Bold')
    ->setFontSize(32)
    ->setLineHeight(38)
    ->setTextColor('#000000');

$article->addComponentTextStyle('body-default', $bodyStyle);
$article->addComponentTextStyle('heading-default', $headingStyle);

// 4. Set metadata (required for proper indexing)
$article->setMetadata(
    (new Metadata())
        ->addAuthor('Jane Smith')
        ->addAuthor('John Doe')
        ->setExcerpt('Scientists announce a groundbreaking discovery.')
        ->setDatePublished(new DateTime())
        ->setDateCreated(new DateTime('-1 hour'))
        ->setCanonicalURL('https://example.com/articles/major-discovery')
        ->addKeywords(['science', 'discovery', 'breaking news'])
        ->setThumbnailURL('https://example.com/images/hero-thumb.jpg')
        ->setGeneratorName('MyPublisher')
        ->setGeneratorVersion('2.0')
        ->setContentGenerationType('none')
);

// 5. Build article content
$article->addComponent(new Title('Breaking: Major Discovery Announced'));

$article->addComponent(
    Photo::fromUrl('https://example.com/images/hero.jpg')
        ->setCaption('Scientists at the research facility')
        ->setAccessibilityCaption('Group of scientists examining equipment')
);

$article->addComponent(new Byline('By Jane Smith and John Doe | ' . date('F j, Y')));
$article->addComponent(new Divider());

$article->addComponent(
    (new Body('In a stunning announcement today, researchers revealed findings that could revolutionize our understanding.'))
        ->setTextStyle('body-default')
);

$article->addComponent(
    (new Heading('The Discovery', level: 2))
        ->setTextStyle('heading-default')
);

$article->addComponent(
    (new Body('<p>The team spent over <strong>three years</strong> conducting experiments.</p>'))
        ->setTextStyle('body-default')
        ->setFormat('html')
);

// 6. Publish
$response = $client->createArticle($_ENV['CHANNEL_ID'], $article);
echo "Published: " . $response['data']['id'] . "\n";
echo "Share URL: " . $response['data']['shareUrl'] . "\n";
```

### Photo Gallery Article

```php
use TomGould\AppleNews\Document\Components\{Gallery, Figure, Container};
use TomGould\AppleNews\Document\Layouts\CollectionDisplay;
use TomGould\AppleNews\Document\Animations\FadeInAnimation;

$article = Article::create('gallery-' . uniqid(), 'Summer Photo Collection', 'en');

$article->addComponent(new Title('Summer Photo Collection'));
$article->addComponent(new Body('A visual journey through the best moments of summer.'));

// Method 1: Built-in Gallery component (horizontal scroll)
$gallery = new Gallery();
$gallery
    ->addItem(
        (new Figure())
            ->setUrl('https://example.com/summer/beach.jpg')
            ->setCaption('Golden hour at the beach')
            ->setAccessibilityCaption('Sun setting over calm ocean waves')
    )
    ->addItem(
        (new Figure())
            ->setUrl('https://example.com/summer/mountains.jpg')
            ->setCaption('Alpine meadows in bloom')
    );

$article->addComponent($gallery);

// Method 2: Grid layout using Container (responsive)
$gridGallery = new Container();
$gridGallery->setContentDisplayObject(
    CollectionDisplay::grid(gutter: 10, minimumWidth: 200)
);

$images = [
    ['url' => 'https://example.com/img1.jpg', 'caption' => 'Image 1'],
    ['url' => 'https://example.com/img2.jpg', 'caption' => 'Image 2'],
    ['url' => 'https://example.com/img3.jpg', 'caption' => 'Image 3'],
];

foreach ($images as $index => $img) {
    $photo = Photo::fromUrl($img['url'])
        ->setCaption($img['caption'])
        ->setAnimationObject(FadeInAnimation::withDelay($index * 0.1));
    $gridGallery->addComponent($photo);
}

$article->addComponent($gridGallery);
```

### Social Media Embed Article

```php
use TomGould\AppleNews\Document\Components\{
    Tweet, Instagram, FacebookPost, EmbedWebVideo, TikTok
};

$article = Article::create('social-roundup-' . date('Ymd'), 'What\'s Trending', 'en');

$article->addComponent(new Title('What\'s Trending Today'));

// Twitter/X embed
$article->addComponent(new Heading('From Twitter', level: 2));
$article->addComponent(new Tweet('https://twitter.com/NASA/status/1234567890'));

// Instagram embed
$article->addComponent(new Heading('On Instagram', level: 2));
$article->addComponent(new Instagram('https://www.instagram.com/p/ABC123xyz/'));

// YouTube video
$article->addComponent(new Heading('Must-Watch Video', level: 2));
$article->addComponent(
    (new EmbedWebVideo('https://www.youtube.com/watch?v=dQw4w9WgXcQ'))
        ->setCaption('The video everyone is talking about')
);

// TikTok embed
$article->addComponent(new TikTok('https://www.tiktok.com/@user/video/1234567890'));

// Facebook post
$article->addComponent(new FacebookPost('https://www.facebook.com/NASA/posts/123'));
```

### Long-Form Feature with Immersive Header

```php
use TomGould\AppleNews\Document\Components\{Header, Intro, Pullquote};
use TomGould\AppleNews\Document\Scenes\ParallaxScaleHeader;
use TomGould\AppleNews\Document\Styles\Fills\ImageFill;
use TomGould\AppleNews\Document\Styles\DocumentStyle;

$article = Article::create('feature-' . uniqid(), 'The Future of AI', 'en', columns: 12, width: 1280);

// Document-level styling
$docStyle = new DocumentStyle();
$docStyle->setBackgroundColor('#FFFFFF');
$article->setDocumentStyle($docStyle);

// Metadata with transparent toolbar for immersive effect
$article->setMetadata(
    (new Metadata())
        ->addAuthor('Tech Correspondent')
        ->setExcerpt('An in-depth look at artificial intelligence.')
        ->setDatePublished(new DateTime())
        ->setTransparentToolbar(true)
        ->setVideoURL('https://example.com/ai-preview.mp4')
);

// Immersive header with parallax effect
$header = new Header();
$header
    ->setScene(ParallaxScaleHeader::create())
    ->setStyle([
        'fill' => (new ImageFill('https://example.com/ai-hero.jpg'))
            ->asCover()
            ->setVerticalAlignment('center')
            ->jsonSerialize()
    ]);

$header->addComponent(
    (new Title('The Future of Artificial Intelligence'))
        ->setTextStyle([
            'textColor' => '#FFFFFF',
            'fontSize' => 48,
            'fontWeight' => 'bold',
            'textShadow' => [
                'radius' => 15,
                'opacity' => 0.6,
                'color' => '#000000'
            ]
        ])
);

$article->addComponent($header);

// Drop cap intro
$article->addComponent(
    (new Intro('The machines are learning fast. In laboratories around the world, AI systems are achieving feats that seemed like science fiction.'))
        ->setTextStyle([
            'dropCapStyle' => [
                'numberOfLines' => 4,
                'numberOfCharacters' => 1,
                'fontName' => 'Georgia-Bold',
                'textColor' => '#007AFF'
            ],
            'fontSize' => 20,
            'lineHeight' => 32
        ])
);

// Pull quote
$article->addComponent(
    (new Pullquote('"We\'re building new forms of intelligence."'))
        ->setTextStyle([
            'fontName' => 'Georgia-Italic',
            'fontSize' => 28,
            'textColor' => '#007AFF'
        ])
);
```

---

## Component Reference

### Text Components

| Component | Role | Key Properties |
|-----------|------|----------------|
| `Title` | title | text |
| `Heading` | heading1-6 | text, level (1-6) |
| `Body` | body | text, format (html/none) |
| `Intro` | intro | text, drop cap support |
| `Caption` | caption | text |
| `Pullquote` | pullquote | text |
| `Quote` | quote | text |
| `Byline` | byline | text |
| `Author` | author | text |
| `Photographer` | photographer | text |
| `Illustrator` | illustrator | text |

### Media Components

| Component | Factory Methods | Notes |
|-----------|-----------------|-------|
| `Photo` | `fromUrl()`, `fromBundle()` | Single image |
| `Image` | `fromUrl()`, `fromBundle()` | Generic image (alias) |
| `Figure` | `fromUrl()`, `fromBundle()` | Image with caption |
| `Portrait` | `fromUrl()`, `fromBundle()` | Portrait-oriented image |
| `Logo` | `fromUrl()`, `fromBundle()` | Publication logo |
| `Gallery` | `addItem()` | Horizontal image gallery |
| `Mosaic` | `addItem()` | Mosaic image layout |
| `Video` | `fromUrl()`, `fromBundle()` | Native video player |
| `Audio` | `fromUrl()`, `fromBundle()` | Audio player |
| `Music` | - | Apple Music integration |
| `Podcast` | - | Podcast episode embed |
| `ARKit` | `fromUrl()`, `fromBundle()` | AR Quick Look 3D models |

### Social Embeds

| Component | Constructor |
|-----------|-------------|
| `Tweet` | `new Tweet($url)` |
| `Instagram` | `new Instagram($url)` |
| `FacebookPost` | `new FacebookPost($url)` |
| `TikTok` | `new TikTok($url)` |
| `EmbedWebVideo` | `new EmbedWebVideo($url)` |

### Structure Components

| Component | Key Methods |
|-----------|-------------|
| `Container` | `addComponent()`, `setContentDisplay()` |
| `Section` | `addComponent()` |
| `Header` | `setScene()` |
| `Chapter` | - |
| `Aside` | - |
| `Divider` | - |
| `FlexibleSpacer` | - |

### Data & Interactive

| Component | Key Methods | Notes |
|-----------|-------------|-------|
| `DataTable` | `setData()`, `setSortBy()` | Interactive sortable table |
| `HTMLTable` | `fromHtml()` | HTML-based table |
| `Map` | constructor(lat, lng) | Interactive Apple Maps |
| `Place` | constructor(lat, lng, caption) | Location marker for Map |
| `LinkButton` | constructor(text, url) | Call-to-action button |
| `ArticleLink` | `fromArticleId()` | Link to another article |
| `BannerAdvertisement` | - | Banner ad slot |
| `MediumRectangleAdvertisement` | - | MREC ad slot (300x250) |
| `ReplicaAdvertisement` | - | Print replica ad slot |

---

## Layouts & Containers

### Horizontal Stack

```php
use TomGould\AppleNews\Document\Layouts\HorizontalStackDisplay;

$container = new Container();
$container->setContentDisplayObject(new HorizontalStackDisplay());

$container->addComponent(
    Photo::fromUrl('https://example.com/sidebar.jpg')
        ->setLayout(['minimumWidth' => '40cw'])
);

$container->addComponent(
    (new Body('Article content...'))
        ->setLayout(['minimumWidth' => '55cw'])
);

$article->addComponent($container);
```

### Grid Layout

```php
use TomGould\AppleNews\Document\Layouts\CollectionDisplay;

$grid = new Container();
$grid->setContentDisplayObject(
    CollectionDisplay::grid(gutter: 15, minimumWidth: 250)
);

for ($i = 0; $i < 6; $i++) {
    $grid->addComponent(createCard($i));
}

$article->addComponent($grid);
```

### Column-Based Layouts

```php
// Span specific columns (7-column layout)
$component->setLayout([
    'columnStart' => 1,
    'columnSpan' => 5,
]);

// Full-bleed (ignore margins)
$component->setLayout([
    'ignoreDocumentMargin' => true,
    'columnStart' => 0,
    'columnSpan' => 7,
]);

// With margins
$component->setLayout([
    'columnStart' => 1,
    'columnSpan' => 5,
    'margin' => ['top' => 20, 'bottom' => 20]
]);
```

---

## Styling & Themes

### Text Styles

```php
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;

$bodyStyle = (new ComponentTextStyle())
    ->setFontName('Georgia')
    ->setFontSize(18)
    ->setLineHeight(28)
    ->setTextColor('#333333')
    ->setFontWeight('regular')
    ->setFontStyle('normal')
    ->setTextAlignment('left')
    ->setTracking(0)
    ->setParagraphSpacingBefore(12)
    ->setParagraphSpacingAfter(12);

$article->addComponentTextStyle('body-style', $bodyStyle);
$body = (new Body('Text'))->setTextStyle('body-style');
```

### Drop Caps

```php
$introStyle = (new ComponentTextStyle())
    ->setFontName('Georgia')
    ->setFontSize(20)
    ->setDropCapStyle([
        'numberOfLines' => 3,
        'numberOfCharacters' => 1,
        'fontName' => 'Georgia-Bold',
        'textColor' => '#007AFF',
        'padding' => 5
    ]);
```

### Text Shadows

```php
$titleStyle = (new ComponentTextStyle())
    ->setFontName('HelveticaNeue-Bold')
    ->setFontSize(48)
    ->setTextColor('#FFFFFF')
    ->setTextShadow([
        'radius' => 10,
        'opacity' => 0.5,
        'color' => '#000000',
        'offset' => ['x' => 2, 'y' => 2]
    ]);
```

### Inline Text Styles

Apply different styles to portions of text within a component:

```php
// Define styles for different text ranges
$body = new Body('Welcome to our exclusive report on the latest developments.');

$body->setInlineTextStyles([
    [
        'rangeStart' => 0,
        'rangeLength' => 7,  // "Welcome"
        'textStyle' => 'bold-style'
    ],
    [
        'rangeStart' => 15,
        'rangeLength' => 9,  // "exclusive"
        'textStyle' => 'emphasis-style'
    ]
]);

// Register the styles first
$article->addComponentTextStyle('bold-style', 
    (new ComponentTextStyle())->setFontWeight('bold')
);
$article->addComponentTextStyle('emphasis-style',
    (new ComponentTextStyle())->setFontStyle('italic')->setTextColor('#007AFF')
);
```

---

## Dark Mode Support

### Conditional Text Styles

```php
$bodyStyle = (new ComponentTextStyle())
    ->setFontName('Georgia')
    ->setFontSize(18)
    ->setTextColor('#1C1C1E')
    ->setConditional([
        [
            'conditions' => [['preferredColorScheme' => 'dark']],
            'textColor' => '#F2F2F7'
        ]
    ]);
```

### Conditional Document Style

```php
use TomGould\AppleNews\Document\Styles\DocumentStyle;

$docStyle = new DocumentStyle();
$docStyle
    ->setBackgroundColor('#FFFFFF')
    ->addConditional([
        'conditions' => [['preferredColorScheme' => 'dark']],
        'backgroundColor' => '#000000'
    ]);

$article->setDocumentStyle($docStyle);
```

### Conditional Component Styles

```php
$container = new Container();
$container->setStyle([
    'backgroundColor' => '#F5F5F5',
    'conditional' => [
        [
            'conditions' => [['preferredColorScheme' => 'dark']],
            'backgroundColor' => '#1C1C1E'
        ]
    ]
]);
```

---

## Background Fills

### Image Fills

```php
use TomGould\AppleNews\Document\Styles\Fills\ImageFill;

$coverFill = (new ImageFill('https://example.com/bg.jpg'))
    ->asCover()
    ->setVerticalAlignment('center')
    ->setHorizontalAlignment('center');

$container = new Container();
$container->setStyle(['fill' => $coverFill->jsonSerialize()]);
```

### Gradient Fills

```php
use TomGould\AppleNews\Document\Styles\Fills\LinearGradientFill;

$gradient = LinearGradientFill::vertical('#000000', '#333333');
```

### Video Fills

```php
use TomGould\AppleNews\Document\Styles\Fills\VideoFill;

$videoFill = (new VideoFill('https://example.com/bg-video.mp4'))
    ->setLoop(true)
    ->setStillUrl('https://example.com/poster.jpg');
```

---

## Animations & Behaviors

### Animations

All animations from Apple News Format are supported:

```php
use TomGould\AppleNews\Document\Animations\*;

// Appear animation (generic)
$component->setAnimationObject(AppearAnimation::create());

// Fade in animation
$component->setAnimationObject(FadeInAnimation::standard());
$component->setAnimationObject(FadeInAnimation::fromTransparent());
$component->setAnimationObject(FadeInAnimation::withDelay(0.3));

// Move in animation
$component->setAnimationObject(MoveInAnimation::fromLeft());
$component->setAnimationObject(MoveInAnimation::fromRight());
$component->setAnimationObject(MoveInAnimation::fromBottom());

// Scale fade animation
$component->setAnimationObject(ScaleFadeAnimation::subtle());
```

### Behaviors

All behaviors from Apple News Format are supported:

```php
use TomGould\AppleNews\Document\Behaviors\*;

// Parallax scrolling
$photo->setBehaviorObject(Parallax::withFactor(0.5));  // 0-1 factor

// Background parallax (for fills)
$header->setBehaviorObject(BackgroundParallax::withFactor(0.8));

// Spring physics
$component->setBehaviorObject(Springy::create());

// Motion (gyroscope-based movement)
$component->setBehaviorObject(Motion::create());

// Background motion (gyroscope for backgrounds)
$component->setBehaviorObject(BackgroundMotion::create());
```

### Scenes (Header Effects)

```php
use TomGould\AppleNews\Document\Scenes\*;

$header->setScene(FadingStickyHeader::create());
$header->setScene(ParallaxScaleHeader::create());
```

---

## Advertising Integration

### Manual Ad Placement

```php
use TomGould\AppleNews\Document\Components\{
    BannerAdvertisement, MediumRectangleAdvertisement
};

$article->addComponent(new Title($title));
$article->addComponent(new Intro($intro));
$article->addComponent(new BannerAdvertisement());
$article->addComponent(new Body($content));
```

### Automatic Ad Placement

```php
use TomGould\AppleNews\Document\Layouts\AdvertisementAutoPlacement;

$autoPlacement = (new AdvertisementAutoPlacement())
    ->setEnabled(true)
    ->setBannerType('any')
    ->setDistanceFromMedia('10vh')
    ->setFrequency(5)
    ->setLayout(['margin' => ['top' => 20, 'bottom' => 20]]);

$article->setAutoplacement([
    'advertisement' => $autoPlacement->jsonSerialize()
]);
```

---

## Magazine/Periodical Metadata

For magazine and periodical publishers, use the `Issue` class to associate articles with specific issues:

```php
use TomGould\AppleNews\Document\Issue;

$article->setMetadata(
    (new Metadata())
        ->addAuthor('Editorial Team')
        ->setExcerpt('Cover story for our January issue')
        ->setDatePublished(new DateTime('2024-01-15'))
        ->setIssue(
            (new Issue())
                ->setIssueIdentifier('issue-2024-01')
                ->setIssueDate('2024-01-15')
                ->setIssueName('January 2024')
        )
);

// Or using array syntax
$article->setMetadata(
    (new Metadata())
        ->setIssueFromArray([
            'issueIdentifier' => 'issue-2024-01',
            'issueDate' => '2024-01-15',
            'issueName' => 'January 2024'
        ])
);
```

This enables:
- Issue-based navigation in Apple News
- Grouping of articles by issue
- Historical archive browsing

---

## API Operations

### Create Article with Assets

```php
use TomGould\AppleNews\Request\ArticleMetadata;
use TomGould\AppleNews\Enum\MaturityRating;

$article->addComponent(Photo::fromBundle('hero.jpg'));

$requestMeta = (new ArticleMetadata())
    ->setIsSponsored(false)
    ->setIsCandidateToBeFeatured(true)
    ->setMaturityRating(MaturityRating::GENERAL)
    ->addTargetTerritories(['US', 'GB', 'CA'])
    ->addSectionById('section-123');

$assets = [
    'bundle://hero.jpg' => '/path/to/hero.jpg',
];

$response = $client->createArticle($channelId, $article, $requestMeta->toArray(), $assets);
$articleId = $response['data']['id'];
$revision = $response['data']['revision'];
```

### Update Article

```php
// Always get fresh revision
$current = $client->getArticle($articleId);
$revision = $current['data']['revision'];
$client->updateArticle($articleId, $revision, $article);
```

### Search & Manage

```php
// Search
$results = $client->searchArticlesInChannel($channelId, ['pageSize' => 50]);

// Channel operations
$channel = $client->getChannel($channelId);
$quota = $client->getChannelQuota($channelId);
$sections = $client->listSections($channelId);
$client->promoteArticles($sectionId, [$articleId1, $articleId2]);

// Delete
$client->deleteArticle($articleId);
```

---

## Production Patterns

### CMS Integration

```php
class AppleNewsPublisher
{
    public function publishFromCMS(CMSArticle $cmsArticle): string
    {
        $article = Article::create(
            identifier: 'cms-' . $cmsArticle->getId(),
            title: $cmsArticle->getTitle(),
            language: $cmsArticle->getLocale()
        );
        
        $metadata = new Metadata();
        $metadata
            ->setDatePublished($cmsArticle->getPublishedAt())
            ->setCanonicalURL($cmsArticle->getUrl())
            ->setExcerpt($cmsArticle->getExcerpt());
        
        foreach ($cmsArticle->getAuthors() as $author) {
            $metadata->addAuthor($author->getName());
        }
        
        $article->setMetadata($metadata);
        
        foreach ($cmsArticle->getBlocks() as $block) {
            $article->addComponent($this->convertBlock($block));
        }
        
        $response = $this->client->createArticle($this->channelId, $article);
        return $response['data']['id'];
    }
}
```

### Error Handling with Retry

```php
function publishWithRetry(AppleNewsClient $client, string $channelId, Article $article, int $maxRetries = 3): array
{
    for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
        try {
            return $client->createArticle($channelId, $article);
        } catch (AuthenticationException $e) {
            throw $e; // Don't retry auth errors
        } catch (AppleNewsException $e) {
            if ($e->getCode() === 429) {
                sleep(pow(2, $attempt));
                continue;
            }
            if ($e->getCode() >= 500) {
                sleep(1);
                continue;
            }
            throw $e;
        }
    }
    throw new Exception("Max retries exceeded");
}
```

### Validation Before Publish

```php
function validateArticle(Article $article): array
{
    $errors = [];
    $json = $article->jsonSerialize();
    
    if (empty($json['identifier'])) {
        $errors[] = 'Missing identifier';
    }
    if (!preg_match('/^[a-zA-Z0-9_-]+$/', $json['identifier'] ?? '')) {
        $errors[] = 'Invalid identifier format';
    }
    if (empty($json['title'])) {
        $errors[] = 'Missing title';
    }
    if (empty($json['components'])) {
        $errors[] = 'No components';
    }
    
    return $errors;
}
```

---

## Common Pitfalls

### ❌ Invalid Identifier

```php
// WRONG
Article::create('My Article #1', 'Title');

// CORRECT
Article::create('my-article-1', 'Title');
```

### ❌ Missing Revision on Update

```php
// WRONG
$client->updateArticle($articleId, null, $article);

// CORRECT
$current = $client->getArticle($articleId);
$client->updateArticle($articleId, $current['data']['revision'], $article);
```

### ❌ HTML Without Format

```php
// WRONG - renders as literal text
$body = new Body('<p><strong>Bold</strong></p>');

// CORRECT
$body = (new Body('<p><strong>Bold</strong></p>'))->setFormat('html');
```

### ❌ Local Path as URL

```php
// WRONG
Photo::fromUrl('/var/www/images/hero.jpg');

// CORRECT
Photo::fromBundle('hero.jpg');
// + provide mapping: ['bundle://hero.jpg' => '/var/www/images/hero.jpg']
```

### ❌ Missing Accessibility

```php
// WRONG
Photo::fromUrl('https://example.com/chart.jpg');

// CORRECT
Photo::fromUrl('https://example.com/chart.jpg')
    ->setAccessibilityCaption('Bar chart showing quarterly revenue growth');
```

---

## Debugging & Validation

### Export JSON

```php
$json = json_encode($article, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents('debug-article.json', $json);
```

### Detailed Error Logging

```php
try {
    $response = $client->createArticle($channelId, $article);
} catch (AppleNewsException $e) {
    $log = [
        'message' => $e->getMessage(),
        'errorCode' => $e->getErrorCode(),
        'keyPath' => $e->getKeyPath(),
    ];
    file_put_contents('error.log', print_r($log, true));
    throw $e;
}
```

---

## Additional Resources

- [Apple News Format Documentation](https://developer.apple.com/documentation/apple_news/apple_news_format)
- [Apple News API Documentation](https://developer.apple.com/documentation/apple_news_api)
- [News Publisher User Guide](https://support.apple.com/guide/news-publisher/welcome/web)

---

*Last updated: 2026-02-07*
