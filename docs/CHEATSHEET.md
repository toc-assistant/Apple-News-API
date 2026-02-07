# Apple News API Quick Reference

One-page reference for common operations.

---

## Client Setup

```php
use TomGould\AppleNews\Client\AppleNewsClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$factory = new HttpFactory();
$client = AppleNewsClient::create(
    keyId: 'YOUR_KEY_ID',
    keySecret: 'YOUR_BASE64_SECRET',
    httpClient: new Client(['timeout' => 30]),
    requestFactory: $factory,
    streamFactory: $factory
);
```

---

## Article Creation

```php
use TomGould\AppleNews\Document\Article;
use TomGould\AppleNews\Document\Metadata;

$article = Article::create(
    identifier: 'unique-id-123',  // URL-safe characters only
    title: 'Article Title',
    language: 'en',
    columns: 7,      // Default: 7
    width: 1024      // Default: 1024
);

$article->setMetadata(
    (new Metadata())
        ->addAuthor('Author Name')
        ->setExcerpt('Short summary for discovery')
        ->setDatePublished(new DateTime())
        ->setDateModified(new DateTime())
        ->setCanonicalURL('https://example.com/article')
        ->addKeywords(['tag1', 'tag2'])
        ->setThumbnailURL('https://example.com/thumb.jpg')
        ->setContentGenerationType('none')  // 'none' or 'AI'
        ->setTransparentToolbar(true)       // For immersive headers
        ->setIssueFromArray([               // For magazines/periodicals
            'issueIdentifier' => 'issue-2024-01',
            'issueDate' => '2024-01-15',
            'issueName' => 'January 2024'
        ])
);
```

---

## Components

### Text

```php
new Title('Title');
new Heading('Heading', level: 2);          // 1-6
new Body('Text');
(new Body('<p>HTML</p>'))->setFormat('html');
new Intro('Lead paragraph');
new Caption('Caption text');
new Pullquote('Quote text');
new Quote('Block quote');
new Byline('By Author | Date');
new Author('Name');
new Photographer('Name');
new Illustrator('Name');
```

### Media

```php
Photo::fromUrl('https://...');
Photo::fromBundle('image.jpg');
Photo::fromUrl('...')->setCaption('...')->setAccessibilityCaption('...');

Image::fromUrl('https://...');        // Generic image
(new Figure())->setUrl('...')->setCaption('...');
Portrait::fromUrl('https://...');     // Portrait orientation
Logo::fromUrl('https://...');         // Publication logo
(new Video())->setUrl('...');
(new Audio())->setUrl('...');
(new Gallery())->addItem($figure1)->addItem($figure2);
(new Mosaic())->addItem($figure1);    // Mosaic layout
new Music();                          // Apple Music embed
new Podcast();                        // Podcast episode
ARKit::fromUrl('https://example.com/model.usdz');
```

### Social Embeds

```php
new Tweet('https://twitter.com/...');
new Instagram('https://instagram.com/p/...');
new EmbedWebVideo('https://youtube.com/watch?v=...');
new FacebookPost('https://facebook.com/...');
new TikTok('https://tiktok.com/@user/video/...');
```

### Structure

```php
new Container();       // Group components
new Section();         // Article section
new Header();          // Section header (supports scenes)
new Chapter();         // Chapter division
new Aside('...');      // Sidebar
new Divider();         // Visual separator
new FlexibleSpacer();  // Flexible spacing
```

### Interactive

```php
new LinkButton('Click Here', 'https://...');
new ArticleLink::fromArticleId('article-id');
new Map(latitude: 51.5074, longitude: -0.1278);
new Place(latitude: 51.5074, longitude: -0.1278, caption: 'London');
new DataTable();
new HTMLTable('<table>...</table>');
new BannerAdvertisement();
new MediumRectangleAdvertisement();
new ReplicaAdvertisement();           // Print replica ad
```

---

## Text Styles

```php
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;

$style = (new ComponentTextStyle())
    ->setFontName('Georgia')
    ->setFontSize(18)
    ->setLineHeight(28)
    ->setTextColor('#333333')
    ->setFontWeight('bold')          // regular, medium, semibold, bold
    ->setFontStyle('italic')         // normal, italic
    ->setTextAlignment('left')       // left, center, right, justified
    ->setUnderline(true)
    ->setTracking(0)                 // Letter spacing
    ->setParagraphSpacingBefore(12)
    ->setParagraphSpacingAfter(12);

$article->addComponentTextStyle('my-style', $style);
$body->setTextStyle('my-style');
```

### Drop Cap

```php
$style->setDropCapStyle([
    'numberOfLines' => 3,
    'numberOfCharacters' => 1,
    'fontName' => 'Georgia-Bold',
    'textColor' => '#007AFF'
]);
```

### Inline Text Styles

```php
// Style portions of text within a component
$body->setInlineTextStyles([
    ['rangeStart' => 0, 'rangeLength' => 5, 'textStyle' => 'bold-style'],
    ['rangeStart' => 10, 'rangeLength' => 8, 'textStyle' => 'link-style']
]);
```

---

## Layouts

### Horizontal Stack

```php
use TomGould\AppleNews\Document\Layouts\HorizontalStackDisplay;

$container = new Container();
$container->setContentDisplayObject(new HorizontalStackDisplay());
$container->addComponent($left);
$container->addComponent($right);
```

### Grid

```php
use TomGould\AppleNews\Document\Layouts\CollectionDisplay;

$container = new Container();
$container->setContentDisplayObject(
    CollectionDisplay::grid(gutter: 10, minimumWidth: 200)
);
```

