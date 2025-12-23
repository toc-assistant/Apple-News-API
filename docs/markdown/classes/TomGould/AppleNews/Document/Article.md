
Represents an Apple News Format (ANF) article document.

The Article class is the root of the document tree. It holds the content
(components), layouts, text styles, and metadata. When serialized to JSON,
it produces the `article.json` file required by the Apple News API.

***

* Full name: `\TomGould\AppleNews\Document\Article`
* This class is marked as **final** and can't be subclassed
* This class implements:
  `JsonSerializable`
* This class is a **Final class**

**See Also:**

* https://developer.apple.com/documentation/applenewsformat/articledocument

## Constants

| Constant          | Visibility | Type | Value  |
|-------------------|------------|------|--------|
| `CURRENT_VERSION` | private    |      | '1.24' |

## Properties

### components

```php
private \TomGould\AppleNews\Document\Components\Component[] $components
```

***

### componentLayouts

```php
private array<string,mixed> $componentLayouts
```

***

### componentTextStyles

```php
private array<string,\TomGould\AppleNews\Document\Styles\ComponentTextStyle> $componentTextStyles
```

***

### componentStyles

```php
private array<string,mixed> $componentStyles
```

***

### metadata

```php
private ?\TomGould\AppleNews\Document\Metadata $metadata
```

***

### documentStyle

```php
private ?\TomGould\AppleNews\Document\Styles\DocumentStyle $documentStyle
```

***

### autoplacement

```php
private array<string,mixed> $autoplacement
```

***

### identifier

```php
private string $identifier
```

***

### title

```php
private string $title
```

***

### language

```php
private string $language
```

***

### layout

```php
private \TomGould\AppleNews\Document\Layouts\Layout $layout
```

***

### version

```php
private string $version
```

***

## Methods

### __construct

```php
public __construct(string $identifier, string $title, string $language, \TomGould\AppleNews\Document\Layouts\Layout $layout, string $version = \self::CURRENT_VERSION): mixed
```

**Parameters:**

| Parameter     | Type                                            | Description                                                          |
|---------------|-------------------------------------------------|----------------------------------------------------------------------|
| `$identifier` | **string**                                      | Unique ID for the article (for your internal reference).             |
| `$title`      | **string**                                      | The article title (not necessarily displayed, but used in metadata). |
| `$language`   | **string**                                      | ISO language code (e.g., 'en', 'fr').                                |
| `$layout`     | **\TomGould\AppleNews\Document\Layouts\Layout** | The column system layout for the article.                            |
| `$version`    | **string**                                      | The ANF version.                                                     |

***

### create

Static factory to create a new article with a standard default layout.

```php
public static create(string $identifier, string $title, string $language = 'en', int $columns = 7, int $width = 1024): self
```

* This method is **static**.
**Parameters:**

| Parameter     | Type       | Description                          |
|---------------|------------|--------------------------------------|
| `$identifier` | **string** | Your internal unique ID.             |
| `$title`      | **string** | Article title.                       |
| `$language`   | **string** | ISO language code.                   |
| `$columns`    | **int**    | Number of grid columns (default 7).  |
| `$width`      | **int**    | Grid width in points (default 1024). |

***

### addComponent

Add a single component to the article.

```php
public addComponent(\TomGould\AppleNews\Document\Components\Component $component): self
```

**Parameters:**

| Parameter    | Type                                                  | Description                                       |
|--------------|-------------------------------------------------------|---------------------------------------------------|
| `$component` | **\TomGould\AppleNews\Document\Components\Component** | Any component extending the base Component class. |

***

### addComponents

Add multiple components at once.

```php
public addComponents(\TomGould\AppleNews\Document\Components\Component[] $components): self
```

**Parameters:**

| Parameter     | Type                                                    | Description |
|---------------|---------------------------------------------------------|-------------|
| `$components` | **\TomGould\AppleNews\Document\Components\Component[]** |             |

***

### addComponentLayout

Define a reusable component layout by name.

```php
public addComponentLayout(string $name, array<string,mixed> $layout): self
```

**Parameters:**

| Parameter | Type                    | Description                                              |
|-----------|-------------------------|----------------------------------------------------------|
| `$name`   | **string**              | The name of the layout (used in Component::setLayout()). |
| `$layout` | **array<string,mixed>** | Associative array of layout properties.                  |

**See Also:**

* https://developer.apple.com/documentation/applenewsformat/componentlayout

***

### addComponentTextStyle

Define a reusable text style by name.

```php
public addComponentTextStyle(string $name, \TomGould\AppleNews\Document\Styles\ComponentTextStyle $style): self
```

**Parameters:**

| Parameter | Type                                                       | Description                                                |
|-----------|------------------------------------------------------------|------------------------------------------------------------|
| `$name`   | **string**                                                 | Name of the style (used in TextComponent::setTextStyle()). |
| `$style`  | **\TomGould\AppleNews\Document\Styles\ComponentTextStyle** | Style object.                                              |

**See Also:**

* https://developer.apple.com/documentation/applenewsformat/componenttextstyle

***

### addComponentStyle

Define a reusable component style (borders, fills, etc.) by name.

```php
public addComponentStyle(string $name, array<string,mixed> $style): self
```

**Parameters:**

| Parameter | Type                    | Description                                        |
|-----------|-------------------------|----------------------------------------------------|
| `$name`   | **string**              | Name of the style (used in Component::setStyle()). |
| `$style`  | **array<string,mixed>** | Associative array of style properties.             |

**See Also:**

* https://developer.apple.com/documentation/applenewsformat/componentstyle

***

### setMetadata

Set the article-level metadata.

```php
public setMetadata(\TomGould\AppleNews\Document\Metadata $metadata): self
```

**Parameters:**

| Parameter   | Type                                      | Description |
|-------------|-------------------------------------------|-------------|
| `$metadata` | **\TomGould\AppleNews\Document\Metadata** |             |

***

### setDocumentStyle

Set the overall document style (e.g., background color).

```php
public setDocumentStyle(\TomGould\AppleNews\Document\Styles\DocumentStyle $style): self
```

**Parameters:**

| Parameter | Type                                                  | Description |
|-----------|-------------------------------------------------------|-------------|
| `$style`  | **\TomGould\AppleNews\Document\Styles\DocumentStyle** |             |

***

### setAutoplacement

Set autoplacement configuration for ads or related articles.

```php
public setAutoplacement(array<string,mixed> $autoplacement): self
```

**Parameters:**

| Parameter        | Type                    | Description |
|------------------|-------------------------|-------------|
| `$autoplacement` | **array<string,mixed>** |             |

**See Also:**

* https://developer.apple.com/documentation/applenewsformat/autoplacement

***

### getIdentifier

Get the article identifier.

```php
public getIdentifier(): string
```

***

### getTitle

Get the article title.

```php
public getTitle(): string
```

***

### getComponents

Get all components currently in the article.

```php
public getComponents(): \TomGould\AppleNews\Document\Components\Component[]
```

***

### toJson

Convert the entire article to a JSON string.

```php
public toJson(int $flags = \TomGould\AppleNews\Document\JSON_PRETTY_PRINT | \TomGould\AppleNews\Document\JSON_UNESCAPED_SLASHES): string
```

**Parameters:**

| Parameter | Type    | Description          |
|-----------|---------|----------------------|
| `$flags`  | **int** | JSON encoding flags. |

**Throws:**

if serialization fails.
- [`JsonException`](JsonException.md)

***

### jsonSerialize

Required for JsonSerializable implementation.

```php
public jsonSerialize(): array<string,mixed>
```

***
