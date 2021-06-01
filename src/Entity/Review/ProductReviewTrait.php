<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Review;

use Doctrine\ORM\Mapping as ORM;

trait ProductReviewTrait
{
    /** @ORM\Column(type="string", name="sag_id", nullable=true, unique=true) */
    protected $SAGId;

    /** @ORM\Column(type="text", name="sag_answer_comment", nullable=true) */
    protected $SAGAnswerComment;

    /** @ORM\Column(type="datetime", name="sag_answer_created_at", nullable=true) */
    protected $SAGAnswerCreatedAt;

    /** @ORM\Column(type="datetime", name="sag_ordered_at", nullable=true) */
    protected $SAGOrderedAt;

    /** @ORM\Column(type="string", name="sag_country_code", nullable=true) */
    protected $SAGCountryCode;

    public function getSAGId(): ?string
    {
        return $this->SAGId;
    }

    public function setSAGId(?string $SAGId): ProductReviewInterface
    {
        $this->SAGId = $SAGId;

        return $this;
    }

    public function getSAGAnswerComment(): ?string
    {
        return $this->SAGAnswerComment;
    }

    public function setSAGAnswerComment(?string $SAGAnswerComment): ProductReviewInterface
    {
        $this->SAGAnswerComment = $SAGAnswerComment;

        return $this;
    }

    public function getSAGAnswerCreatedAt(): ?\DateTimeInterface
    {
        return $this->SAGAnswerCreatedAt;
    }

    public function setSAGAnswerCreatedAt(?\DateTimeInterface $SAGAnswerCreatedAt): ProductReviewInterface
    {
        $this->SAGAnswerCreatedAt = $SAGAnswerCreatedAt;

        return $this;
    }

    public function getSAGOrderedAt(): ?\DateTimeInterface
    {
        return $this->SAGOrderedAt;
    }

    public function setSAGOrderedAt(?\DateTimeInterface $SAGOrderedAt): ProductReviewInterface
    {
        $this->SAGOrderedAt = $SAGOrderedAt;

        return $this;
    }

    public function getSAGCountryCode(): ?string
    {
        return $this->SAGCountryCode;
    }

    public function setSAGCountryCode(?string $SAGCountryCode): ProductReviewInterface
    {
        $this->SAGCountryCode = $SAGCountryCode;

        return $this;
    }
}
