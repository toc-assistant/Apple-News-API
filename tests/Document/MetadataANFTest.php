<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Issue;
use TomGould\AppleNews\Document\Metadata;

/**
 * Tests for the ANF metadata fields added in Point 3.
 */
final class MetadataANFTest extends TestCase
{
    public function testSetContentGenerationType(): void
    {
        $metadata = (new Metadata())->setContentGenerationType('AI');

        $data = $metadata->jsonSerialize();

        $this->assertSame('AI', $data['contentGenerationType']);
    }

    public function testSetAsAIGenerated(): void
    {
        $metadata = (new Metadata())->setAsAIGenerated();

        $data = $metadata->jsonSerialize();

        $this->assertSame('AI', $data['contentGenerationType']);
    }

    public function testSetCampaignData(): void
    {
        $metadata = (new Metadata())->setCampaignData([
            'sport' => ['football', 'basketball'],
            'region' => ['west-coast'],
        ]);

        $data = $metadata->jsonSerialize();

        $this->assertSame([
            'sport' => ['football', 'basketball'],
            'region' => ['west-coast'],
        ], $data['campaignData']);
    }

    public function testAddCampaignData(): void
    {
        $metadata = (new Metadata())
            ->addCampaignData('sport', ['football'])
            ->addCampaignData('sport', ['basketball'])
            ->addCampaignData('region', ['west-coast']);

        $data = $metadata->jsonSerialize();

        $this->assertSame([
            'sport' => ['football', 'basketball'],
            'region' => ['west-coast'],
        ], $data['campaignData']);
    }

    public function testAddCampaignDataDeduplicates(): void
    {
        $metadata = (new Metadata())
            ->addCampaignData('sport', ['football', 'basketball'])
            ->addCampaignData('sport', ['football', 'soccer']);

        $data = $metadata->jsonSerialize();

        $this->assertSame([
            'sport' => ['football', 'basketball', 'soccer'],
        ], $data['campaignData']);
    }

    public function testSetIssue(): void
    {
        $issue = (new Issue())
            ->setIssueIdentifier('issue-2024-01')
            ->setIssueDate('2024-01-15')
            ->setIssueName('January 2024');

        $metadata = (new Metadata())->setIssue($issue);

        $data = $metadata->jsonSerialize();

        $this->assertSame([
            'issueIdentifier' => 'issue-2024-01',
            'issueDate' => '2024-01-15',
            'issueName' => 'January 2024',
        ], $data['issue']);
    }

    public function testSetIssueFromArray(): void
    {
        $metadata = (new Metadata())->setIssueFromArray([
            'issueIdentifier' => 'summer-2024',
            'issueDate' => '2024-06-01',
            'issueName' => 'Summer Edition',
        ]);

        $data = $metadata->jsonSerialize();

        $this->assertSame([
            'issueIdentifier' => 'summer-2024',
            'issueDate' => '2024-06-01',
            'issueName' => 'Summer Edition',
        ], $data['issue']);
    }

    public function testEmptyIssueNotIncluded(): void
    {
        $metadata = (new Metadata())->setIssue(new Issue());

        $data = $metadata->jsonSerialize();

        $this->assertArrayNotHasKey('issue', $data);
    }

    public function testEmptyCampaignDataNotIncluded(): void
    {
        $metadata = (new Metadata())->setCampaignData([]);

        $data = $metadata->jsonSerialize();

        $this->assertArrayNotHasKey('campaignData', $data);
    }

    public function testFullANFMetadata(): void
    {
        $metadata = (new Metadata())
            ->setContentGenerationType('AI')
            ->setCampaignData([
                'category' => ['tech', 'innovation'],
            ])
            ->setIssueFromArray([
                'issueIdentifier' => 'weekly-52',
                'issueName' => 'Week 52',
            ]);

        $data = $metadata->jsonSerialize();

        $this->assertSame('AI', $data['contentGenerationType']);
        $this->assertSame(['category' => ['tech', 'innovation']], $data['campaignData']);
        $this->assertSame([
            'issueIdentifier' => 'weekly-52',
            'issueName' => 'Week 52',
        ], $data['issue']);
    }

    public function testCombinedWithExistingMetadata(): void
    {
        $metadata = (new Metadata())
            ->addAuthor('John Doe')
            ->setExcerpt('A test article')
            ->setAsAIGenerated()
            ->setCampaignData(['topic' => ['testing']]);

        $data = $metadata->jsonSerialize();

        $this->assertSame(['John Doe'], $data['authors']);
        $this->assertSame('A test article', $data['excerpt']);
        $this->assertSame('AI', $data['contentGenerationType']);
        $this->assertSame(['topic' => ['testing']], $data['campaignData']);
    }
}
