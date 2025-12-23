<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Enum;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Enum\MaturityRating;

final class MaturityRatingTest extends TestCase
{
    public function testAllRatingsHaveCorrectValues(): void
    {
        $this->assertSame('KIDS', MaturityRating::KIDS->value);
        $this->assertSame('GENERAL', MaturityRating::GENERAL->value);
        $this->assertSame('MATURE', MaturityRating::MATURE->value);
    }

    public function testTryFromWithValidRating(): void
    {
        $rating = MaturityRating::tryFrom('GENERAL');
        $this->assertSame(MaturityRating::GENERAL, $rating);
    }

    public function testTryFromWithInvalidRating(): void
    {
        $rating = MaturityRating::tryFrom('INVALID');
        $this->assertNull($rating);
    }

    public function testFromWithValidRating(): void
    {
        $rating = MaturityRating::from('MATURE');
        $this->assertSame(MaturityRating::MATURE, $rating);
    }
}

