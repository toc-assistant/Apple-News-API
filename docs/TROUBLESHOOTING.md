# Apple News API Troubleshooting Guide

Comprehensive solutions to common issues.

---

## Authentication Errors

### `401 Unauthorized`

**Causes:** Invalid credentials or clock skew.

```php
// Verify credentials format
$keyId = 'ABC123DEF456';           // Alphanumeric
$keySecret = 'base64string=';      // Must be base64-encoded

// Check server time sync
echo "Server time: " . date('c');
```

### `403 Forbidden`

**Causes:** Valid credentials but wrong channel or insufficient permissions.

```php
// Verify channel access
try {
    $channel = $client->getChannel($channelId);
} catch (AppleNewsException $e) {
    echo "Cannot access channel: " . $e->getMessage();
}
```

---

## Document Validation Errors

### `INVALID_DOCUMENT: Invalid identifier`

```php
// ❌ WRONG
Article::create('My Article #1', 'Title');
Article::create('article/2024', 'Title');

// ✅ CORRECT (URL-safe only)
Article::create('my-article-1', 'Title');
Article::create('article_2024_01', 'Title');
```

### `INVALID_DOCUMENT: components[X] missing required field`

```php
// ❌ Photo without URL
$photo = new Photo();

// ✅ Correct
$photo = Photo::fromUrl('https://example.com/image.jpg');
```

### `INVALID_DOCUMENT: Invalid text format`

```php
// ❌ HTML without format
$body = new Body('<p><strong>Bold</strong></p>');

// ✅ Specify HTML format
$body = (new Body('<p><strong>Bold</strong></p>'))->setFormat('html');
```

### `INVALID_DOCUMENT: Invalid color value`

```php
// ❌ Invalid
'rgb(255, 0, 0)'    // Not supported
'red'                // Named colors not supported

// ✅ Valid
'#FF0000'            // 6-digit hex
'#F00'               // 3-digit hex
'#FF000080'          // 8-digit hex with alpha
```

### `INVALID_DOCUMENT: Invalid URL`

```php
// ❌ Invalid
Photo::fromUrl('/local/path');
Photo::fromUrl('file:///path');

// ✅ Valid
Photo::fromUrl('https://example.com/image.jpg');
Photo::fromBundle('image.jpg');  // For local files
```

---

## Asset Errors

### `Asset not found: bundle://...`

```php
// ❌ Key mismatch
$article->addComponent(Photo::fromBundle('hero.jpg'));
$client->createArticle($channelId, $article, null, [
    'bundle://image.jpg' => '/path/to/hero.jpg'  // Wrong key!
]);

// ✅ Keys must match exactly
$client->createArticle($channelId, $article, null, [
    'bundle://hero.jpg' => '/path/to/hero.jpg'   // Correct
]);
```

### `ASSET_INGEST_FAILED`

**Causes:** URL inaccessible, unsupported format, file too large.

```bash
# Verify URL accessibility
curl -I https://example.com/image.jpg
```

**Supported formats:** JPEG, PNG, GIF  
**Recommended size:** < 20MB for images

---

## Update & Revision Errors

### `CONFLICT: Revision mismatch`

```php
// ❌ Using stale revision
$client->updateArticle($articleId, $oldRevision, $article);

// ✅ Always get fresh revision
$current = $client->getArticle($articleId);
$freshRevision = $current['data']['revision'];
$client->updateArticle($articleId, $freshRevision, $article);
```

### `NOT_FOUND: Article not found`

```php
function articleExists(AppleNewsClient $client, string $articleId): bool
{
    try {
        $client->getArticle($articleId);
        return true;
    } catch (AppleNewsException $e) {
        return $e->getCode() !== 404 ? throw $e : false;
    }
}
```

---

## Layout & Rendering Issues

### Components Not Appearing

```php
// ❌ Empty body is ignored
$article->addComponent(new Body(''));

// ✅ Only add non-empty content
if (!empty(trim($text))) {
    $article->addComponent(new Body($text));
}
```

### Layout Shifts

```php
// ❌ No dimensions
$photo = Photo::fromUrl('https://...');

// ✅ Provide dimension hints
$photo->setLayout(['minimumHeight' => '300pt']);
```

### Styles Not Applied

```php
// ❌ Using unregistered style
$body->setTextStyle('myStyle');

// ✅ Register first
$article->addComponentTextStyle('myStyle', $styleObject);
$body->setTextStyle('myStyle');
```

### Dark Mode Not Working

```php
// ❌ Wrong format
$style->setConditional(['darkMode' => true, 'textColor' => '#FFF']);

// ✅ Correct format
$style->setConditional([[
    'conditions' => [['preferredColorScheme' => 'dark']],
    'textColor' => '#FFFFFF'
]]);
```

---

## Network & HTTP Errors

### `Connection timed out`

```php
$httpClient = new Client([
    'timeout' => 60,
    'connect_timeout' => 10,
]);
```

### `SSL certificate problem`

```bash
sudo update-ca-certificates
```

---

## Rate Limiting

### `429 Too Many Requests`

```php
function publishWithBackoff($client, $channelId, $article, $maxRetries = 5)
{
    for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
        try {
            return $client->createArticle($channelId, $article);
        } catch (AppleNewsException $e) {
            if ($e->getCode() !== 429) throw $e;
            sleep(pow(2, $attempt));  // 1s, 2s, 4s, 8s, 16s
        }
    }
    throw new Exception("Max retries exceeded");
}
```

---

## Debugging Techniques

### Export Article JSON

```php
$json = json_encode($article, JSON_PRETTY_PRINT);
file_put_contents('debug-article.json', $json);
```

### Validate Before Publishing

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

### Detailed Error Logging

```php
try {
    $response = $client->createArticle($channelId, $article);
} catch (AppleNewsException $e) {
    $log = [
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'errorCode' => $e->getErrorCode(),
        'keyPath' => $e->getKeyPath(),
        'article' => json_encode($article, JSON_PRETTY_PRINT),
    ];
    file_put_contents('apple-news-error.log', print_r($log, true));
    throw $e;
}
```

---

## Environment Issues

### PHP Version

**Requirement:** PHP 8.1+

```bash
php -v  # Should show 8.1.x or higher
```

### Required Extensions

```php
$required = ['json', 'curl', 'openssl', 'mbstring'];
foreach ($required as $ext) {
    if (!extension_loaded($ext)) {
        echo "Missing: {$ext}\n";
    }
}
```

### Memory for Large Assets

```php
ini_set('memory_limit', '512M');
```

---

## Error Code Reference

| Code | Meaning | Solution |
|------|---------|----------|
| 401 | Unauthorized | Check API credentials |
| 403 | Forbidden | Check channel permissions |
| 404 | Not Found | Verify article/channel ID |
| 409 | Conflict | Get fresh revision token |
| 429 | Rate Limited | Implement backoff |
| 500+ | Server Error | Retry with backoff |

---

## Getting Help

1. **[COOKBOOK.md](COOKBOOK.md)** - Advanced patterns
2. **[CHEATSHEET.md](CHEATSHEET.md)** - Quick reference
3. **[Apple Docs](https://developer.apple.com/documentation/apple_news)** - Official reference
4. **[News Previewer](https://developer.apple.com/news-publisher/)** - Validate JSON
5. **[GitHub Issues](https://github.com/tomgould/apple-news-api/issues)** - Report bugs

---

*Last updated: 2026-02-07*
