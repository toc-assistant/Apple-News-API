<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Layouts;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Layouts\CollectionDisplay;
use TomGould\AppleNews\Document\Layouts\ContentDisplayInterface;
use TomGould\AppleNews\Document\Layouts\HorizontalStackDisplay;

final class ContentDisplayTest extends TestCase
{
    public function testHorizontalStackDisplay(): void
    {
        $display = new HorizontalStackDisplay();

        $this->assertSame('horizontal_stack', $display->getType());
        $this->assertSame([
            'type' => 'horizontal_stack',
        ], $display->jsonSerialize());
    }

    public function testCollectionDisplayBasic(): void
    {
        $display = new CollectionDisplay();

        $this->assertSame('collection', $display->getType());
        $this->assertSame([
            'type' => 'collection',
        ], $display->jsonSerialize());
    }

    public function testCollectionDisplayWithAlignment(): void
    {
        $display = (new CollectionDisplay())->setAlignment('center');

        $this->assertSame([
            'type' => 'collection',
            'alignment' => 'center',
        ], $display->jsonSerialize());
    }

    public function testCollectionDisplayWithDistribution(): void
    {
        $display = (new CollectionDisplay())->setDistribution('wide');

        $this->assertSame('wide', $display->jsonSerialize()['distribution']);
    }

    public function testCollectionDisplayWithSpacing(): void
    {
        $display = (new CollectionDisplay())
            ->setRowSpacing(15)
            ->setGutter(20);

        $data = $display->jsonSerialize();

        $this->assertSame(15, $data['rowSpacing']);
        $this->assertSame(20, $data['gutter']);
    }

    public function testCollectionDisplayWithSizing(): void
    {
        $display = (new CollectionDisplay())
            ->setVariableSizing(true)
            ->setWidths(2)
            ->setMinimumWidth(100)
            ->setMaximumWidth(300);

        $data = $display->jsonSerialize();

        $this->assertTrue($data['variableSizing']);
        $this->assertSame(2, $data['widths']);
        $this->assertSame(100, $data['minimumWidth']);
        $this->assertSame(300, $data['maximumWidth']);
    }

    public function testCollectionDisplayCentered(): void
    {
        $display = CollectionDisplay::centered();

        $this->assertSame('center', $display->jsonSerialize()['alignment']);
    }

    public function testCollectionDisplayGrid(): void
    {
        $display = CollectionDisplay::grid(25, 30);

        $data = $display->jsonSerialize();

        $this->assertSame(25, $data['gutter']);
        $this->assertSame(30, $data['rowSpacing']);
    }

    public function testCollectionDisplayGridDefaults(): void
    {
        $display = CollectionDisplay::grid();

        $data = $display->jsonSerialize();

        $this->assertSame(20, $data['gutter']);
        $this->assertSame(20, $data['rowSpacing']);
    }

    public function testAllDisplaysImplementInterface(): void
    {
        $displays = [
            new HorizontalStackDisplay(),
            new CollectionDisplay(),
        ];

        foreach ($displays as $display) {
            $this->assertInstanceOf(ContentDisplayInterface::class, $display);
        }
    }

    public function testCollectionDisplayConstants(): void
    {
        $this->assertSame('left', CollectionDisplay::ALIGN_LEFT);
        $this->assertSame('center', CollectionDisplay::ALIGN_CENTER);
        $this->assertSame('right', CollectionDisplay::ALIGN_RIGHT);
        $this->assertSame('wide', CollectionDisplay::DISTRIBUTE_WIDE);
        $this->assertSame('narrow', CollectionDisplay::DISTRIBUTE_NARROW);
    }
}

