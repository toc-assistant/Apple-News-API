<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Client;

use TomGould\AppleNews\Document\Article;
use TomGould\AppleNews\Exception\AppleNewsException;
use TomGould\AppleNews\Exception\AuthenticationException;
use TomGould\AppleNews\Request\MultipartBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Apple News Publisher API Client.
 *
 * This class provides high-level methods to interact with the Apple News API,
 * including channel information retrieval, section management, and article
 * CRUD (Create, Read, Update, Delete) operations.
 *
 * It uses PSR-18 for HTTP requests and PSR-17 for message factories to ensure
 * compatibility with any modern PHP HTTP library.
 *
 * @see https://developer.apple.com/documentation/apple_news/apple_news_api
 */
final class AppleNewsClient
{
    private const API_ENDPOINT = 'https://news-api.apple.com';

    /**
     * @param Authenticator $authenticator Handles request signing.
     * @param ClientInterface $httpClient PSR-18 HTTP client.
     * @param RequestFactoryInterface $requestFactory PSR-17 request factory.
     * @param StreamFactoryInterface $streamFactory PSR-17 stream factory.
     * @param string $endpoint The base URL for the API.
     */
    public function __construct(
        private readonly Authenticator $authenticator,
        private readonly ClientInterface $httpClient,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory,
        private readonly string $endpoint = self::API_ENDPOINT
    ) {
    }

    /**
     * Factory method to create a client with the given credentials.
     *
     * @param string $keyId Your Apple News API Key ID.
     * @param string $keySecret Your Apple News API Key Secret (Base64 encoded).
     * @param ClientInterface $httpClient A PSR-18 compliant HTTP client.
     * @param RequestFactoryInterface $requestFactory A PSR-17 compliant request factory.
     * @param StreamFactoryInterface $streamFactory A PSR-17 compliant stream factory.
     * @param string $endpoint Optional override for the API endpoint.
     * @return self
     */
    public static function create(
        string $keyId,
        string $keySecret,
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        string $endpoint = self::API_ENDPOINT
    ): self {
        return new self(
            new Authenticator($keyId, $keySecret),
            $httpClient,
            $requestFactory,
            $streamFactory,
            $endpoint
        );
    }

    // ========================================
    // Channel Operations
    // ========================================

    /**
     * Get channel information.
     *
     * @param string $channelId The unique identifier for the channel.
     * @return array<string, mixed> The decoded API response.
     * @throws AppleNewsException If the API returns an error.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/get_channel_information
     */
    public function getChannel(string $channelId): array
    {
        return $this->get("/channels/{$channelId}");
    }

    /**
     * Get channel quota information.
     *
     * @param string $channelId The unique identifier for the channel.
     * @return array<string, mixed> The decoded API response.
     * @throws AppleNewsException If the API returns an error.
     */
    public function getChannelQuota(string $channelId): array
    {
        return $this->get("/channels/{$channelId}/quota");
    }

    // ========================================
    // Section Operations
    // ========================================

    /**
     * List all sections in a channel.
     *
     * @param string $channelId The unique identifier for the channel.
     * @return array<string, mixed> The decoded API response containing section list.
     * @throws AppleNewsException If the API returns an error.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/list_sections
     */
    public function listSections(string $channelId): array
    {
        return $this->get("/channels/{$channelId}/sections");
    }

    /**
     * Get section information.
     *
     * @param string $sectionId The unique identifier for the section.
     * @return array<string, mixed> The decoded API response.
     * @throws AppleNewsException If the API returns an error.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/get_section_information
     */
    public function getSection(string $sectionId): array
    {
        return $this->get("/sections/{$sectionId}");
    }

    /**
     * Promote articles in a section.
     *
     * @param string $sectionId The unique identifier for the section.
     * @param array<string> $articleIds List of article IDs to promote.
     * @return array<string, mixed> The decoded API response.
     * @throws AppleNewsException If the API returns an error.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/promote_articles_in_a_section
     */
    public function promoteArticles(string $sectionId, array $articleIds): array
    {
        $body = json_encode([
            'data' => [
                'promotedArticles' => $articleIds,
            ],
        ], JSON_THROW_ON_ERROR);

        return $this->postJson("/sections/{$sectionId}/promotedArticles", $body);
    }

    // ========================================
    // Article Operations
    // ========================================

