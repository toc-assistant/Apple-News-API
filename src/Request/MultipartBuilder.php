<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Request;

use InvalidArgumentException;
use RuntimeException;
use JsonException;

/**
 * Builds multipart/form-data request bodies for the Apple News API.
 *
 * Apple News requires articles to be submitted as MIME multipart messages.
 * The message MUST contain an 'article.json' part and can optionally include
 * a 'metadata' part and binary parts for bundle resources (images, fonts, etc.).
 *
 * @see https://developer.apple.com/documentation/apple_news/apple_news_api/create_an_article
 */
final class MultipartBuilder
{
    private const CRLF = "\r\n";

    private string $boundary;

    /** @var array<int, array{name: string, filename: string|null, contentType: string, content: string}> */
    private array $parts = [];

    /**
     * @param string|null $boundary Optional custom boundary string.
     */
    public function __construct(?string $boundary = null)
    {
        $this->boundary = $boundary ?? bin2hex(random_bytes(16));
    }

    /**
     * Add a JSON part to the multipart body.
     *
     * @param string $name The part name (e.g., 'article.json', 'metadata').
     * @param string $json The JSON string.
     * @param string|null $filename Optional filename for the part.
     * @return self
     */
    public function addJson(string $name, string $json, ?string $filename = null): self
    {
        return $this->addPart($name, $json, 'application/json', $filename ?? $name);
    }

    /**
     * Convenience method to add the 'article.json' document part.
     *
     * @param string $json The ANF JSON string.
     * @return self
     */
    public function addArticle(string $json): self
    {
        return $this->addJson('article.json', $json, 'article.json');
    }

    /**
     * Convenience method to add article metadata.
     *
     * @param array<string, mixed> $metadata Metadata array (wrapped in 'data' key automatically).
     * @return self
     * @throws JsonException
     */
    public function addMetadata(array $metadata): self
    {
        return $this->addJson('metadata', json_encode(['data' => $metadata], JSON_THROW_ON_ERROR));
    }

    /**
     * Add an image part from a local file path.
     *
     * @param string $name The part name/bundle identifier.
     * @param string $filePath Absolute path to the local file.
     * @return self
     * @throws InvalidArgumentException if file doesn't exist.
     * @throws RuntimeException if file cannot be read.
     */
    public function addImageFile(string $name, string $filePath): self
    {
        if (!file_exists($filePath)) {
            throw new InvalidArgumentException("Asset file not found: {$filePath}");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new RuntimeException("Failed to read asset file: {$filePath}");
        }

        $contentType = $this->guessImageContentType($filePath);
        $filename = basename($filePath);

        return $this->addPart($name, $content, $contentType, $filename);
    }

    /**
     * Add an image part from raw binary content.
     *
     * @param string $name The part name.
     * @param string $content Raw binary data.
     * @param string $filename The filename to present in the part header.
     * @param string|null $contentType Optional MIME type. Guessed from filename if null.
     * @return self
     */
    public function addImage(string $name, string $content, string $filename, ?string $contentType = null): self
    {
        $contentType ??= $this->guessImageContentType($filename);
        return $this->addPart($name, $content, $contentType, $filename);
    }

    /**
     * Add a font file part.
     *
     * @param string $name The part name.
     * @param string $content Raw binary font data.
     * @param string $filename The font filename.
     * @return self
     */
    public function addFont(string $name, string $content, string $filename): self
    {
        return $this->addPart($name, $content, 'application/octet-stream', $filename);
    }

    /**
     * Core method to add a generic part to the multipart body.
     *
     * @param string $name Part name.
     * @param string $content Content data.
     * @param string $contentType MIME content type.
     * @param string|null $filename Optional filename.
     * @return self
     */
    public function addPart(string $name, string $content, string $contentType, ?string $filename = null): self
    {
        $this->parts[] = [
            'name' => $name,
            'filename' => $filename,
            'contentType' => $contentType,
            'content' => $content,
        ];

        return $this;
    }

    /**
     * Build the complete multipart raw body string.
     * @return string
     */
    public function build(): string
    {
        $body = '';

        foreach ($this->parts as $part) {
            $body .= '--' . $this->boundary . self::CRLF;
            $body .= 'Content-Type: ' . $part['contentType'] . self::CRLF;

            $disposition = 'Content-Disposition: form-data';
            if ($part['filename'] !== null) {
                $disposition .= '; filename=' . $part['filename'];
            }
            $disposition .= '; name=' . $part['name'];
            $disposition .= '; size=' . strlen($part['content']);

            $body .= $disposition . self::CRLF;
            $body .= self::CRLF;
            $body .= $part['content'] . self::CRLF;
        }

        $body .= '--' . $this->boundary . '--' . self::CRLF;

        return $body;
    }

    /**
     * Get the full Content-Type header value required for this request.
     * @return string
     */
    public function getContentType(): string
    {
        return 'multipart/form-data; boundary=' . $this->boundary;
    }

    /**
     * Get the random boundary string used.
     * @return string
     */
    public function getBoundary(): string
    {
        return $this->boundary;
    }

    /**
     * Guess the MIME content type based on the file extension.
     *
     * @param string $filename
     * @return string
     */
    private function guessImageContentType(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        return match ($extension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            default => 'application/octet-stream',
        };
    }
}

