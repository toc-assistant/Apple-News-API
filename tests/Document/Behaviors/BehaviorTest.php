<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Behaviors;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Behaviors\BackgroundMotion;
use TomGould\AppleNews\Document\Behaviors\BackgroundParallax;
use TomGould\AppleNews\Document\Behaviors\BehaviorInterface;
use TomGould\AppleNews\Document\Behaviors\Motion;
use TomGould\AppleNews\Document\Behaviors\Parallax;
use TomGould\AppleNews\Document\Behaviors\Springy;

final class BehaviorTest extends TestCase
{
    public function testParallaxWithDefaultFactor(): void
    {
        $parallax = new Parallax();

        $this->assertSame('parallax', $parallax->getType());
        $this->assertSame(0.9, $parallax->getFactor());
        $this->assertSame([
            'type' => 'parallax',
            'factor' => 0.9,
        ], $parallax->jsonSerialize());
    }

    public function testParallaxWithCustomFactor(): void
    {
        $parallax = new Parallax(0.5);

        $this->assertSame(0.5, $parallax->getFactor());
        $this->assertSame([
            'type' => 'parallax',
            'factor' => 0.5,
        ], $parallax->jsonSerialize());
    }

    public function testParallaxWithFactor(): void
    {
        $parallax = Parallax::withFactor(0.75);

        $this->assertSame(0.75, $parallax->getFactor());
    }

    public function testParallaxSubtle(): void
    {
        $parallax = Parallax::subtle();

        $this->assertSame(0.9, $parallax->getFactor());
    }

    public function testParallaxModerate(): void
    {
        $parallax = Parallax::moderate();

        $this->assertSame(0.7, $parallax->getFactor());
    }

    public function testParallaxStrong(): void
    {
        $parallax = Parallax::strong();

        $this->assertSame(0.5, $parallax->getFactor());
    }

    public function testSpringy(): void
    {
        $springy = new Springy();

        $this->assertSame('springy', $springy->getType());
        $this->assertSame([
            'type' => 'springy',
        ], $springy->jsonSerialize());
    }

    public function testMotion(): void
    {
        $motion = new Motion();

        $this->assertSame('motion', $motion->getType());
        $this->assertSame([
            'type' => 'motion',
        ], $motion->jsonSerialize());
    }

    public function testBackgroundMotion(): void
    {
        $bgMotion = new BackgroundMotion();

        $this->assertSame('background_motion', $bgMotion->getType());
        $this->assertSame([
            'type' => 'background_motion',
        ], $bgMotion->jsonSerialize());
    }

    public function testBackgroundParallax(): void
    {
        $bgParallax = new BackgroundParallax();

        $this->assertSame('background_parallax', $bgParallax->getType());
        $this->assertSame([
            'type' => 'background_parallax',
        ], $bgParallax->jsonSerialize());
    }

    public function testAllBehaviorsImplementInterface(): void
    {
        $behaviors = [
            new Parallax(),
            new Springy(),
            new Motion(),
            new BackgroundMotion(),
            new BackgroundParallax(),
        ];

        foreach ($behaviors as $behavior) {
            $this->assertInstanceOf(BehaviorInterface::class, $behavior);
        }
    }

    public function testBehaviorsAreJsonSerializable(): void
    {
        $behaviors = [
            new Parallax(0.8),
            new Springy(),
            new Motion(),
            new BackgroundMotion(),
            new BackgroundParallax(),
        ];

        foreach ($behaviors as $behavior) {
            $json = json_encode($behavior);
            $this->assertIsString($json);
            $this->assertNotFalse($json);

            $decoded = json_decode($json, true);
            $this->assertArrayHasKey('type', $decoded);
        }
    }
}

