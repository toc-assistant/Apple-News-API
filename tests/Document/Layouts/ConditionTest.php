<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Layouts;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Layouts\Condition;

final class ConditionTest extends TestCase
{
    public function testEmptyCondition(): void
    {
        $condition = new Condition();

        $this->assertSame([], $condition->jsonSerialize());
    }

    public function testConditionWithPlatform(): void
    {
        $condition = (new Condition())->setPlatform('ios');

        $this->assertSame([
            'platform' => 'ios',
        ], $condition->jsonSerialize());
    }

    public function testConditionWithViewportWidth(): void
    {
        $condition = (new Condition())
            ->setMinViewportWidth(375)
            ->setMaxViewportWidth(768);

        $data = $condition->jsonSerialize();

        $this->assertSame(375, $data['minViewportWidth']);
        $this->assertSame(768, $data['maxViewportWidth']);
    }

    public function testConditionWithColumns(): void
    {
        $condition = (new Condition())
            ->setMinColumns(4)
            ->setMaxColumns(8);

        $data = $condition->jsonSerialize();

        $this->assertSame(4, $data['minColumns']);
        $this->assertSame(8, $data['maxColumns']);
    }

    public function testConditionWithSizeClasses(): void
    {
        $condition = (new Condition())
            ->setHorizontalSizeClass('compact')
            ->setVerticalSizeClass('regular');

        $data = $condition->jsonSerialize();

        $this->assertSame('compact', $data['horizontalSizeClass']);
        $this->assertSame('regular', $data['verticalSizeClass']);
    }

    public function testConditionWithAspectRatio(): void
    {
        $condition = (new Condition())
            ->setMinViewportAspectRatio(0.5)
            ->setMaxViewportAspectRatio(1.5);

        $data = $condition->jsonSerialize();

        $this->assertSame(0.5, $data['minViewportAspectRatio']);
        $this->assertSame(1.5, $data['maxViewportAspectRatio']);
    }

    public function testConditionWithColorScheme(): void
    {
        $condition = (new Condition())->setPreferredColorScheme('dark');

        $this->assertSame([
            'preferredColorScheme' => 'dark',
        ], $condition->jsonSerialize());
    }

    public function testConditionWithSubscriptionStatus(): void
    {
        $condition = (new Condition())->setSubscriptionStatus(['bundle', 'subscribed']);

        $this->assertSame([
            'subscriptionStatus' => ['bundle', 'subscribed'],
        ], $condition->jsonSerialize());
    }

    public function testConditionWithViewLocation(): void
    {
        $condition = (new Condition())->setViewLocation('article');

        $this->assertSame([
            'viewLocation' => 'article',
        ], $condition->jsonSerialize());
    }

    public function testConditionIOS(): void
    {
        $condition = Condition::iOS();

        $this->assertSame('ios', $condition->jsonSerialize()['platform']);
    }

    public function testConditionMacOS(): void
    {
        $condition = Condition::macOS();

        $this->assertSame('macos', $condition->jsonSerialize()['platform']);
    }

    public function testConditionCompactWidth(): void
    {
        $condition = Condition::compactWidth();

        $this->assertSame('compact', $condition->jsonSerialize()['horizontalSizeClass']);
    }

    public function testConditionRegularWidth(): void
    {
        $condition = Condition::regularWidth();

        $this->assertSame('regular', $condition->jsonSerialize()['horizontalSizeClass']);
    }

    public function testConditionDarkMode(): void
    {
        $condition = Condition::darkMode();

        $this->assertSame('dark', $condition->jsonSerialize()['preferredColorScheme']);
    }

    public function testConditionLightMode(): void
    {
        $condition = Condition::lightMode();

        $this->assertSame('light', $condition->jsonSerialize()['preferredColorScheme']);
    }

    public function testConditionViewportWidthRange(): void
    {
        $condition = Condition::viewportWidth(320, 768);

        $data = $condition->jsonSerialize();

        $this->assertSame(320, $data['minViewportWidth']);
        $this->assertSame(768, $data['maxViewportWidth']);
    }

    public function testConditionViewportWidthMinOnly(): void
    {
        $condition = Condition::viewportWidth(768);

        $data = $condition->jsonSerialize();

        $this->assertSame(768, $data['minViewportWidth']);
        $this->assertArrayNotHasKey('maxViewportWidth', $data);
    }

    public function testConditionConstants(): void
    {
        $this->assertSame('any', Condition::PLATFORM_ANY);
        $this->assertSame('ios', Condition::PLATFORM_IOS);
        $this->assertSame('macos', Condition::PLATFORM_MACOS);
        $this->assertSame('any', Condition::SIZE_CLASS_ANY);
        $this->assertSame('compact', Condition::SIZE_CLASS_COMPACT);
        $this->assertSame('regular', Condition::SIZE_CLASS_REGULAR);
        $this->assertSame('any', Condition::COLOR_SCHEME_ANY);
        $this->assertSame('light', Condition::COLOR_SCHEME_LIGHT);
        $this->assertSame('dark', Condition::COLOR_SCHEME_DARK);
    }

    public function testConditionWithAllProperties(): void
    {
        $condition = (new Condition())
            ->setPlatform('ios')
            ->setMinViewportWidth(375)
            ->setMaxViewportWidth(768)
            ->setHorizontalSizeClass('compact')
            ->setPreferredColorScheme('dark');

        $data = $condition->jsonSerialize();

        $this->assertSame('ios', $data['platform']);
        $this->assertSame(375, $data['minViewportWidth']);
        $this->assertSame(768, $data['maxViewportWidth']);
        $this->assertSame('compact', $data['horizontalSizeClass']);
        $this->assertSame('dark', $data['preferredColorScheme']);
    }
}

