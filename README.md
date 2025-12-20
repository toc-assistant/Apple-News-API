# Apple News API PHP Client

A modern, PSR-compliant PHP library for the Apple News Publisher API with full Apple News Format (ANF) document support.

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green)](LICENSE)

## Features

- 🚀 **Modern PHP 8.1+** with strict types and named arguments.
- 🔌 **PSR-18 HTTP Client** compatible (works with Guzzle, Symfony, etc.).
- 📝 **Full Apple News Format** support with a fluent, object-oriented document builder.
- 🔐 **HMAC-SHA256 Authentication** handled automatically.
- 📦 **Zero Framework Dependencies** - standalone package.
- ✅ **Tested** with PHPUnit.

## Installation

```bash
composer require tomgould/apple-news-api
```

You also need a PSR-18 HTTP client and PSR-17 factories. Guzzle is the standard choice:

```bash
composer require guzzlehttp/guzzle guzzlehttp/psr7
```

---

## Full Implementation Guide

This guide covers the end-to-end workflow for publishing content to Apple News using this library.

### 1. Prerequisites & Security

Before you begin, ensure you have your credentials from **Apple News Publisher**:
- **Channel ID**: A UUID identifying your publication.
- **API Key ID**: A UUID identifying your API key.
- **API Key Secret**: A Base64-encoded string used for signing requests.

The library handles the HMAC-SHA256 signing process automatically using the `Authenticator` class.

### 2. Client Initialization

The `AppleNewsClient` uses PSR interfaces, making it compatible with any modern HTTP library.

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

### 3. Building an Article (ANF)

Apple News Format (ANF) is a JSON-based document format. This library provides a fluent builder to construct these documents.

#### A. Create the Article Object
```php
use TomGould\AppleNews\Document\Article;

$article = Article::create(
    identifier: 'my-internal-id-123',
    title: 'The Future of Web Development',
    language: 'en',
    columns: 7, // Default ANF grid columns
    width: 1024 // Default points
);
```

#### B. Add Metadata
Metadata includes author information, keywords, and URLs for discovery.
```php
use TomGould\AppleNews\Document\Metadata;

$metadata = (new Metadata())
    ->addAuthor('Jane Doe')
    ->setExcerpt('An in-depth look at modern web frameworks.')
    ->addKeywords(['PHP', 'Web', 'Programming'])
    ->setDatePublished(new DateTime());

$article->setMetadata($metadata);
```

#### C. Define Reusable Styles
Instead of styling every component manually, define reusable text and component styles.
```php
use TomGould\AppleNews\Document\Styles\ComponentTextStyle;

$bodyStyle = (new ComponentTextStyle())
    ->setFontName('Helvetica')
    ->setFontSize(18)
    ->setLineHeight(24)
    ->setTextColor('#333333');

$article->addComponentTextStyle('defaultBody', $bodyStyle);
```

#### D. Add Components
Components represent the content of your article. Roles define their semantic meaning.
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

### 4. Working with Assets

#### Bundle Assets (Multipart)
If you have local images, reference them using `bundle://` URLs. The client will package them as a multipart request automatically.

```php
use TomGould\AppleNews\Document\Components\Photo;

$article->addComponent(Photo::fromBundle('hero.jpg'));

// When publishing, provide the local path or binary content
$assets = [
    'bundle://hero.jpg' => __DIR__ . '/images/hero.jpg'
];
```

#### Remote Assets
You can also use direct HTTPS URLs. These do not need to be included in the publish request.
```php
$article->addComponent(Photo::fromUrl('[https://example.com/cdn/remote-image.jpg](https://example.com/cdn/remote-image.jpg)'));
```

### 5. Publishing to Apple News

Use the client to send your article to a specific channel. You can also provide API-level metadata (like sections) here.

```php
try {
    $response = $client->createArticle(
        channelId: 'your-channel-uuid',
        article: $article,
        metadata: [
            'isSponsored' => false,
            'links' => [
                'sections' => ['[https://news-api.apple.com/sections/your-section-uuid](https://news-api.apple.com/sections/your-section-uuid)']
            ]
        ],
        assets: $assets
    );

    $articleId = $response['data']['id'];
    $shareUrl = $response['data']['shareUrl'];
    echo "Published successfully! Article ID: $articleId";

} catch (\TomGould\AppleNews\Exception\AppleNewsException $e) {
    // Handle API errors (Validation, Auth, Quota, etc.)
    echo "API Error: " . $e->getMessage() . " (" . $e->getErrorCode() . ")";
}
```

### 6. Updating & Managing Articles

#### Read Information
```php
$info = $client->getArticle($articleId);
$revision = $info['data']['revision']; // Needed for updates
```

#### Update Content
Updates require the previous `revision` token to prevent overwriting concurrent changes.
```php
$client->updateArticle(
    articleId: $articleId,
    revision: $revision,
    article: $updatedArticle
);
```

#### Search
```php
$results = $client->searchArticlesInChannel($channelId, [
    'pageSize' => 5,
    'sortDir' => 'DESC'
]);
```

#### Delete
```php
$client->deleteArticle($articleId);
```

---

## Detailed Documentation

Detailed PHPDoc documentation is available for every class and method in the `src/` directory.

