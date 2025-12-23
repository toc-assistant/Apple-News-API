<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Behaviors;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Behaviors\BackgroundMotion;
use TomGould\AppleNews\Document\Behaviors\BackgroundParallax;
use TomGould\AppleNews\Document\Behaviors\Motion;
use TomGould\AppleNews\Document\Behaviors\Parallax;
use TomGould\AppleNews\Document\Behaviors\Springy;
use TomGould\AppleNews\Document\Components\Photo;
use TomGould\AppleNews\Document\Components\Container;
use TomGould\AppleNews\Document\Components\Body;

final class ComponentBehaviorIntegrationTest extends TestCase
{
    public function testPhotoWithParallaxBehavior(): void
    {
        $photo = Photo::fromUrl('https://example.com/hero.jpg')
            ->setBehaviorObject(Parallax::withFactor(0.8));

        $data = $photo->jsonSerialize();

        $this->assertSame([
            'type' => 'parallax',
            'factor' => 0.8,
        ], $data['behavior']);
    }

    public function testPhotoWithSpringyBehavior(): void
    {
        $photo = Photo::fromUrl('https://example.com/hero.jpg')
            ->setBehaviorObject(new Springy());

        $data = $photo->jsonSerialize();

        $this->assertSame([
            'type' => 'springy',
        ], $data['behavior']);
    }

    public function testPhotoWithMotionBehavior(): void
    {
        $photo = Photo::fromUrl('https://example.com/hero.jpg')
            ->setBehaviorObject(new Motion());

        $data = $photo->jsonSerialize();

        $this->assertSame([
            'type' => 'motion',
        ], $data['behavior']);
    }

    public function testContainerWithBackgroundParallax(): void
    {
        $container = (new Container())
            ->setBehaviorObject(new BackgroundParallax())
            ->addComponent(new Body('Content'));

        $data = $container->jsonSerialize();

        $this->assertSame([
            'type' => 'background_parallax',
        ], $data['behavior']);
    }

    public function testContainerWithBackgroundMotion(): void
    {
        $container = (new Container())
            ->setBehaviorObject(new BackgroundMotion())
            ->addComponent(new Body('Content'));

        $data = $container->jsonSerialize();

        $this->assertSame([
            'type' => 'background_motion',
        ], $data['behavior']);
    }

    public function testBehaviorOverwritesPrevious(): void
    {
        $photo = Photo::fromUrl('https://example.com/hero.jpg')
            ->setBehavior(['type' => 'parallax', 'factor' => 0.5])
            ->setBehaviorObject(Parallax::strong());

        $data = $photo->jsonSerialize();

        // setBehaviorObject should overwrite the previous array
        $this->assertSame([
            'type' => 'parallax',
            'factor' => 0.5,
        ], $data['behavior']);
    }

    public function testArrayBehaviorStillWorks(): void
    {
        $photo = Photo::fromUrl('https://example.com/hero.jpg')
            ->setBehavior(['type' => 'parallax', 'factor' => 0.6]);

        $data = $photo->jsonSerialize();

        $this->assertSame([
            'type' => 'parallax',
            'factor' => 0.6,
        ], $data['behavior']);
    }

    public function testParallaxFactoryMethodsInComponents(): void
    {
        $subtle = Photo::fromUrl('https://example.com/1.jpg')
            ->setBehaviorObject(Parallax::subtle());

        $moderate = Photo::fromUrl('https://example.com/2.jpg')
            ->setBehaviorObject(Parallax::moderate());

        $strong = Photo::fromUrl('https://example.com/3.jpg')
            ->setBehaviorObject(Parallax::strong());

        $this->assertSame(0.9, $subtle->jsonSerialize()['behavior']['factor']);
        $this->assertSame(0.7, $moderate->jsonSerialize()['behavior']['factor']);
        $this->assertSame(0.5, $strong->jsonSerialize()['behavior']['factor']);
    }
}
