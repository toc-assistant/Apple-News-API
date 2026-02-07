<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Components;

use TomGould\AppleNews\Document\Components\Body;
use PHPUnit\Framework\TestCase;

final class TextComponentAdditionsTest extends TestCase
{
    public function testAdditionsCanBeSet(): void
    {
        $body = new Body('Hello world, check this link!');
        
        $additions = [
            [
                'type' => 'link',
                'rangeStart' => 19,
                'rangeLength' => 4,
                'URL' => 'https://example.com',
            ],
        ];
        
        $body->setAdditions($additions);
        
        $data = $body->jsonSerialize();
        
        $this->assertArrayHasKey('additions', $data);
        $this->assertEquals($additions, $data['additions']);
    }

    public function testAdditionsNotIncludedWhenNull(): void
    {
        $body = new Body('Simple text without links');
        
        $data = $body->jsonSerialize();
        
        $this->assertArrayNotHasKey('additions', $data);
    }
}
