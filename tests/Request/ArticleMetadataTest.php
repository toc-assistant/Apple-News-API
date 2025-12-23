<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Request;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Enum\MaturityRating;
use TomGould\AppleNews\Request\ArticleMetadata;

final class ArticleMetadataTest extends TestCase
{
    public function testEmptyMetadata(): void
    {
        $metadata = new ArticleMetadata();

        $this->assertTrue($metadata->isEmpty());
        $this->assertSame([], $metadata->toArray());
    }

    public function testSetIsSponsored(): void
    {
        $metadata = (new ArticleMetadata())->setIsSponsored(true);

        $this->assertFalse($metadata->isEmpty());
        $this->assertSame(['isSponsored' => true], $metadata->toArray());
    }

    public function testSetIsSponsoredFalse(): void
    {
        $metadata = (new ArticleMetadata())->setIsSponsored(false);

        $this->assertSame(['isSponsored' => false], $metadata->toArray());
    }

    public function testSetIsCandidateToBeFeatured(): void
    {
        $metadata = (new ArticleMetadata())->setIsCandidateToBeFeatured(true);

        $this->assertSame(['isCandidateToBeFeatured' => true], $metadata->toArray());
    }

    public function testSetIsPreview(): void
    {
        $metadata = (new ArticleMetadata())->setIsPreview(true);

        $this->assertSame(['isPreview' => true], $metadata->toArray());
    }

    public function testSetIsHidden(): void
    {
        $metadata = (new ArticleMetadata())->setIsHidden(true);

        $this->assertSame(['isHidden' => true], $metadata->toArray());
    }

    public function testSetMaturityRating(): void
    {
        $metadata = (new ArticleMetadata())->setMaturityRating(MaturityRating::MATURE);

        $this->assertSame(['maturityRating' => 'MATURE'], $metadata->toArray());
    }

    public function testAddTargetTerritory(): void
    {
        $metadata = (new ArticleMetadata())
            ->addTargetTerritory('US')
            ->addTargetTerritory('GB');

        $this->assertSame(
            ['targetTerritoryCountryCodes' => ['US', 'GB']],
            $metadata->toArray()
        );
    }

    public function testAddTargetTerritoryNormalizesCase(): void
    {
        $metadata = (new ArticleMetadata())
            ->addTargetTerritory('us')
            ->addTargetTerritory('gb');

        $this->assertSame(
            ['targetTerritoryCountryCodes' => ['US', 'GB']],
            $metadata->toArray()
        );
    }

    public function testAddTargetTerritoryDeduplicates(): void
    {
        $metadata = (new ArticleMetadata())
            ->addTargetTerritory('US')
            ->addTargetTerritory('US')
            ->addTargetTerritory('us');

        $this->assertSame(
            ['targetTerritoryCountryCodes' => ['US']],
            $metadata->toArray()
        );
    }

    public function testAddTargetTerritories(): void
    {
        $metadata = (new ArticleMetadata())
            ->addTargetTerritories(['US', 'GB', 'CA']);

        $this->assertSame(
            ['targetTerritoryCountryCodes' => ['US', 'GB', 'CA']],
            $metadata->toArray()
        );
    }

    public function testSetTargetTerritoriesReplacesExisting(): void
    {
        $metadata = (new ArticleMetadata())
            ->addTargetTerritory('US')
            ->setTargetTerritories(['GB', 'CA']);

        $this->assertSame(
            ['targetTerritoryCountryCodes' => ['GB', 'CA']],
            $metadata->toArray()
        );
    }

    public function testAddSection(): void
    {
        $metadata = (new ArticleMetadata())
            ->addSection('https://news-api.apple.com/sections/123');

        $this->assertSame(
            ['links' => ['sections' => ['https://news-api.apple.com/sections/123']]],
            $metadata->toArray()
        );
    }

    public function testAddSectionById(): void
    {
        $metadata = (new ArticleMetadata())
            ->addSectionById('123');

        $this->assertSame(
            ['links' => ['sections' => ['https://news-api.apple.com/sections/123']]],
            $metadata->toArray()
        );
    }

    public function testAddSectionByIdWithCustomApiBase(): void
    {
        $metadata = (new ArticleMetadata())
            ->addSectionById('123', 'https://custom-api.example.com');

        $this->assertSame(
            ['links' => ['sections' => ['https://custom-api.example.com/sections/123']]],
            $metadata->toArray()
        );
    }

    public function testAddSectionDeduplicates(): void
    {
        $url = 'https://news-api.apple.com/sections/123';
        $metadata = (new ArticleMetadata())
            ->addSection($url)
            ->addSection($url);

        $this->assertSame(
            ['links' => ['sections' => [$url]]],
            $metadata->toArray()
        );
    }

    public function testAddSections(): void
    {
        $metadata = (new ArticleMetadata())
            ->addSections([
                'https://news-api.apple.com/sections/123',
                'https://news-api.apple.com/sections/456',
            ]);

        $this->assertSame(
            ['links' => ['sections' => [
                'https://news-api.apple.com/sections/123',
                'https://news-api.apple.com/sections/456',
            ]]],
            $metadata->toArray()
        );
    }

    public function testSetSectionsReplacesExisting(): void
    {
        $metadata = (new ArticleMetadata())
            ->addSection('https://news-api.apple.com/sections/123')
            ->setSections(['https://news-api.apple.com/sections/456']);

        $this->assertSame(
            ['links' => ['sections' => ['https://news-api.apple.com/sections/456']]],
            $metadata->toArray()
        );
    }

    public function testFullMetadata(): void
    {
        $metadata = (new ArticleMetadata())
            ->setIsSponsored(true)
            ->setIsCandidateToBeFeatured(true)
            ->setIsPreview(false)
            ->setMaturityRating(MaturityRating::GENERAL)
            ->addTargetTerritories(['US', 'GB'])
            ->addSectionById('section-123');

        $expected = [
            'isSponsored' => true,
            'isCandidateToBeFeatured' => true,
            'isPreview' => false,
            'maturityRating' => 'GENERAL',
            'targetTerritoryCountryCodes' => ['US', 'GB'],
            'links' => [
                'sections' => ['https://news-api.apple.com/sections/section-123'],
            ],
        ];

        $this->assertSame($expected, $metadata->toArray());
    }

    public function testJsonSerialize(): void
    {
        $metadata = (new ArticleMetadata())
            ->setIsSponsored(true)
            ->setMaturityRating(MaturityRating::GENERAL);

        $json = json_encode($metadata);
        $decoded = json_decode($json, true);

        $this->assertSame([
            'isSponsored' => true,
            'maturityRating' => 'GENERAL',
        ], $decoded);
    }

    public function testFluentInterface(): void
    {
        $metadata = new ArticleMetadata();

        $result = $metadata
            ->setIsSponsored(true)
            ->setIsCandidateToBeFeatured(true)
            ->setIsPreview(false)
            ->setIsHidden(false)
            ->setMaturityRating(MaturityRating::GENERAL)
            ->addTargetTerritory('US')
            ->addTargetTerritories(['GB', 'CA'])
            ->setTargetTerritories(['AU'])
            ->addSection('https://news-api.apple.com/sections/1')
            ->addSectionById('2')
            ->addSections(['https://news-api.apple.com/sections/3'])
            ->setSections(['https://news-api.apple.com/sections/4']);

        $this->assertSame($metadata, $result);
    }
}
