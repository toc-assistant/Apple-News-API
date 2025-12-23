
Builds multipart/form-data request bodies for the Apple News API.

Apple News requires articles to be submitted as MIME multipart messages.
The message MUST contain an 'article.json' part and can optionally include
a 'metadata' part and binary parts for bundle resources (images, fonts, etc.).

***

* Full name: `\TomGould\AppleNews\Request\MultipartBuilder`
* This class is marked as **final** and can't be subclassed
* This class is a **Final class**

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/post-channels-_channelid_-articles

## Constants

| Constant | Visibility | Type | Value  |
|----------|------------|------|--------|
| `CRLF`   | private    |      | "\r\n" |

## Properties

### boundary

```php
private string $boundary
```

***

### parts

```php
private array<int,array{name: string, filename: string|null, contentType: string, content: string}> $parts
```

***

## Methods

### __construct

```php
public __construct(string|null $boundary = null): mixed
```

**Parameters:**

| Parameter   | Type             | Description                      |
|-------------|------------------|----------------------------------|
| `$boundary` | **string\|null** | Optional custom boundary string. |

***

### addJson

Add a JSON part to the multipart body.

```php
public addJson(string $name, string $json, string|null $filename = null): self
```

**Parameters:**

| Parameter   | Type             | Description                                       |
|-------------|------------------|---------------------------------------------------|
| `$name`     | **string**       | The part name (e.g., 'article.json', 'metadata'). |
| `$json`     | **string**       | The JSON string.                                  |
| `$filename` | **string\|null** | Optional filename for the part.                   |

***

### addArticle

Convenience method to add the 'article.json' document part.

```php
public addArticle(string $json): self
```

**Parameters:**

| Parameter | Type       | Description          |
|-----------|------------|----------------------|
| `$json`   | **string** | The ANF JSON string. |

***

### addMetadata

Convenience method to add article metadata.

```php
public addMetadata(array<string,mixed> $metadata): self
```

**Parameters:**

| Parameter   | Type                    | Description                                           |
|-------------|-------------------------|-------------------------------------------------------|
| `$metadata` | **array<string,mixed>** | Metadata array (wrapped in 'data' key automatically). |

**Throws:**

- [`JsonException`](./)

***

### addImageFile

Add an image part from a local file path.

```php
public addImageFile(string $name, string $filePath): self
```

**Parameters:**

| Parameter   | Type       | Description                      |
|-------------|------------|----------------------------------|
| `$name`     | **string** | The part name/bundle identifier. |
| `$filePath` | **string** | Absolute path to the local file. |

**Throws:**

if file doesn't exist.
- [`InvalidArgumentException`](./)
if file cannot be read.
- [`RuntimeException`](./)

***

### addImage

Add an image part from raw binary content.

```php
public addImage(string $name, string $content, string $filename, string|null $contentType = null): self
```

**Parameters:**

| Parameter      | Type             | Description                                        |
|----------------|------------------|----------------------------------------------------|
| `$name`        | **string**       | The part name.                                     |
| `$content`     | **string**       | Raw binary data.                                   |
| `$filename`    | **string**       | The filename to present in the part header.        |
| `$contentType` | **string\|null** | Optional MIME type. Guessed from filename if null. |

***

### addFont

Add a font file part.

```php
public addFont(string $name, string $content, string $filename): self
```

**Parameters:**

| Parameter   | Type       | Description           |
|-------------|------------|-----------------------|
| `$name`     | **string** | The part name.        |
| `$content`  | **string** | Raw binary font data. |
| `$filename` | **string** | The font filename.    |

***

### addPart

Core method to add a generic part to the multipart body.

```php
public addPart(string $name, string $content, string $contentType, string|null $filename = null): self
```

**Parameters:**

| Parameter      | Type             | Description        |
|----------------|------------------|--------------------|
| `$name`        | **string**       | Part name.         |
| `$content`     | **string**       | Content data.      |
| `$contentType` | **string**       | MIME content type. |
| `$filename`    | **string\|null** | Optional filename. |

***

### build

Build the complete multipart raw body string.

```php
public build(): string
```

***

### getContentType

Get the full Content-Type header value required for this request.

```php
public getContentType(): string
```

***

### getBoundary

Get the random boundary string used.

```php
public getBoundary(): string
```

***

### guessImageContentType

Guess the MIME content type based on the file extension.

```php
private guessImageContentType(string $filename): string
```

**Parameters:**

| Parameter   | Type       | Description |
|-------------|------------|-------------|
| `$filename` | **string** |             |

***