    /**
     * Create a new article.
     *
     * Handles the multipart submission of the article JSON, metadata, and
     * any bundled assets (images, fonts).
     *
     * @param string $channelId The channel to publish to.
     * @param Article $article The article document object.
     * @param array<string, mixed>|null $metadata Optional metadata (sections, isSponsored, etc.)
     * @param array<string, string> $assets Map of bundle:// URLs to file paths or raw binary content.
     * @return array<string, mixed> The decoded API response (including article ID).
     * @throws AppleNewsException If the API returns an error.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/create_an_article
     */
    public function createArticle(
        string $channelId,
        Article $article,
        ?array $metadata = null,
        array $assets = []
    ): array {
        $builder = new MultipartBuilder();
        $builder->addArticle($article->toJson());

        if ($metadata !== null) {
            $builder->addMetadata($metadata);
        }

        foreach ($assets as $bundleUrl => $asset) {
            $filename = str_replace('bundle://', '', $bundleUrl);
            if (file_exists($asset)) {
                $builder->addImageFile($filename, $asset);
            } else {
                // Assume it's binary content
                $builder->addImage($filename, $asset, $filename);
            }
        }

        return $this->postMultipart("/channels/{$channelId}/articles", $builder);
    }

    /**
     * Create an article from raw JSON.
     *
     * Useful if you already have the ANF JSON generated by another tool.
     *
     * @param string $channelId The channel to publish to.
     * @param string $articleJson The raw ANF JSON string.
     * @param array<string, mixed>|null $metadata Optional metadata.
     * @param array<string, string> $assets Map of bundle URLs to local paths/content.
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    public function createArticleFromJson(
        string $channelId,
        string $articleJson,
        ?array $metadata = null,
        array $assets = []
    ): array {
        $builder = new MultipartBuilder();
        $builder->addArticle($articleJson);

        if ($metadata !== null) {
            $builder->addMetadata($metadata);
        }

        foreach ($assets as $bundleUrl => $asset) {
            $filename = str_replace('bundle://', '', $bundleUrl);
            if (file_exists($asset)) {
                $builder->addImageFile($filename, $asset);
            } else {
                $builder->addImage($filename, $asset, $filename);
            }
        }

        return $this->postMultipart("/channels/{$channelId}/articles", $builder);
    }

    /**
     * Get article information.
     *
     * @param string $articleId Unique article ID.
     * @return array<string, mixed>
     * @throws AppleNewsException
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/read_article_information
     */
    public function getArticle(string $articleId): array
    {
        return $this->get("/articles/{$articleId}");
    }

    /**
     * Search articles in a channel.
     *
     * @param string $channelId The channel ID to search within.
     * @param array<string, mixed> $params Search parameters like pageSize, pageToken, fromDate, toDate.
     * @return array<string, mixed>
     * @throws AppleNewsException
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/search_articles
     */
    public function searchArticlesInChannel(string $channelId, array $params = []): array
    {
        $query = http_build_query($params);
        $path = "/channels/{$channelId}/articles";
        if ($query !== '') {
            $path .= '?' . $query;
        }

        return $this->get($path);
    }

    /**
     * Search articles in a section.
     *
     * @param string $sectionId The section ID to search within.
     * @param array<string, mixed> $params Search parameters.
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    public function searchArticlesInSection(string $sectionId, array $params = []): array
    {
        $query = http_build_query($params);
        $path = "/sections/{$sectionId}/articles";
        if ($query !== '') {
            $path .= '?' . $query;
        }

        return $this->get($path);
    }

    /**
     * Update an existing article.
     *
     * Updating an article requires the 'revision' string found in the
     * information of the existing article.
     *
     * @param string $articleId The ID of the article to update.
     * @param string $revision The revision token from the previous get/create response.
     * @param Article $article The updated article object.
     * @param array<string, mixed>|null $metadata Optional metadata.
     * @param array<string, string> $assets Assets for the updated article.
     * @return array<string, mixed>
     * @throws AppleNewsException
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/update_an_article
     */
    public function updateArticle(
        string $articleId,
        string $revision,
        Article $article,
        ?array $metadata = null,
        array $assets = []
    ): array {
        $builder = new MultipartBuilder();
        $builder->addArticle($article->toJson());

        // Revision is required for updates
        $meta = $metadata ?? [];
        $meta['revision'] = $revision;
        $builder->addMetadata($meta);

        foreach ($assets as $bundleUrl => $asset) {
            $filename = str_replace('bundle://', '', $bundleUrl);
            if (file_exists($asset)) {
                $builder->addImageFile($filename, $asset);
            } else {
                $builder->addImage($filename, $asset, $filename);
            }
        }

        return $this->postMultipart("/articles/{$articleId}", $builder);
    }

