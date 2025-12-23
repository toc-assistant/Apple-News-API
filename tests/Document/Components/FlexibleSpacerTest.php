<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Components;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Components\FlexibleSpacer;

final class FlexibleSpacerTest extends TestCase
{
    public function testFlexibleSpacerBasic(): void
    {
        $spacer = new FlexibleSpacer();

        $data = $spacer->jsonSerialize();

        $this->assertSame('flexible_spacer', $data['role']);
    }

    public function testFlexibleSpacerWithIdentifier(): void
    {
        $spacer = (new FlexibleSpacer())
            ->setIdentifier('main-spacer');

        $data = $spacer->jsonSerialize();

        $this->assertSame('flexible_spacer', $data['role']);
        $this->assertSame('main-spacer', $data['identifier']);
    }

    public function testFlexibleSpacerWithLayout(): void
    {
        $spacer = (new FlexibleSpacer())
            ->setLayout('spacerLayout');

        $data = $spacer->jsonSerialize();

        $this->assertSame('spacerLayout', $data['layout']);
    }
}

