<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Tests\Document;

use PHPUnit\Framework\TestCase;
use TomGould\AppleNews\Document\Issue;
use DateTime;
use DateTimeImmutable;

final class IssueTest extends TestCase
{
    public function testEmptyIssue(): void
    {
        $issue = new Issue();

        $this->assertTrue($issue->isEmpty());
        $this->assertSame([], $issue->jsonSerialize());
    }

    public function testSetIssueIdentifier(): void
    {
        $issue = (new Issue())->setIssueIdentifier('issue-2024-01');

        $this->assertFalse($issue->isEmpty());
        $this->assertSame(
            ['issueIdentifier' => 'issue-2024-01'],
            $issue->jsonSerialize()
        );
    }

    public function testSetIssueDateWithString(): void
    {
        $issue = (new Issue())->setIssueDate('2024-01-15');

        $this->assertSame(
            ['issueDate' => '2024-01-15'],
            $issue->jsonSerialize()
        );
    }

    public function testSetIssueDateWithDateTime(): void
    {
        $date = new DateTime('2024-01-15');
        $issue = (new Issue())->setIssueDate($date);

        $this->assertSame(
            ['issueDate' => '2024-01-15'],
            $issue->jsonSerialize()
        );
    }

    public function testSetIssueDateWithDateTimeImmutable(): void
    {
        $date = new DateTimeImmutable('2024-06-20');
        $issue = (new Issue())->setIssueDate($date);

        $this->assertSame(
            ['issueDate' => '2024-06-20'],
            $issue->jsonSerialize()
        );
    }

    public function testSetIssueName(): void
    {
        $issue = (new Issue())->setIssueName('January 2024');

        $this->assertSame(
            ['issueName' => 'January 2024'],
            $issue->jsonSerialize()
        );
    }

    public function testFullIssue(): void
    {
        $issue = (new Issue())
            ->setIssueIdentifier('issue-2024-01')
            ->setIssueDate('2024-01-15')
            ->setIssueName('January 2024');

        $this->assertFalse($issue->isEmpty());
        $this->assertSame([
            'issueIdentifier' => 'issue-2024-01',
            'issueDate' => '2024-01-15',
            'issueName' => 'January 2024',
        ], $issue->jsonSerialize());
    }

    public function testFromArrayWithAllFields(): void
    {
        $issue = Issue::fromArray([
            'issueIdentifier' => 'summer-2024',
            'issueDate' => '2024-06-01',
            'issueName' => 'Summer Edition',
        ]);

        $this->assertSame([
            'issueIdentifier' => 'summer-2024',
            'issueDate' => '2024-06-01',
            'issueName' => 'Summer Edition',
        ], $issue->jsonSerialize());
    }

    public function testFromArrayWithPartialFields(): void
    {
        $issue = Issue::fromArray([
            'issueIdentifier' => 'weekly-123',
        ]);

        $this->assertSame(
            ['issueIdentifier' => 'weekly-123'],
            $issue->jsonSerialize()
        );
    }

    public function testFromArrayWithEmptyArray(): void
    {
        $issue = Issue::fromArray([]);

        $this->assertTrue($issue->isEmpty());
    }

    public function testFluentInterface(): void
    {
        $issue = new Issue();

        $result = $issue
            ->setIssueIdentifier('test')
            ->setIssueDate('2024-01-01')
            ->setIssueName('Test Issue');

        $this->assertSame($issue, $result);
    }
}

