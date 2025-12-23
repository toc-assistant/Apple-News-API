<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document\Conditionals;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Conditionals\ConditionalButton;
use TomGould\AppleNews\Document\Conditionals\ConditionalComponent;
use TomGould\AppleNews\Document\Conditionals\ConditionalContainer;
use TomGould\AppleNews\Document\Conditionals\ConditionalDivider;
use TomGould\AppleNews\Document\Conditionals\ConditionalInterface;
use TomGould\AppleNews\Document\Conditionals\ConditionalSection;
use TomGould\AppleNews\Document\Conditionals\ConditionalText;
use TomGould\AppleNews\Document\Layouts\Condition;

final class ConditionalComponentTest extends TestCase
{
    public function testConditionalComponentEmpty(): void
    {
        $conditional = new ConditionalComponent();

        $this->assertFalse($conditional->hasConditions());
        $this->assertSame([], $conditional->jsonSerialize());
    }

    public function testConditionalComponentWithCondition(): void
    {
        $conditional = (new ConditionalComponent())
            ->addCondition(Condition::compactWidth())
            ->setHidden(true);

        $this->assertTrue($conditional->hasConditions());

        $data = $conditional->jsonSerialize();

        $this->assertArrayHasKey('conditions', $data);
        $this->assertTrue($data['hidden']);
    }

    public function testConditionalComponentWithAllProperties(): void
    {
        $conditional = (new ConditionalComponent())
            ->addCondition(Condition::darkMode())
            ->setHidden(false)
            ->setAnchor('anchor-1')
            ->setLayout('darkLayout')
            ->setStyle('darkStyle');

        $data = $conditional->jsonSerialize();

        $this->assertFalse($data['hidden']);
        $this->assertSame('anchor-1', $data['anchor']);
        $this->assertSame('darkLayout', $data['layout']);
        $this->assertSame('darkStyle', $data['style']);
    }

    public function testConditionalComponentHiddenOnCompact(): void
    {
        $conditional = ConditionalComponent::hiddenOnCompact();

        $data = $conditional->jsonSerialize();

        $this->assertTrue($data['hidden']);
        $this->assertSame('compact', $data['conditions'][0]['horizontalSizeClass']);
    }

    public function testConditionalComponentVisibleOnRegular(): void
    {
        $conditional = ConditionalComponent::visibleOnRegular();

        $data = $conditional->jsonSerialize();

        $this->assertFalse($data['hidden']);
        $this->assertSame('regular', $data['conditions'][0]['horizontalSizeClass']);
    }

    public function testConditionalContainer(): void
    {
        $conditional = (new ConditionalContainer())
            ->addCondition(Condition::compactWidth())
            ->setContentDisplay('horizontal');

        $data = $conditional->jsonSerialize();

        $this->assertSame('horizontal', $data['contentDisplay']);
    }

    public function testConditionalSection(): void
    {
        $conditional = (new ConditionalSection())
            ->addCondition(Condition::darkMode())
            ->setContentDisplay(['type' => 'collection'])
            ->setScene(['type' => 'parallax_scale']);

        $data = $conditional->jsonSerialize();

        $this->assertSame(['type' => 'collection'], $data['contentDisplay']);
        $this->assertSame(['type' => 'parallax_scale'], $data['scene']);
    }

    public function testConditionalText(): void
    {
        $conditional = (new ConditionalText())
            ->addCondition(Condition::darkMode())
            ->setTextStyle('darkTextStyle');

        $data = $conditional->jsonSerialize();

        $this->assertSame('darkTextStyle', $data['textStyle']);
    }

    public function testConditionalTextWithInlineStyles(): void
    {
        $conditional = (new ConditionalText())
            ->addCondition(Condition::darkMode())
            ->setInlineTextStyles([
                ['rangeStart' => 0, 'rangeLength' => 5, 'textStyle' => 'boldDark'],
            ]);

        $data = $conditional->jsonSerialize();

        $this->assertCount(1, $data['inlineTextStyles']);
    }

    public function testConditionalDivider(): void
    {
        $conditional = (new ConditionalDivider())
            ->addCondition(Condition::darkMode())
            ->setStroke(['color' => '#FFFFFF', 'width' => 1]);

        $data = $conditional->jsonSerialize();

        $this->assertSame('#FFFFFF', $data['stroke']['color']);
    }

    public function testConditionalButton(): void
    {
        $conditional = (new ConditionalButton())
            ->addCondition(Condition::darkMode())
            ->setTextStyle('buttonDarkText');

        $data = $conditional->jsonSerialize();

        $this->assertSame('buttonDarkText', $data['textStyle']);
    }

    public function testMultipleConditions(): void
    {
        $conditional = (new ConditionalComponent())
            ->addCondition(Condition::darkMode())
            ->addCondition(Condition::iOS())
            ->setStyle('iosDarkStyle');

        $data = $conditional->jsonSerialize();

        $this->assertCount(2, $data['conditions']);
    }

    public function testAllComponentConditionalsImplementInterface(): void
    {
        $conditionals = [
            new ConditionalComponent(),
            new ConditionalContainer(),
            new ConditionalSection(),
            new ConditionalText(),
            new ConditionalDivider(),
            new ConditionalButton(),
        ];

        foreach ($conditionals as $conditional) {
            $this->assertInstanceOf(ConditionalInterface::class, $conditional);
        }
    }
}

