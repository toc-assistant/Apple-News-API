<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Response;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Response\Throttling;

final class ThrottlingTest extends TestCase
{
    public function testFromArrayWithAllFields(): void
    {
        $data = [
            'estimatedDelayInSeconds' => 5,
            'queueSize' => 10,
            'quotaAvailable' => 100,
        ];

        $throttling = Throttling::fromArray($data);

        $this->assertSame(5, $throttling->estimatedDelayInSeconds);
        $this->assertSame(10, $throttling->queueSize);
        $this->assertSame(100, $throttling->quotaAvailable);
    }

    public function testFromArrayWithMissingFields(): void
    {
        $throttling = Throttling::fromArray([]);

        $this->assertNull($throttling->estimatedDelayInSeconds);
        $this->assertNull($throttling->queueSize);
        $this->assertNull($throttling->quotaAvailable);
    }

    public function testShouldDelayWhenDelayExists(): void
    {
        $throttling = new Throttling(estimatedDelayInSeconds: 5);
        $this->assertTrue($throttling->shouldDelay());
    }

    public function testShouldDelayWhenNoDelay(): void
    {
        $throttling = new Throttling(estimatedDelayInSeconds: 0);
        $this->assertFalse($throttling->shouldDelay());
    }

    public function testShouldDelayWhenNull(): void
    {
        $throttling = new Throttling();
        $this->assertFalse($throttling->shouldDelay());
    }

    public function testIsQuotaLowWhenBelowThreshold(): void
    {
        $throttling = new Throttling(quotaAvailable: 5);
        $this->assertTrue($throttling->isQuotaLow(10));
    }

    public function testIsQuotaLowWhenAboveThreshold(): void
    {
        $throttling = new Throttling(quotaAvailable: 100);
        $this->assertFalse($throttling->isQuotaLow(10));
    }

    public function testIsQuotaLowWhenNull(): void
    {
        $throttling = new Throttling();
        $this->assertFalse($throttling->isQuotaLow());
    }
}