### Column Layout

```php
$component->setLayout([
    'columnStart' => 0,
    'columnSpan' => 7,
    'margin' => ['top' => 20, 'bottom' => 20],
    'ignoreDocumentMargin' => true  // Full bleed
]);
```

---

## Dark Mode

```php
// Text style with dark mode
$style->setConditional([[
    'conditions' => [['preferredColorScheme' => 'dark']],
    'textColor' => '#FFFFFF'
]]);

// Container background
$container->setStyle([
    'backgroundColor' => '#FFFFFF',
    'conditional' => [[
        'conditions' => [['preferredColorScheme' => 'dark']],
        'backgroundColor' => '#1C1C1E'
    ]]
]);
```

---

## Animations & Behaviors

```php
use TomGould\AppleNews\Document\Animations\*;
use TomGould\AppleNews\Document\Behaviors\*;

// Animations (all from Apple News Format)
$component->setAnimationObject(AppearAnimation::create());      // Generic appear
$component->setAnimationObject(FadeInAnimation::standard());    // Fade in
$component->setAnimationObject(MoveInAnimation::fromLeft());    // Move from direction
$component->setAnimationObject(ScaleFadeAnimation::subtle());   // Scale + fade

// Behaviors (all from Apple News Format)
$component->setBehaviorObject(Parallax::withFactor(0.5));       // Parallax scroll
$component->setBehaviorObject(BackgroundParallax::withFactor(0.8));
$component->setBehaviorObject(Springy::create());               // Spring physics
$component->setBehaviorObject(Motion::create());                // Gyroscope
$component->setBehaviorObject(BackgroundMotion::create());      // Gyro for backgrounds

// Header scenes
use TomGould\AppleNews\Document\Scenes\*;
$header->setScene(ParallaxScaleHeader::create());
$header->setScene(FadingStickyHeader::create());
```

---

## Background Fills

```php
use TomGould\AppleNews\Document\Styles\Fills\*;

$fill = (new ImageFill('https://...'))->asCover();
$fill = LinearGradientFill::vertical('#000', '#333');
$fill = (new VideoFill('https://...'))->setLoop(true);

$container->setStyle(['fill' => $fill->jsonSerialize()]);
```

---

## API Operations

```php
// Create
$response = $client->createArticle($channelId, $article);
$response = $client->createArticle($channelId, $article, $metadata, $assets);
$articleId = $response['data']['id'];
$revision = $response['data']['revision'];

// Read
$article = $client->getArticle($articleId);

// Update (requires fresh revision!)
$current = $client->getArticle($articleId);
$client->updateArticle($articleId, $current['data']['revision'], $article);

// Delete
$client->deleteArticle($articleId);

// Search
$results = $client->searchArticlesInChannel($channelId, ['pageSize' => 50]);

// Channel/Section
$channel = $client->getChannel($channelId);
$quota = $client->getChannelQuota($channelId);
$sections = $client->listSections($channelId);
$client->promoteArticles($sectionId, [$articleId1, $articleId2]);
```

---

## Request Metadata

```php
use TomGould\AppleNews\Request\ArticleMetadata;
use TomGould\AppleNews\Enum\MaturityRating;

$meta = (new ArticleMetadata())
    ->setIsSponsored(false)
    ->setIsCandidateToBeFeatured(true)
    ->setIsPreview(false)
    ->setMaturityRating(MaturityRating::GENERAL)
    ->addTargetTerritories(['US', 'GB', 'CA'])
    ->addSectionById('section-id');

$client->createArticle($channelId, $article, $meta->toArray(), $assets);
```

---

## Assets

```php
$article->addComponent(Photo::fromBundle('hero.jpg'));

$assets = [
    'bundle://hero.jpg' => '/path/to/hero.jpg',
    'bundle://logo.png' => '/path/to/logo.png',
];

$client->createArticle($channelId, $article, null, $assets);
```

---

## Error Handling

```php
use TomGould\AppleNews\Exception\AppleNewsException;
use TomGould\AppleNews\Exception\AuthenticationException;

try {
    $client->createArticle($channelId, $article);
} catch (AuthenticationException $e) {
    // 401/403 - Check credentials
} catch (AppleNewsException $e) {
    echo $e->getMessage();
    echo $e->getErrorCode();  // e.g., 'INVALID_DOCUMENT'
    echo $e->getKeyPath();    // e.g., 'components[0].text'
}
```

---

## Common Patterns

```php
// HTML content
(new Body('<strong>Bold</strong>'))->setFormat('html');

// Full-bleed image
$photo->setLayout(['ignoreDocumentMargin' => true, 'columnSpan' => 7]);

// Accessibility
$photo->setAccessibilityCaption('Description for screen readers');

// Debug article JSON
file_put_contents('debug.json', json_encode($article, JSON_PRETTY_PRINT));
```

---

## Pre-Publish Checklist

- [ ] Identifier is URL-safe (a-z, 0-9, _, -)
- [ ] Metadata has excerpt for discovery
- [ ] Images have accessibility captions
- [ ] HTML content has `setFormat('html')`
- [ ] Bundle assets have mapping provided
- [ ] Update uses fresh revision token
- [ ] Sponsored content marked with `setIsSponsored(true)`
- [ ] AI content marked with `setContentGenerationType('AI')`

---

*Tip: `json_encode($article, JSON_PRETTY_PRINT)` to debug structure*
