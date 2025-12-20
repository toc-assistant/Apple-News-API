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

## Usage Overview

### 1. Initialize the Client

The client requires your Apple News API credentials, an HTTP client, and PSR-17 factories for requests and streams.

```php
use TomGould\AppleNews\Client\AppleNewsClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$factory = new HttpFactory();

$client = AppleNewsClient::create(
    keyId: 'your-key-id',
    keySecret: 'your-base64-encoded-secret',
    httpClient: new Client(),
    requestFactory: $factory,
    streamFactory: $factory
);
```

### 2. Build an Article

The library uses a fluent interface to build ANF documents.

```php
use TomGould\AppleNews\Document\Article;
use TomGould\AppleNews\Document\Components\{Title, Body, Photo};

$article = Article::create(
    identifier: 'article-unique-id',
    title: 'Hello World',
    language: 'en'
)
->addComponent(new Title('Welcome to Apple News'))
->addComponent(
    (new Body('This is the main content.'))
        ->setFormat('markdown')
)
->addComponent(
    Photo::fromUrl('[https://example.com/hero.jpg](https://example.com/hero.jpg)')
        ->setCaption('A nice hero image')
);
```

### 3. Publish to a Channel

```php
try {
    $response = $client->createArticle(
        channelId: 'your-channel-uuid',
        article: $article,
        metadata: [
            'isSponsored' => false,
            'links' => [
                'sections' => ['[https://news-api.apple.com/sections/section-uuid](https://news-api.apple.com/sections/section-uuid)']
            ]
        ]
    );
    echo "Published! ID: " . $response['data']['id'];
} catch (\TomGould\AppleNews\Exception\AppleNewsException $e) {
    echo "Error: " . $e->getMessage();
}
```

## Documentation

Every class and method is documented via PHPDoc. Refer to the source code or use an IDE like PHPStorm/VS Code for full autocomplete and inline documentation.

