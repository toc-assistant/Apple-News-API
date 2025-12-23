
Apple News Publisher API Client.

This class provides high-level methods to interact with the Apple News API,
including channel information retrieval, section management, and article
CRUD (Create, Read, Update, Delete) operations.

It uses PSR-18 for HTTP requests and PSR-17 for message factories to ensure
compatibility with any modern PHP HTTP library.

***

* Full name: `\TomGould\AppleNews\Client\AppleNewsClient`
* This class is marked as **final** and can't be subclassed
* This class is a **Final class**

**See Also:**

* https://developer.apple.com/documentation/applenewsapi

## Constants

| Constant       | Visibility | Type | Value                        |
|----------------|------------|------|------------------------------|
| `API_ENDPOINT` | private    |      | 'https://news-api.apple.com' |

## Properties

### authenticator

```php
private \TomGould\AppleNews\Client\Authenticator $authenticator
```

***

### httpClient

```php
private \Psr\Http\Client\ClientInterface $httpClient
```

***

### requestFactory

```php
private \Psr\Http\Message\RequestFactoryInterface $requestFactory
```

***

### streamFactory

```php
private \Psr\Http\Message\StreamFactoryInterface $streamFactory
```

***

### endpoint

```php
private string $endpoint
```

***

## Methods

### __construct

```php
public __construct(\TomGould\AppleNews\Client\Authenticator $authenticator, \Psr\Http\Client\ClientInterface $httpClient, \Psr\Http\Message\RequestFactoryInterface $requestFactory, \Psr\Http\Message\StreamFactoryInterface $streamFactory, string $endpoint = \self::API_ENDPOINT): mixed
```

**Parameters:**

| Parameter         | Type                                          | Description               |
|-------------------|-----------------------------------------------|---------------------------|
| `$authenticator`  | **\TomGould\AppleNews\Client\Authenticator**  | Handles request signing.  |
| `$httpClient`     | **\Psr\Http\Client\ClientInterface**          | PSR-18 HTTP client.       |
| `$requestFactory` | **\Psr\Http\Message\RequestFactoryInterface** | PSR-17 request factory.   |
| `$streamFactory`  | **\Psr\Http\Message\StreamFactoryInterface**  | PSR-17 stream factory.    |
| `$endpoint`       | **string**                                    | The base URL for the API. |

***

### create

Factory method to create a client with the given credentials.

```php
public static create(string $keyId, string $keySecret, \Psr\Http\Client\ClientInterface $httpClient, \Psr\Http\Message\RequestFactoryInterface $requestFactory, \Psr\Http\Message\StreamFactoryInterface $streamFactory, string $endpoint = \self::API_ENDPOINT): self
```

* This method is **static**.
**Parameters:**

| Parameter         | Type                                          | Description                                      |
|-------------------|-----------------------------------------------|--------------------------------------------------|
| `$keyId`          | **string**                                    | Your Apple News API Key ID.                      |
| `$keySecret`      | **string**                                    | Your Apple News API Key Secret (Base64 encoded). |
| `$httpClient`     | **\Psr\Http\Client\ClientInterface**          | A PSR-18 compliant HTTP client.                  |
| `$requestFactory` | **\Psr\Http\Message\RequestFactoryInterface** | A PSR-17 compliant request factory.              |
| `$streamFactory`  | **\Psr\Http\Message\StreamFactoryInterface**  | A PSR-17 compliant stream factory.               |
| `$endpoint`       | **string**                                    | Optional override for the API endpoint.          |

***

### getChannel

Get channel information.

```php
public getChannel(string $channelId): array<string,mixed>
```

**Parameters:**

| Parameter    | Type       | Description                            |
|--------------|------------|----------------------------------------|
| `$channelId` | **string** | The unique identifier for the channel. |

**Return Value:**

The decoded API response.

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/get-channels-_channelid_

***

### getChannelQuota

Get channel quota information.

```php
public getChannelQuota(string $channelId): array<string,mixed>
```

**Parameters:**

