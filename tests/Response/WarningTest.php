<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Response;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Response\Warning;

final class WarningTest extends TestCase
{
    public function testFromArrayWithAllFields(): void
    {
        $data = [
            'code' => 'INVALID_FIELD',
            'keyPath' => 'data.title',
            'message' => 'Title is too long',
        ];

        $warning = Warning::fromArray($data);

        $this->assertSame('INVALID_FIELD', $warning->code);
        $this->assertSame('data.title', $warning->keyPath);
        $this->assertSame('Title is too long', $warning->message);
    }

    public function testFromArrayWithMissingFields(): void
    {
        $warning = Warning::fromArray([]);

        $this->assertSame('UNKNOWN', $warning->code);
        $this->assertNull($warning->keyPath);
        $this->assertNull($warning->message);
    }

    public function testFromArrayList(): void
    {
        $data = [
            ['code' => 'WARNING_1', 'message' => 'First warning'],
            ['code' => 'WARNING_2', 'message' => 'Second warning'],
        ];

        $warnings = Warning::fromArrayList($data);

        $this->assertCount(2, $warnings);
        $this->assertSame('WARNING_1', $warnings[0]->code);
        $this->assertSame('WARNING_2', $warnings[1]->code);
    }
}

