<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Layouts;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Layouts\AdvertisementAutoPlacement;
use TomGould\AppleNews\Document\Layouts\AutoPlacement;
use TomGould\AppleNews\Document\Layouts\Condition;

final class AutoPlacementTest extends TestCase
{
    public function testAdvertisementAutoPlacementBasic(): void
    {
        $adPlacement = new AdvertisementAutoPlacement();

        $this->assertSame([], $adPlacement->jsonSerialize());
    }

    public function testAdvertisementAutoPlacementWithEnabled(): void
    {
        $adPlacement = (new AdvertisementAutoPlacement())->setEnabled(true);

        $this->assertSame([
            'enabled' => true,
        ], $adPlacement->jsonSerialize());
    }

    public function testAdvertisementAutoPlacementWithFrequency(): void
    {
        $adPlacement = (new AdvertisementAutoPlacement())
            ->setEnabled(true)
            ->setFrequency(10);

        $data = $adPlacement->jsonSerialize();

        $this->assertTrue($data['enabled']);
        $this->assertSame(10, $data['frequency']);
    }

    public function testAdvertisementAutoPlacementWithAllOptions(): void
    {
        $adPlacement = (new AdvertisementAutoPlacement())
            ->setEnabled(true)
            ->setBannerType(true)
            ->setFrequency(5)
            ->setDistanceFromMedia(50)
            ->setLayout('adLayout');

        $data = $adPlacement->jsonSerialize();

        $this->assertTrue($data['enabled']);
        $this->assertTrue($data['bannerType']);
        $this->assertSame(5, $data['frequency']);
        $this->assertSame(50, $data['distanceFromMedia']);
        $this->assertSame('adLayout', $data['layout']);
    }

    public function testAdvertisementAutoPlacementDisabled(): void
    {
        $adPlacement = AdvertisementAutoPlacement::disabled();

        $this->assertSame([
            'enabled' => false,
        ], $adPlacement->jsonSerialize());
    }

    public function testAdvertisementAutoPlacementWithFrequencyFactory(): void
    {
        $adPlacement = AdvertisementAutoPlacement::withFrequency(8);

        $data = $adPlacement->jsonSerialize();

        $this->assertTrue($data['enabled']);
        $this->assertSame(8, $data['frequency']);
    }

    public function testAutoPlacementEmpty(): void
    {
        $autoPlacement = new AutoPlacement();

        $this->assertTrue($autoPlacement->isEmpty());
        $this->assertSame([], $autoPlacement->jsonSerialize());
    }

    public function testAutoPlacementWithAdvertisement(): void
    {
        $autoPlacement = (new AutoPlacement())
            ->setAdvertisement(AdvertisementAutoPlacement::withFrequency(10));

        $this->assertFalse($autoPlacement->isEmpty());

        $data = $autoPlacement->jsonSerialize();

        $this->assertArrayHasKey('advertisement', $data);
        $this->assertTrue($data['advertisement']['enabled']);
        $this->assertSame(10, $data['advertisement']['frequency']);
    }

    public function testAutoPlacementWithAdsDisabled(): void
    {
        $autoPlacement = AutoPlacement::withAdsDisabled();

        $data = $autoPlacement->jsonSerialize();

        $this->assertFalse($data['advertisement']['enabled']);
    }

    public function testAutoPlacementWithAdFrequency(): void
    {
        $autoPlacement = AutoPlacement::withAdFrequency(15);

        $data = $autoPlacement->jsonSerialize();

        $this->assertTrue($data['advertisement']['enabled']);
        $this->assertSame(15, $data['advertisement']['frequency']);
    }

    public function testAutoPlacementWithConditional(): void
    {
        $autoPlacement = (new AutoPlacement())
            ->setAdvertisement(AdvertisementAutoPlacement::withFrequency(10))
            ->addConditional(
                Condition::compactWidth(),
                AdvertisementAutoPlacement::disabled()
            );

        $data = $autoPlacement->jsonSerialize();

        $this->assertArrayHasKey('conditional', $data);
        $this->assertCount(1, $data['conditional']);
        $this->assertSame('compact', $data['conditional'][0]['conditions'][0]['horizontalSizeClass']);
        $this->assertFalse($data['conditional'][0]['advertisement']['enabled']);
    }

    public function testAutoPlacementWithMultipleConditionals(): void
    {
        $autoPlacement = (new AutoPlacement())
            ->setAdvertisement(AdvertisementAutoPlacement::withFrequency(10))
            ->addConditional(
                Condition::compactWidth(),
                AdvertisementAutoPlacement::disabled()
            )
            ->addConditional(
                Condition::darkMode(),
                AdvertisementAutoPlacement::withFrequency(5)
            );

        $data = $autoPlacement->jsonSerialize();

        $this->assertCount(2, $data['conditional']);
    }

    public function testAutoPlacementComplexExample(): void
    {
        $autoPlacement = (new AutoPlacement())
            ->setAdvertisement(
                (new AdvertisementAutoPlacement())
                    ->setEnabled(true)
                    ->setFrequency(10)
                    ->setBannerType(true)
                    ->setLayout('defaultAdLayout')
            )
            ->addConditional(
                Condition::viewportWidth(null, 500),
                AdvertisementAutoPlacement::disabled()
            );

        $data = $autoPlacement->jsonSerialize();

        // Main advertisement config
        $this->assertTrue($data['advertisement']['enabled']);
        $this->assertSame(10, $data['advertisement']['frequency']);
        $this->assertTrue($data['advertisement']['bannerType']);
        $this->assertSame('defaultAdLayout', $data['advertisement']['layout']);

        // Conditional: disable ads on small screens
        $this->assertSame(500, $data['conditional'][0]['conditions'][0]['maxViewportWidth']);
        $this->assertFalse($data['conditional'][0]['advertisement']['enabled']);
    }
}
