<?php

declare(strict_types=1);

namespace TomGould\AppleNews\Document;

use DateTimeInterface;
use JsonSerializable;

/**
 * Issue information for magazine and periodical content.
 *
 * Use this class to associate articles with specific publication issues,
 * allowing Apple News to group related content together.
 *
 * @see https://developer.apple.com/documentation/apple_news/issue
 */
final class Issue implements JsonSerializable
{
    /**
     * The unique identifier for the issue.
     */
    private ?string $issueIdentifier = null;

    /**
     * The publication date of the issue.
     */
    private ?string $issueDate = null;

    /**
     * The display name of the issue.
     */
    private ?string $issueName = null;

    /**
     * Set the unique identifier for this issue.
     *
     * This identifier should be unique within your channel and consistent
     * across all articles belonging to the same issue.
     *
     * @param string $identifier The unique issue identifier.
     *
     * @return $this
     */
    public function setIssueIdentifier(string $identifier): self
    {
        $this->issueIdentifier = $identifier;
        return $this;
    }

    /**
     * Set the publication date of the issue.
     *
     * @param DateTimeInterface|string $date The issue date as a DateTime object or ISO 8601 string.
     *
     * @return $this
     */
    public function setIssueDate(DateTimeInterface|string $date): self
    {
        if ($date instanceof DateTimeInterface) {
            $this->issueDate = $date->format('Y-m-d');
        } else {
            $this->issueDate = $date;
        }
        return $this;
    }

    /**
     * Set the display name of the issue.
     *
     * This is the human-readable name shown to users, such as "January 2024"
     * or "Summer Edition".
     *
     * @param string $name The issue display name.
     *
     * @return $this
     */
    public function setIssueName(string $name): self
    {
        $this->issueName = $name;
        return $this;
    }

    /**
     * Create an Issue from an array of data.
     *
     * @param array<string, mixed> $data The issue data.
     *
     * @return self A new Issue instance.
     */
    public static function fromArray(array $data): self
    {
        $issue = new self();

        if (isset($data['issueIdentifier'])) {
            $issue->setIssueIdentifier($data['issueIdentifier']);
        }

        if (isset($data['issueDate'])) {
            $issue->setIssueDate($data['issueDate']);
        }

        if (isset($data['issueName'])) {
            $issue->setIssueName($data['issueName']);
        }

        return $issue;
    }

    /**
     * Check if the issue has any data set.
     *
     * @return bool True if at least one field is set.
     */
    public function isEmpty(): bool
    {
        return $this->issueIdentifier === null
            && $this->issueDate === null
            && $this->issueName === null;
    }

    /**
     * {@inheritdoc}
     *
     * @return array<string, string>
     */
    public function jsonSerialize(): array
    {
        $data = [];

        if ($this->issueIdentifier !== null) {
            $data['issueIdentifier'] = $this->issueIdentifier;
        }

        if ($this->issueDate !== null) {
            $data['issueDate'] = $this->issueDate;
        }

        if ($this->issueName !== null) {
            $data['issueName'] = $this->issueName;
        }

        return $data;
    }
}