| Parameter    | Type       | Description                            |
|--------------|------------|----------------------------------------|
| `$channelId` | **string** | The unique identifier for the channel. |

**Return Value:**

The decoded API response.

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### listSections

List all sections in a channel.

```php
public listSections(string $channelId): array<string,mixed>
```

**Parameters:**

| Parameter    | Type       | Description                            |
|--------------|------------|----------------------------------------|
| `$channelId` | **string** | The unique identifier for the channel. |

**Return Value:**

The decoded API response containing section list.

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/get-channels-_channelid_-sections

***

### getSection

Get section information.

```php
public getSection(string $sectionId): array<string,mixed>
```

**Parameters:**

| Parameter    | Type       | Description                            |
|--------------|------------|----------------------------------------|
| `$sectionId` | **string** | The unique identifier for the section. |

**Return Value:**

The decoded API response.

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/get-sections-_sectionid_

***

### promoteArticles

Promote articles in a section.

```php
public promoteArticles(string $sectionId, string[] $articleIds): array<string,mixed>
```

**Parameters:**

| Parameter     | Type         | Description                            |
|---------------|--------------|----------------------------------------|
| `$sectionId`  | **string**   | The unique identifier for the section. |
| `$articleIds` | **string[]** | List of article IDs to promote.        |

**Return Value:**

The decoded API response.

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/post-sections-_sectionid_-promotedarticles

***

### createArticle

Create a new article.

```php
public createArticle(string $channelId, \TomGould\AppleNews\Document\Article $article, array<string,mixed>|null $metadata = null, array<string,string> $assets = []): array<string,mixed>
```

Handles the multipart submission of the article JSON, metadata, and
any bundled assets (images, fonts).

**Parameters:**

| Parameter    | Type                                     | Description                                                |
|--------------|------------------------------------------|------------------------------------------------------------|
| `$channelId` | **string**                               | The channel to publish to.                                 |
| `$article`   | **\TomGould\AppleNews\Document\Article** | The article document object.                               |
| `$metadata`  | **array<string,mixed>\|null**            | Optional metadata (sections, isSponsored, etc.)            |
| `$assets`    | **array<string,string>**                 | Map of bundle:// URLs to file paths or raw binary content. |

**Return Value:**

The decoded API response (including article ID).

**Throws:**

If the API returns an error.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/post-channels-_channelid_-articles

***

### createArticleFromJson

Create an article from raw JSON.

```php
public createArticleFromJson(string $channelId, string $articleJson, array<string,mixed>|null $metadata = null, array<string,string> $assets = []): array<string,mixed>
```

Useful if you already have the ANF JSON generated by another tool.

**Parameters:**

| Parameter      | Type                          | Description                                |
|----------------|-------------------------------|--------------------------------------------|
| `$channelId`   | **string**                    | The channel to publish to.                 |
| `$articleJson` | **string**                    | The raw ANF JSON string.                   |
| `$metadata`    | **array<string,mixed>\|null** | Optional metadata.                         |
| `$assets`      | **array<string,string>**      | Map of bundle URLs to local paths/content. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### getArticle

Get article information.

```php
public getArticle(string $articleId): array<string,mixed>
```

**Parameters:**

| Parameter    | Type       | Description        |
|--------------|------------|--------------------|
| `$articleId` | **string** | Unique article ID. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/get-articles-_articleid_

***

### searchArticlesInChannel

Search articles in a channel.

```php
public searchArticlesInChannel(string $channelId, array<string,mixed> $params = []): array<string,mixed>
```

**Parameters:**

| Parameter    | Type                    | Description                                                   |
|--------------|-------------------------|---------------------------------------------------------------|
| `$channelId` | **string**              | The channel ID to search within.                              |
| `$params`    | **array<string,mixed>** | Search parameters like pageSize, pageToken, fromDate, toDate. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/get-channels-_channelid_-articles

***

### searchArticlesInSection

Search articles in a section.

```php
public searchArticlesInSection(string $sectionId, array<string,mixed> $params = []): array<string,mixed>
```

