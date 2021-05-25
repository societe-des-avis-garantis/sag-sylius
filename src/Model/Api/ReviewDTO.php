<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Model\Api;

use Dedi\SyliusSAGPlugin\Enum\SagStatusEnum;
use Sylius\Component\Review\Model\ReviewableInterface;

class ReviewDTO
{
    /** @var string */
    public $SAGId;

    /** @var ReviewableInterface */
    public $reviewSubject;

    /** @var int */
    public $rating;

    /** @var string */
    public $comment;

    /** @var string */
    public $reviewerFirstName;

    /** @var string */
    public $reviewerLastName;

    /** @var \DateTimeImmutable */
    public $createdAt;

    /** @var string */
    public $status;

    /** @var string|null */
    public $SAGAnswerComment;

    /** @var \DateTimeImmutable|null */
    public $SAGAnswerCreatedAt;

    /** @var string */
    public $countryCode;

    public function __construct(
        string $SAGId,
        ReviewableInterface $reviewSubject,
        int $rating,
        string $comment,
        string $reviewerFirstName,
        string $reviewerLastName,
        \DateTimeImmutable $createdAt,
        int $SAGStatus,
        ?string $SAGAnswerComment,
        ?\DateTimeImmutable $SAGAnswerCreatedAt,
        string $countryCode
    ) {
        $this->SAGId = $SAGId;
        $this->reviewSubject = $reviewSubject;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->reviewerFirstName = $reviewerFirstName;
        $this->reviewerLastName = $reviewerLastName;
        $this->createdAt = $createdAt;
        $this->status = SagStatusEnum::sagToSylius($SAGStatus);
        $this->SAGAnswerComment = $SAGAnswerComment;
        $this->SAGAnswerCreatedAt = $SAGAnswerCreatedAt;
        $this->countryCode = $countryCode;
    }
}
