<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Layouts;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Components\Body;
use TomGould\AppleNews\Document\Components\Container;
use TomGould\AppleNews\Document\Components\FlexibleSpacer;
use TomGould\AppleNews\Document\Components\Photo;
use TomGould\AppleNews\Document\Layouts\CollectionDisplay;
use TomGould\AppleNews\Document\Layouts\HorizontalStackDisplay;

final class ContainerContentDisplayIntegrationTest extends TestCase
{
    public function testContainerWithHorizontalStackDisplay(): void
    {
        $container = (new Container())
            ->setContentDisplayObject(new HorizontalStackDisplay())
            ->addComponent(new Body('Left'))
            ->addComponent(new FlexibleSpacer())
            ->addComponent(new Body('Right'));

        $data = $container->jsonSerialize();

        $this->assertSame('container', $data['role']);
        $this->assertSame([
            'type' => 'horizontal_stack',
        ], $data['contentDisplay']);
        $this->assertCount(3, $data['components']);
    }

    public function testContainerWithCollectionDisplay(): void
    {
        $container = (new Container())
            ->setContentDisplayObject(CollectionDisplay::grid(15, 15))
            ->addComponent(Photo::fromUrl('https://example.com/1.jpg'))
            ->addComponent(Photo::fromUrl('https://example.com/2.jpg'))
            ->addComponent(Photo::fromUrl('https://example.com/3.jpg'))
            ->addComponent(Photo::fromUrl('https://example.com/4.jpg'));

        $data = $container->jsonSerialize();

        $this->assertSame('collection', $data['contentDisplay']['type']);
        $this->assertSame(15, $data['contentDisplay']['gutter']);
        $this->assertSame(15, $data['contentDisplay']['rowSpacing']);
    }

    public function testStringContentDisplayStillWorks(): void
    {
        $container = (new Container())
            ->setContentDisplay('horizontal');

        $data = $container->jsonSerialize();

        $this->assertSame('horizontal', $data['contentDisplay']);
    }

    public function testArrayContentDisplayStillWorks(): void
    {
        $container = (new Container())
            ->setContentDisplay([
                'type' => 'collection',
                'alignment' => 'center',
            ]);

        $data = $container->jsonSerialize();

        $this->assertSame('collection', $data['contentDisplay']['type']);
    }

    public function testContentDisplayObjectOverwritesPrevious(): void
    {
        $container = (new Container())
            ->setContentDisplay('horizontal')
            ->setContentDisplayObject(CollectionDisplay::centered());

        $data = $container->jsonSerialize();

        $this->assertSame('collection', $data['contentDisplay']['type']);
        $this->assertSame('center', $data['contentDisplay']['alignment']);
    }

    public function testHorizontalLayoutWithFlexibleSpacers(): void
    {
        $container = (new Container())
            ->setContentDisplayObject(new HorizontalStackDisplay())
            ->addComponent(Photo::fromUrl('https://example.com/logo.png'))
            ->addComponent(new FlexibleSpacer())
            ->addComponent(new Body('Company Name'))
            ->addComponent(new FlexibleSpacer())
            ->addComponent(new Body('Menu'));

        $data = $container->jsonSerialize();

        $this->assertCount(5, $data['components']);
        $this->assertSame('photo', $data['components'][0]['role']);
        $this->assertSame('flexible_spacer', $data['components'][1]['role']);
        $this->assertSame('body', $data['components'][2]['role']);
        $this->assertSame('flexible_spacer', $data['components'][3]['role']);
        $this->assertSame('body', $data['components'][4]['role']);
    }

    public function testCollectionDisplayWithAllOptions(): void
    {
        $display = (new CollectionDisplay())
            ->setAlignment(CollectionDisplay::ALIGN_CENTER)
            ->setDistribution(CollectionDisplay::DISTRIBUTE_WIDE)
            ->setGutter(24)
            ->setRowSpacing(16)
            ->setVariableSizing(true)
            ->setMinimumWidth(150)
            ->setMaximumWidth(400);

        $container = (new Container())
            ->setContentDisplayObject($display);

        $data = $container->jsonSerialize();

        $this->assertSame('center', $data['contentDisplay']['alignment']);
        $this->assertSame('wide', $data['contentDisplay']['distribution']);
        $this->assertSame(24, $data['contentDisplay']['gutter']);
        $this->assertSame(16, $data['contentDisplay']['rowSpacing']);
        $this->assertTrue($data['contentDisplay']['variableSizing']);
        $this->assertSame(150, $data['contentDisplay']['minimumWidth']);
        $this->assertSame(400, $data['contentDisplay']['maximumWidth']);
    }
}
