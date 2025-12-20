<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Client;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

/**
 * Handles HMAC-SHA256 authentication for Apple News API requests.
 *
 * Apple News uses a custom HMAC authentication scheme (HHMAC) where requests are
 * signed using the API secret key. The signature is computed from a canonical
 * string including the method, URL, date, and optionally the body for POSTs.
 *
 * @see https://developer.apple.com/documentation/applenewsapi
 */
final class Authenticator
{
    private const DATE_FORMAT = 'Y-m-d\TH:i:s\Z';
    private const HASH_ALGORITHM = 'sha256';

    /**
     * @param string $keyId The API Key ID provided by Apple.
     * @param string $keySecret The API Secret provided by Apple (Base64 encoded).
     */
    public function __construct(
        private readonly string $keyId,
        private readonly string $keySecret
    ) {
    }

    /**
     * Generate the Authorization header and date for a request.
     *
     * @param string $method HTTP method (GET, POST, DELETE, etc.)
     * @param string $url The full request URL including protocol and query params.
     * @param string|null $contentType Required for POST requests (e.g., application/json or multipart/form-data).
     * @param string|null $body Required for POST requests. The raw body content to sign.
     * @param DateTimeInterface|null $date The date for the signature. Defaults to current UTC time.
     *
     * @return array{authorization: string, date: string} Returns the header value and the date string used.
     * @throws InvalidArgumentException if the secret key cannot be decoded.
     */
    public function sign(
        string $method,
        string $url,
        ?string $contentType = null,
        ?string $body = null,
        ?DateTimeInterface $date = null
    ): array {
        $date ??= new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $dateString = $date->format(self::DATE_FORMAT);

        $canonicalRequest = $this->buildCanonicalRequest(
            strtoupper($method),
            $url,
            $dateString,
            $contentType,
            $body
        );

        $signature = $this->createSignature($canonicalRequest);

        return [
            'authorization' => sprintf(
                'HHMAC; key=%s; signature=%s; date=%s',
                $this->keyId,
                $signature,
                $dateString
            ),
            'date' => $dateString,
        ];
    }

    /**
     * Build the canonical request string used as input for the HMAC hash.
     *
     * For GET/DELETE: method + url + date
     * For POST: method + url + date + content-type + body
     *
     * @param string $method Uppercase HTTP method.
     * @param string $url Full request URL.
     * @param string $date ISO 8601 date string.
     * @param string|null $contentType Content type string.
     * @param string|null $body Raw body content.
     * @return string
     */
    private function buildCanonicalRequest(
        string $method,
        string $url,
        string $date,
        ?string $contentType,
        ?string $body
    ): string {
        $canonical = $method . $url . $date;

        // POST requests include Content-Type and body in the signature
        if ($method === 'POST' && $contentType !== null && $body !== null) {
            $canonical .= $contentType . $body;
        }

        return $canonical;
    }

    /**
     * Create the HMAC-SHA256 signature from the canonical request.
     *
     * @param string $canonicalRequest The string to hash.
     * @return string Base64 encoded signature.
     * @throws InvalidArgumentException if the secret is not valid Base64.
     */
    private function createSignature(string $canonicalRequest): string
    {
        // The API secret is provided as a Base64-encoded string by Apple
        $decodedSecret = base64_decode($this->keySecret, true);

        if ($decodedSecret === false) {
            throw new InvalidArgumentException('Invalid Base64-encoded API secret provided to Authenticator.');
        }

        $hash = hash_hmac(self::HASH_ALGORITHM, $canonicalRequest, $decodedSecret, true);

        return base64_encode($hash);
    }

    /**
     * Get the configured API Key ID.
     * @return string
     */
    public function getKeyId(): string
    {
        return $this->keyId;
    }
}
