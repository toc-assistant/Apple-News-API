<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Enum;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Enum\ArticleState;

final class ArticleStateTest extends TestCase
{
    public function testAllStatesHaveCorrectValues(): void
    {
        $this->assertSame('PROCESSING', ArticleState::PROCESSING->value);
        $this->assertSame('LIVE', ArticleState::LIVE->value);
        $this->assertSame('PROCESSING_UPDATE', ArticleState::PROCESSING_UPDATE->value);
        $this->assertSame('TAKEN_DOWN', ArticleState::TAKEN_DOWN->value);
        $this->assertSame('FAILED_PROCESSING', ArticleState::FAILED_PROCESSING->value);
        $this->assertSame('FAILED_PROCESSING_UPDATE', ArticleState::FAILED_PROCESSING_UPDATE->value);
        $this->assertSame('DUPLICATE', ArticleState::DUPLICATE->value);
    }

    public function testTryFromWithValidState(): void
    {
        $state = ArticleState::tryFrom('LIVE');
        $this->assertSame(ArticleState::LIVE, $state);
    }

    public function testTryFromWithInvalidState(): void
    {
        $state = ArticleState::tryFrom('INVALID');
        $this->assertNull($state);
    }

    public function testIsLive(): void
    {
        $this->assertTrue(ArticleState::LIVE->isLive());
        $this->assertTrue(ArticleState::PROCESSING_UPDATE->isLive());
        $this->assertFalse(ArticleState::PROCESSING->isLive());
        $this->assertFalse(ArticleState::TAKEN_DOWN->isLive());
        $this->assertFalse(ArticleState::FAILED_PROCESSING->isLive());
        $this->assertFalse(ArticleState::DUPLICATE->isLive());
    }

    public function testIsProcessing(): void
    {
        $this->assertTrue(ArticleState::PROCESSING->isProcessing());
        $this->assertTrue(ArticleState::PROCESSING_UPDATE->isProcessing());
        $this->assertFalse(ArticleState::LIVE->isProcessing());
        $this->assertFalse(ArticleState::TAKEN_DOWN->isProcessing());
    }

    public function testHasFailed(): void
    {
        $this->assertTrue(ArticleState::FAILED_PROCESSING->hasFailed());
        $this->assertTrue(ArticleState::FAILED_PROCESSING_UPDATE->hasFailed());
        $this->assertFalse(ArticleState::LIVE->hasFailed());
        $this->assertFalse(ArticleState::PROCESSING->hasFailed());
        $this->assertFalse(ArticleState::DUPLICATE->hasFailed());
    }
}
