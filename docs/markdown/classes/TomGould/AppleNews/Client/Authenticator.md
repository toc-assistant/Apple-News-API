
Handles HMAC-SHA256 authentication for Apple News API requests.

Apple News uses a custom HMAC authentication scheme (HHMAC) where requests are
signed using the API secret key. The signature is computed from a canonical
string including the method, URL, date, and optionally the body for POSTs.

***

* Full name: `\TomGould\AppleNews\Client\Authenticator`
* This class is marked as **final** and can't be subclassed
* This class is a **Final class**

**See Also:**

* https://developer.apple.com/documentation/applenewsapi

## Constants

| Constant         | Visibility | Type | Value            |
|------------------|------------|------|------------------|
| `DATE_FORMAT`    | private    |      | 'Y-m-d\TH:i:s\Z' |
| `HASH_ALGORITHM` | private    |      | 'sha256'         |

## Properties

### keyId

```php
private string $keyId
```

***

### keySecret

```php
private string $keySecret
```

***

## Methods

### __construct

```php
public __construct(string $keyId, string $keySecret): mixed
```

**Parameters:**

| Parameter    | Type       | Description                                        |
|--------------|------------|----------------------------------------------------|
| `$keyId`     | **string** | The API Key ID provided by Apple.                  |
| `$keySecret` | **string** | The API Secret provided by Apple (Base64 encoded). |

***

### sign

Generate the Authorization header and date for a request.

```php
public sign(string $method, string $url, string|null $contentType = null, string|null $body = null, \DateTimeInterface|null $date = null): array{authorization: string, date: string}
```

**Parameters:**

| Parameter      | Type                         | Description                                                                 |
|----------------|------------------------------|-----------------------------------------------------------------------------|
| `$method`      | **string**                   | HTTP method (GET, POST, DELETE, etc.)                                       |
| `$url`         | **string**                   | The full request URL including protocol and query params.                   |
| `$contentType` | **string\|null**             | Required for POST requests (e.g., application/json or multipart/form-data). |
| `$body`        | **string\|null**             | Required for POST requests. The raw body content to sign.                   |
| `$date`        | **\DateTimeInterface\|null** | The date for the signature. Defaults to current UTC time.                   |

**Return Value:**

Returns the header value and the date string used.

**Throws:**

if the secret key cannot be decoded.
- [`InvalidArgumentException`](./)

***

### buildCanonicalRequest

Build the canonical request string used as input for the HMAC hash.

```php
private buildCanonicalRequest(string $method, string $url, string $date, string|null $contentType, string|null $body): string
```

For GET/DELETE: method + url + date
For POST: method + url + date + content-type + body

**Parameters:**

| Parameter      | Type             | Description            |
|----------------|------------------|------------------------|
| `$method`      | **string**       | Uppercase HTTP method. |
| `$url`         | **string**       | Full request URL.      |
| `$date`        | **string**       | ISO 8601 date string.  |
| `$contentType` | **string\|null** | Content type string.   |
| `$body`        | **string\|null** | Raw body content.      |

***

### createSignature

Create the HMAC-SHA256 signature from the canonical request.

```php
private createSignature(string $canonicalRequest): string
```

**Parameters:**

| Parameter           | Type       | Description         |
|---------------------|------------|---------------------|
| `$canonicalRequest` | **string** | The string to hash. |

**Return Value:**

Base64 encoded signature.

**Throws:**

if the secret is not valid Base64.
- [`InvalidArgumentException`](./)

***

### getKeyId

Get the configured API Key ID.

```php
public getKeyId(): string
```

***
