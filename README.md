# Apple News API PHP Client

A modern, PSR-compliant PHP library for the Apple News Publisher API with full Apple News Format (ANF) document support.

[![Latest Version](https://img.shields.io/packagist/v/tomgould/apple-news-api.svg?style=flat-square)](https://packagist.org/packages/tomgould/apple-news-api)
[![Total Downloads](https://img.shields.io/packagist/dt/tomgould/apple-news-api.svg?style=flat-square)](https://packagist.org/packages/tomgould/apple-news-api)
[![CI](https://github.com/tomgould/apple-news-api/actions/workflows/ci.yml/badge.svg)](https://github.com/tomgould/apple-news-api/actions)
[![PHP Version](https://img.shields.io/packagist/php-v/tomgould/apple-news-api.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/packagist/l/tomgould/apple-news-api.svg?style=flat-square)](LICENSE)

## Features

- 🚀 **Modern PHP 8.1+** with strict types and named arguments
- 🔌 **PSR-18 HTTP Client** compatible (works with Guzzle, Symfony, etc.)
- 📝 **Full Apple News Format** support with a fluent, object-oriented document builder
- 🔐 **HMAC-SHA256 Authentication** handled automatically
- 📦 **Zero Framework Dependencies** — use with any framework or standalone
- ✅ **Thoroughly Tested** — 99%+ code coverage

## Requirements

- PHP 8.1 or higher
- A PSR-18 HTTP client (e.g., Guzzle)
- Apple News Publisher API credentials

## Installation

```bash
composer require tomgould/apple-news-api
```

You also need a PSR-18 HTTP client and PSR-17 factories. Guzzle is recommended:

```bash
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

## Quick Start

```php
use TomGould\AppleNews\Client\AppleNewsClient;
use TomGould\AppleNews\Document\Article;
use TomGould\AppleNews\Document\Components\{Title, Body, Photo};
use TomGould\AppleNews\Document\Metadata;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

// 1. Create the client
$factory = new HttpFactory();
$client = AppleNewsClient::create(
    keyId: 'your-api-key-id',
    keySecret: 'your-api-secret',
    httpClient: new Client(),
    requestFactory: $factory,
    streamFactory: $factory
);

// 2. Build an article
$article = Article::create(
    identifier: 'my-article-123',
    title: 'Breaking News Story',
    language: 'en'
);

$article
    ->addComponent(new Title('Breaking News Story'))
    ->addComponent(Photo::fromUrl('https://example.com/hero.jpg'))
    ->addComponent(new Body('This is the article content...'));

$article->setMetadata(
    (new Metadata())
        ->addAuthor('Jane Doe')
        ->setExcerpt('A short summary of the article')
);

// 3. Publish to Apple News
$response = $client->createArticle('your-channel-id', $article);

echo "Published! Article ID: " . $response['data']['id'];
```

---

## Full Implementation Guide

### Getting Your API Credentials

1. Sign up for [Apple News Publisher](https://developer.apple.com/apple-news/)
2. Create a channel for your publication
3. Generate API credentials (Key ID and Secret)

### Client Initialization

```php
use TomGould\AppleNews\Client\AppleNewsClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$factory = new HttpFactory();
$httpClient = new Client();

$client = AppleNewsClient::create(
    keyId: 'your-key-id',
    keySecret: 'your-base64-secret',
    httpClient: $httpClient,
    requestFactory: $factory,
    streamFactory: $factory
);
```

### Building Articles

#### Create the Article

```php
use TomGould\AppleNews\Document\Article;

$article = Article::create(
    identifier: 'my-internal-id-123',
    title: 'The Future of Web Development',
    language: 'en',
    columns: 7,
    width: 1024
);
```

#### Add Metadata

```php
use TomGould\AppleNews\Document\Metadata;

$metadata = (new Metadata())
    ->addAuthor('Jane Doe')
    ->setExcerpt('An in-depth look at modern web frameworks.')
    ->addKeywords(['PHP', 'Web', 'Programming'])
    ->setDatePublished(new DateTime());

$article->setMetadata($metadata);
```

#### Define Reusable Styles

```php
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;

$bodyStyle = (new ComponentTextStyle())
    ->setFontName('Helvetica')
    ->setFontSize(18)
    ->setLineHeight(24)
    ->setTextColor('#333333');

$article->addComponentTextStyle('defaultBody', $bodyStyle);
```

#### Add Components

```php
use TomGould\AppleNews\Document\Components\{Title, Body, Photo, Heading, Divider};

$article
    ->addComponent(new Title('The Future of Web Development'))
    ->addComponent(new Divider())
    ->addComponent(new Heading('Introduction', level: 2))
    ->addComponent(
        (new Body('This is the <strong>main</strong> paragraph.'))
            ->setFormat('html')
            ->setTextStyle('defaultBody')
    );
```

### Available Components

| Component | Description |
|-----------|-------------|
| `Title` | Article title |
| `Heading` | Section headings (levels 1-6) |
| `Body` | Paragraph text |
| `Photo` | Single image |
| `Gallery` | Image gallery |
| `Video` | Native video |
| `EmbedWebVideo` | YouTube/Vimeo embeds |
| `Tweet` | Twitter/X embeds |
| `Instagram` | Instagram embeds |
| `FacebookPost` | Facebook embeds |
| `Pullquote` | Highlighted quotes |
| `Caption` | Image/video captions |
| `Divider` | Visual separator |
| `LinkButton` | Call-to-action buttons |
| `Container` | Group components together |

### Working with Assets

#### Bundle Assets (Local Files)

```php
$article->addComponent(Photo::fromBundle('hero.jpg'));

// Provide the file path when publishing
$assets = [
    'bundle://hero.jpg' => '/path/to/hero.jpg'
];

$client->createArticle($channelId, $article, null, $assets);
```

#### Remote Assets

```php
$article->addComponent(
    Photo::fromUrl('https://example.com/image.jpg')
);
```

### API Operations

#### Channels

```php
$channel = $client->getChannel($channelId);
$quota = $client->getChannelQuota($channelId);
```

#### Sections

```php
$sections = $client->listSections($channelId);
$section = $client->getSection($sectionId);
$client->promoteArticles($sectionId, ['article-id-1', 'article-id-2']);
```

#### Articles

```php
// Create
$response = $client->createArticle($channelId, $article, $metadata, $assets);

// Read
$article = $client->getArticle($articleId);

// Search
$results = $client->searchArticlesInChannel($channelId, ['pageSize' => 20]);

// Update (requires revision token)
$client->updateArticle($articleId, $revision, $updatedArticle);

// Delete
$client->deleteArticle($articleId);
```

### Error Handling

```php
use TomGould\AppleNews\Exception\AppleNewsException;
use TomGould\AppleNews\Exception\AuthenticationException;

try {
    $client->createArticle($channelId, $article);
} catch (AuthenticationException $e) {
    // Invalid API credentials (401/403)
    echo "Auth failed: " . $e->getMessage();
} catch (AppleNewsException $e) {
    // Other API errors
    echo "Error: " . $e->getMessage();
    echo "Code: " . $e->getErrorCode();    // e.g., 'INVALID_DOCUMENT'
    echo "Field: " . $e->getKeyPath();      // e.g., 'components[0].text'
}
```

---

## Generating Documentation

Generate a local HTML API reference:

```bash
# First-time setup
mkdir -p tools
composer docs:install

# Generate docs
composer docs
```

Open `docs/api/index.html` in your browser.

---

## Testing

```bash
# Run tests
composer test

# Run with coverage report
composer test:coverage
```

---

## Contributing

Contributions are welcome! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

---

## License

This library is open-sourced software licensed under the [MIT license](LICENSE).

---

## Links

- [Apple News Format Documentation](https://developer.apple.com/documentation/applenewsformat)
- [Apple News API Documentation](https://developer.apple.com/documentation/applenewsapi)
- [Packagist Package](https://packagist.org/packages/tomgould/apple-news-api)
- [GitHub Repository](https://github.com/tomgould/apple-news-api)