    /**
     * Delete an article.
     *
     * @param string $articleId The article ID to delete.
     * @throws AppleNewsException If deletion fails.
     * @see https://developer.apple.com/documentation/apple_news/apple_news_api/delete_an_article
     */
    public function deleteArticle(string $articleId): void
    {
        $this->delete("/articles/{$articleId}");
    }

    // ========================================
    // HTTP Internal Methods
    // ========================================

    /**
     * Perform a signed GET request.
     *
     * @param string $path The API path (excluding domain).
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    private function get(string $path): array
    {
        $url = $this->endpoint . $path;
        $auth = $this->authenticator->sign('GET', $url);

        $request = $this->requestFactory
            ->createRequest('GET', $url)
            ->withHeader('Authorization', $auth['authorization'])
            ->withHeader('Accept', 'application/json');

        return $this->sendRequest($request);
    }

    /**
     * Perform a signed POST request with JSON body.
     *
     * @param string $path The API path.
     * @param string $body The JSON encoded body.
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    private function postJson(string $path, string $body): array
    {
        $url = $this->endpoint . $path;
        $contentType = 'application/json';
        $auth = $this->authenticator->sign('POST', $url, $contentType, $body);

        $request = $this->requestFactory
            ->createRequest('POST', $url)
            ->withHeader('Authorization', $auth['authorization'])
            ->withHeader('Content-Type', $contentType)
            ->withHeader('Accept', 'application/json')
            ->withBody($this->streamFactory->createStream($body));

        return $this->sendRequest($request);
    }

    /**
     * Perform a signed POST request with a multipart body.
     *
     * @param string $path The API path.
     * @param MultipartBuilder $builder The builder containing the parts.
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    private function postMultipart(string $path, MultipartBuilder $builder): array
    {
        $url = $this->endpoint . $path;
        $body = $builder->build();
        $contentType = $builder->getContentType();
        $auth = $this->authenticator->sign('POST', $url, $contentType, $body);

        $request = $this->requestFactory
            ->createRequest('POST', $url)
            ->withHeader('Authorization', $auth['authorization'])
            ->withHeader('Content-Type', $contentType)
            ->withHeader('Accept', 'application/json')
            ->withBody($this->streamFactory->createStream($body));

        return $this->sendRequest($request);
    }

    /**
     * Perform a signed DELETE request.
     *
     * @param string $path The API path.
     * @throws AppleNewsException
     */
    private function delete(string $path): void
    {
        $url = $this->endpoint . $path;
        $auth = $this->authenticator->sign('DELETE', $url);

        $request = $this->requestFactory
            ->createRequest('DELETE', $url)
            ->withHeader('Authorization', $auth['authorization']);

        $response = $this->httpClient->sendRequest($request);
        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode >= 300) {
            $this->handleErrorResponse($response->getBody()->getContents(), $statusCode);
        }
    }

    /**
     * Helper to send a PSR-7 request and decode the JSON response.
     *
     * @param RequestInterface $request The signed request.
     * @return array<string, mixed>
     * @throws AppleNewsException
     */
    private function sendRequest(RequestInterface $request): array
    {
        $response = $this->httpClient->sendRequest($request);
        $statusCode = $response->getStatusCode();
        $body = $response->getBody()->getContents();

        if ($statusCode < 200 || $statusCode >= 300) {
            $this->handleErrorResponse($body, $statusCode);
        }

        if ($body === '') {
            return [];
        }

        try {
            return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new AppleNewsException('Invalid JSON response from API', $statusCode, $e);
        }
    }

    /**
     * Handle error responses from the API by throwing appropriate exceptions.
     *
     * @param string $body The raw response body.
     * @param int $statusCode The HTTP status code.
     * @throws AuthenticationException|AppleNewsException
     * @return never
     */
    private function handleErrorResponse(string $body, int $statusCode): never
    {
        try {
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new AppleNewsException("HTTP {$statusCode}: {$body}", $statusCode);
        }

        if ($statusCode === 401 || $statusCode === 403) {
            throw new AuthenticationException(
                $data['errors'][0]['message'] ?? 'Authentication failed',
                $statusCode,
                null,
                $data['errors'][0]['code'] ?? null
            );
        }

        throw AppleNewsException::fromResponse($data, $statusCode);
    }
}