**Parameters:**

| Parameter    | Type                    | Description                      |
|--------------|-------------------------|----------------------------------|
| `$sectionId` | **string**              | The section ID to search within. |
| `$params`    | **array<string,mixed>** | Search parameters.               |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### updateArticle

Update an existing article.

```php
public updateArticle(string $articleId, string $revision, \TomGould\AppleNews\Document\Article $article, array<string,mixed>|null $metadata = null, array<string,string> $assets = []): array<string,mixed>
```

Updating an article requires the 'revision' string found in the
information of the existing article.

**Parameters:**

| Parameter    | Type                                     | Description                                               |
|--------------|------------------------------------------|-----------------------------------------------------------|
| `$articleId` | **string**                               | The ID of the article to update.                          |
| `$revision`  | **string**                               | The revision token from the previous get/create response. |
| `$article`   | **\TomGould\AppleNews\Document\Article** | The updated article object.                               |
| `$metadata`  | **array<string,mixed>\|null**            | Optional metadata.                                        |
| `$assets`    | **array<string,string>**                 | Assets for the updated article.                           |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/post-articles-_articleid_

***

### deleteArticle

Delete an article.

```php
public deleteArticle(string $articleId): void
```

**Parameters:**

| Parameter    | Type       | Description               |
|--------------|------------|---------------------------|
| `$articleId` | **string** | The article ID to delete. |

**Throws:**

If deletion fails.
- [`AppleNewsException`](../Exception/AppleNewsException.md)

**See Also:**

* https://developer.apple.com/documentation/applenewsapi/delete-articles-_articleid_

***

### get

Perform a signed GET request.

```php
private get(string $path): array<string,mixed>
```

**Parameters:**

| Parameter | Type       | Description                      |
|-----------|------------|----------------------------------|
| `$path`   | **string** | The API path (excluding domain). |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### postJson

Perform a signed POST request with JSON body.

```php
private postJson(string $path, string $body): array<string,mixed>
```

**Parameters:**

| Parameter | Type       | Description            |
|-----------|------------|------------------------|
| `$path`   | **string** | The API path.          |
| `$body`   | **string** | The JSON encoded body. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### postMultipart

Perform a signed POST request with a multipart body.

```php
private postMultipart(string $path, \TomGould\AppleNews\Request\MultipartBuilder $builder): array<string,mixed>
```

**Parameters:**

| Parameter  | Type                                             | Description                       |
|------------|--------------------------------------------------|-----------------------------------|
| `$path`    | **string**                                       | The API path.                     |
| `$builder` | **\TomGould\AppleNews\Request\MultipartBuilder** | The builder containing the parts. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### delete

Perform a signed DELETE request.

```php
private delete(string $path): void
```

**Parameters:**

| Parameter | Type       | Description   |
|-----------|------------|---------------|
| `$path`   | **string** | The API path. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### sendRequest

Helper to send a PSR-7 request and decode the JSON response.

```php
private sendRequest(\Psr\Http\Message\RequestInterface $request): array<string,mixed>
```

**Parameters:**

| Parameter  | Type                                   | Description         |
|------------|----------------------------------------|---------------------|
| `$request` | **\Psr\Http\Message\RequestInterface** | The signed request. |

**Throws:**

- [`AppleNewsException`](../Exception/AppleNewsException.md)

***

### handleErrorResponse

Handle error responses from the API by throwing appropriate exceptions.

```php
private handleErrorResponse(string $body, int $statusCode): never
```

**Parameters:**

| Parameter     | Type       | Description            |
|---------------|------------|------------------------|
| `$body`       | **string** | The raw response body. |
| `$statusCode` | **int**    | The HTTP status code.  |

**Throws:**

- [`\TomGould\AppleNews\Exception\AuthenticationException|\TomGould\AppleNews\Exception\AppleNewsException`](../Exception/AuthenticationException|/TomGould/AppleNews/Exception/AppleNewsException.md)

***
