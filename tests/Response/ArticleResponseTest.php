<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Response;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Enum\ArticleState;
use TomGould\AppleNews\Response\ArticleResponse;

final class ArticleResponseTest extends TestCase
{
    public function testFromApiResponseWithFullData(): void
    {
        $response = [
            'data' => [
                'id' => 'article-123',
                'type' => 'article',
                'title' => 'Test Article',
                'revision' => 'AAAAAAAAAAD',
                'state' => 'LIVE',
                'shareUrl' => 'https://apple.news/article-123',
                'createdAt' => '2024-01-15T10:00:00Z',
                'modifiedAt' => '2024-01-15T12:00:00Z',
                'isSponsored' => false,
                'isPreview' => false,
                'isCandidateToBeFeatured' => true,
                'maturityRating' => 'GENERAL',
                'warnings' => [
                    ['code' => 'TRUNCATED_CONTENT', 'message' => 'Content was truncated'],
                ],
            ],
            'links' => [
                'channel' => 'https://news-api.apple.com/channels/channel-123',
                'self' => 'https://news-api.apple.com/articles/article-123',
                'sections' => ['https://news-api.apple.com/sections/section-1'],
            ],
            'meta' => [
                'throttling' => [
                    'estimatedDelayInSeconds' => 0,
                    'queueSize' => 0,
                    'quotaAvailable' => 95,
                ],
            ],
        ];

        $articleResponse = ArticleResponse::fromApiResponse($response);

        $this->assertSame('article-123', $articleResponse->id);
        $this->assertSame('Test Article', $articleResponse->title);
        $this->assertSame('AAAAAAAAAAD', $articleResponse->revision);
        $this->assertSame(ArticleState::LIVE, $articleResponse->state);
        $this->assertFalse($articleResponse->isSponsored);
        $this->assertTrue($articleResponse->isCandidateToBeFeatured);
        
        $this->assertNotNull($articleResponse->links);
        $this->assertSame('https://news-api.apple.com/channels/channel-123', $articleResponse->links->channel);
        
        $this->assertNotNull($articleResponse->meta);
        $this->assertNotNull($articleResponse->getThrottling());
        $this->assertSame(95, $articleResponse->getThrottling()->quotaAvailable);
        
        $this->assertTrue($articleResponse->hasWarnings());
        $this->assertCount(1, $articleResponse->warnings);
        $this->assertSame('TRUNCATED_CONTENT', $articleResponse->warnings[0]->code);
    }

    public function testFromApiResponseWithMinimalData(): void
    {
        $response = [
            'data' => [
                'id' => 'article-456',
                'title' => 'Minimal Article',
                'revision' => 'BBBBBBBBBBB',
            ],
        ];

        $articleResponse = ArticleResponse::fromApiResponse($response);

        $this->assertSame('article-456', $articleResponse->id);
        $this->assertSame('Minimal Article', $articleResponse->title);
        $this->assertNull($articleResponse->state);
        $this->assertNull($articleResponse->links);
        $this->assertNull($articleResponse->meta);
        $this->assertFalse($articleResponse->hasWarnings());
    }

    public function testArticleStateHelperMethods(): void
    {
        $this->assertTrue(ArticleState::LIVE->isLive());
        $this->assertTrue(ArticleState::PROCESSING_UPDATE->isLive());
        $this->assertFalse(ArticleState::PROCESSING->isLive());

        $this->assertTrue(ArticleState::PROCESSING->isProcessing());
        $this->assertTrue(ArticleState::PROCESSING_UPDATE->isProcessing());
        $this->assertFalse(ArticleState::LIVE->isProcessing());

        $this->assertTrue(ArticleState::FAILED_PROCESSING->hasFailed());
        $this->assertTrue(ArticleState::FAILED_PROCESSING_UPDATE->hasFailed());
        $this->assertFalse(ArticleState::LIVE->hasFailed());
    }
}

