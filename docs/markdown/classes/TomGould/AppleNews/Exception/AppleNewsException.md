
Base exception class for all errors returned by the Apple News API.

This class parses the standardized error format returned by Apple and
provides access to specific API error codes and key paths (field names).

***

* Full name: `\TomGould\AppleNews\Exception\AppleNewsException`
* Parent class: [`Exception`](../../../Exception.md)

## Properties

### errorCode

```php
protected string|null $errorCode
```

***

### keyPath

```php
protected string|null $keyPath
```

***

## Methods

### __construct

```php
public __construct(string $message = '', int $code = 0, \Throwable|null $previous = null, string|null $errorCode = null, string|null $keyPath = null): mixed
```

**Parameters:**

| Parameter    | Type                 | Description                      |
|--------------|----------------------|----------------------------------|
| `$message`   | **string**           | Exception message.               |
| `$code`      | **int**              | HTTP status code.                |
| `$previous`  | **\Throwable\|null** | Previous exception.              |
| `$errorCode` | **string\|null**     | API-specific error code.         |
| `$keyPath`   | **string\|null**     | Field path where error occurred. |

***

### getErrorCode

Get the specific Apple News API error code (e.g., INVALID_REVISION).

```php
public getErrorCode(): string|null
```

***

### getKeyPath

Get the path to the field that failed validation.

```php
public getKeyPath(): string|null
```

***

### fromResponse

Factory method to create an exception from a standard API error response.

```php
public static fromResponse(array<string,mixed> $response, int $httpCode = 0): self
```

* This method is **static**.
**Parameters:**

| Parameter   | Type                    | Description                         |
|-------------|-------------------------|-------------------------------------|
| `$response` | **array<string,mixed>** | Decoded JSON error response.        |
| `$httpCode` | **int**                 | HTTP status code from the response. |

***
