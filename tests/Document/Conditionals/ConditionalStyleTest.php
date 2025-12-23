<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Conditionals;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Conditionals\ConditionalComponentLayout;
use TomGould\AppleNews\Document\Conditionals\ConditionalComponentStyle;
use TomGould\AppleNews\Document\Conditionals\ConditionalComponentTextStyle;
use TomGould\AppleNews\Document\Conditionals\ConditionalDocumentStyle;
use TomGould\AppleNews\Document\Conditionals\ConditionalInterface;
use TomGould\AppleNews\Document\Conditionals\ConditionalTextStyle;
use TomGould\AppleNews\Document\Layouts\Condition;

final class ConditionalStyleTest extends TestCase
{
    public function testConditionalComponentLayout(): void
    {
        $conditional = (new ConditionalComponentLayout())
            ->addCondition(Condition::compactWidth())
            ->setColumnSpan(12)
            ->setMargin(10);

        $data = $conditional->jsonSerialize();

        $this->assertSame(12, $data['columnSpan']);
        $this->assertSame(10, $data['margin']);
    }

    public function testConditionalComponentLayoutFullWidthOnCompact(): void
    {
        $conditional = ConditionalComponentLayout::fullWidthOnCompact();

        $data = $conditional->jsonSerialize();

        $this->assertTrue($data['ignoreDocumentMargin']);
        $this->assertTrue($data['ignoreDocumentGutter']);
    }

    public function testConditionalComponentLayoutAllProperties(): void
    {
        $conditional = (new ConditionalComponentLayout())
            ->addCondition(Condition::regularWidth())
            ->setColumnStart(2)
            ->setColumnSpan(8)
            ->setMargin(['top' => 20, 'bottom' => 20])
            ->setContentInset(['left' => 10, 'right' => 10])
            ->setPadding(15)
            ->setMinimumHeight(100)
            ->setMaximumWidth(600)
            ->setMinimumWidth(300)
            ->setHorizontalContentAlignment('center');

        $data = $conditional->jsonSerialize();

        $this->assertSame(2, $data['columnStart']);
        $this->assertSame(8, $data['columnSpan']);
        $this->assertSame(['top' => 20, 'bottom' => 20], $data['margin']);
        $this->assertSame(['left' => 10, 'right' => 10], $data['contentInset']);
        $this->assertSame(15, $data['padding']);
        $this->assertSame(100, $data['minimumHeight']);
        $this->assertSame(600, $data['maximumWidth']);
        $this->assertSame(300, $data['minimumWidth']);
        $this->assertSame('center', $data['horizontalContentAlignment']);
    }

    public function testConditionalComponentStyle(): void
    {
        $conditional = (new ConditionalComponentStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#1C1C1E')
            ->setOpacity(0.9);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#1C1C1E', $data['backgroundColor']);
        $this->assertSame(0.9, $data['opacity']);
    }

    public function testConditionalComponentStyleDarkMode(): void
    {
        $conditional = ConditionalComponentStyle::darkMode('#2C2C2E');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#2C2C2E', $data['backgroundColor']);
        $this->assertSame('dark', $data['conditions'][0]['preferredColorScheme']);
    }

    public function testConditionalComponentStyleLightMode(): void
    {
        $conditional = ConditionalComponentStyle::lightMode('#FFFFFF');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['backgroundColor']);
        $this->assertSame('light', $data['conditions'][0]['preferredColorScheme']);
    }

    public function testConditionalComponentStyleAllProperties(): void
    {
        $conditional = (new ConditionalComponentStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#1C1C1E')
            ->setFill(['type' => 'linear_gradient'])
            ->setBorder(['all' => ['color' => '#333', 'width' => 1]])
            ->setShadow(['color' => '#000', 'radius' => 5])
            ->setOpacity(0.95)
            ->setMask(['type' => 'rectangle', 'radius' => 10]);

        $data = $conditional->jsonSerialize();

        $this->assertArrayHasKey('fill', $data);
        $this->assertArrayHasKey('border', $data);
        $this->assertArrayHasKey('shadow', $data);
        $this->assertArrayHasKey('mask', $data);
    }

    public function testConditionalTextStyle(): void
    {
        $conditional = (new ConditionalTextStyle())
            ->addCondition(Condition::darkMode())
            ->setTextColor('#FFFFFF')
            ->setFontSize(16);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['textColor']);
        $this->assertSame(16, $data['fontSize']);
    }

    public function testConditionalTextStyleDarkMode(): void
    {
        $conditional = ConditionalTextStyle::darkMode('#E5E5E7');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#E5E5E7', $data['textColor']);
    }

    public function testConditionalTextStyleCompactSize(): void
    {
        $conditional = ConditionalTextStyle::compactSize(14);

        $data = $conditional->jsonSerialize();

        $this->assertSame(14, $data['fontSize']);
        $this->assertSame('compact', $data['conditions'][0]['horizontalSizeClass']);
    }

    public function testConditionalTextStyleAllProperties(): void
    {
        $conditional = (new ConditionalTextStyle())
            ->addCondition(Condition::darkMode())
            ->setTextColor('#FFFFFF')
            ->setBackgroundColor('#333333')
            ->setFontName('Georgia')
            ->setFontSize(18)
            ->setFontWeight(700)
            ->setFontWidth('condensed')
            ->setFontStyle('italic')
            ->setLineHeight(24.0)
            ->setTracking(0.5)
            ->setTextAlignment('justified')
            ->setTextShadow(['color' => '#000', 'offset' => ['x' => 1, 'y' => 1]]);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['textColor']);
        $this->assertSame('#333333', $data['backgroundColor']);
        $this->assertSame('Georgia', $data['fontName']);
        $this->assertSame(18, $data['fontSize']);
        $this->assertSame(700, $data['fontWeight']);
        $this->assertSame('condensed', $data['fontWidth']);
        $this->assertSame('italic', $data['fontStyle']);
        $this->assertSame(24.0, $data['lineHeight']);
        $this->assertSame(0.5, $data['tracking']);
        $this->assertSame('justified', $data['textAlignment']);
        $this->assertArrayHasKey('textShadow', $data);
    }

    public function testConditionalComponentTextStyleExtendsTextStyle(): void
    {
        $conditional = (new ConditionalComponentTextStyle())
            ->addCondition(Condition::darkMode())
            ->setTextColor('#FFFFFF');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['textColor']);
    }

    public function testConditionalDocumentStyle(): void
    {
        $conditional = (new ConditionalDocumentStyle())
            ->addCondition(Condition::darkMode())
            ->setBackgroundColor('#000000');

        $data = $conditional->jsonSerialize();

        $this->assertSame('#000000', $data['backgroundColor']);
    }

    public function testConditionalDocumentStyleDarkMode(): void
    {
        $conditional = ConditionalDocumentStyle::darkMode();

        $data = $conditional->jsonSerialize();

        $this->assertSame('#1C1C1E', $data['backgroundColor']);
    }

    public function testConditionalDocumentStyleLightMode(): void
    {
        $conditional = ConditionalDocumentStyle::lightMode();

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['backgroundColor']);
    }

    public function testAllStyleConditionalsImplementInterface(): void
    {
        $conditionals = [
            new ConditionalComponentLayout(),
            new ConditionalComponentStyle(),
            new ConditionalTextStyle(),
            new ConditionalComponentTextStyle(),
            new ConditionalDocumentStyle(),
        ];

        foreach ($conditionals as $conditional) {
            $this->assertInstanceOf(ConditionalInterface::class, $conditional);
        }
    }
}

