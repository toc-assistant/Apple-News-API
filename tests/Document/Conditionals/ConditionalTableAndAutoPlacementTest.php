<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Conditionals;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Conditionals\ConditionalAutoPlacement;
use TomGould\AppleNews\Document\Conditionals\ConditionalInterface;
use TomGould\AppleNews\Document\Conditionals\ConditionalTableCellStyle;
use TomGould\AppleNews\Document\Conditionals\ConditionalTableRowStyle;
use TomGould\AppleNews\Document\Layouts\AdvertisementAutoPlacement;
use TomGould\AppleNews\Document\Layouts\Condition;

final class ConditionalTableAndAutoPlacementTest extends TestCase
{
    public function testConditionalAutoPlacement(): void
    {
        $conditional = (new ConditionalAutoPlacement())
            ->addCondition(Condition::compactWidth())
            ->setAdvertisement(AdvertisementAutoPlacement::disabled());

        $data = $conditional->jsonSerialize();

        $this->assertFalse($data['advertisement']['enabled']);
    }

    public function testConditionalAutoPlacementDisableOnCompact(): void
    {
        $conditional = ConditionalAutoPlacement::disableOnCompact();

        $data = $conditional->jsonSerialize();

        $this->assertSame('compact', $data['conditions'][0]['horizontalSizeClass']);
        $this->assertFalse($data['advertisement']['enabled']);
    }

    public function testConditionalAutoPlacementWithEnabled(): void
    {
        $conditional = (new ConditionalAutoPlacement())
            ->addCondition(Condition::regularWidth())
            ->setEnabled(true)
            ->setAdvertisement(AdvertisementAutoPlacement::withFrequency(5));

        $data = $conditional->jsonSerialize();

        $this->assertTrue($data['enabled']);
        $this->assertSame(5, $data['advertisement']['frequency']);
    }

    public function testConditionalTableRowStyle(): void
    {
        $conditional = (new ConditionalTableRowStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#2C2C2E')
            ->setHeight(48);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#2C2C2E', $data['backgroundColor']);
        $this->assertSame(48, $data['height']);
    }

    public function testConditionalTableRowStyleDarkMode(): void
    {
        $conditional = ConditionalTableRowStyle::darkMode('#1C1C1E');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#1C1C1E', $data['backgroundColor']);
        $this->assertSame('dark', $data['conditions'][0]['preferredColorScheme']);
    }

    public function testConditionalTableRowStyleWithDivider(): void
    {
        $conditional = (new ConditionalTableRowStyle())
            ->addCondition(Condition::darkMode())
            ->setDivider(['color' => '#444444', 'width' => 1]);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#444444', $data['divider']['color']);
    }

    public function testConditionalTableCellStyle(): void
    {
        $conditional = (new ConditionalTableCellStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#2C2C2E')
            ->setTextColor('#FFFFFF');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#2C2C2E', $data['backgroundColor']);
        $this->assertSame('#FFFFFF', $data['textColor']);
    }

    public function testConditionalTableCellStyleDarkMode(): void
    {
        $conditional = ConditionalTableCellStyle::darkMode('#1C1C1E', '#FFFFFF');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#1C1C1E', $data['backgroundColor']);
        $this->assertSame('#FFFFFF', $data['textColor']);
    }

    public function testConditionalTableCellStyleAllProperties(): void
    {
        $conditional = (new ConditionalTableCellStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#2C2C2E')
            ->setTextColor('#FFFFFF')
            ->setHorizontalAlignment('center')
            ->setVerticalAlignment('middle')
            ->setPadding(['top' => 8, 'bottom' => 8])
            ->setMinimumWidth(100)
            ->setWidth(200);

        $data = $conditional->jsonSerialize();

        $this->assertSame('center', $data['horizontalAlignment']);
        $this->assertSame('middle', $data['verticalAlignment']);
        $this->assertSame(['top' => 8, 'bottom' => 8], $data['padding']);
        $this->assertSame(100, $data['minimumWidth']);
        $this->assertSame(200, $data['width']);
    }

    public function testAllTableConditionalsImplementInterface(): void
    {
        $conditionals = [
            new ConditionalAutoPlacement(),
            new ConditionalTableRowStyle(),
            new ConditionalTableCellStyle(),
        ];

        foreach ($conditionals as $conditional) {
            $this->assertInstanceOf(ConditionalInterface::class, $conditional);
        }
    }
}
