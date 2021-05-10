<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Review;

use Doctrine\ORM\Mapping as ORM;

trait ProductReviewTrait
{
    /** @ORM\Column(type="string", name="sag_id", nullable=true) */
    protected $SAGId;

    /** @ORM\Column(type="text", name="sag_answer_comment", nullable=true) */
    protected $SAGAnswerComment;

    /** @ORM\Column(type="datetime", name="sag_answer_created_at", nullable=true) */
    protected $SAGAnswerCreatedAt;

    /** @ORM\Column(type="string", name="sag_country_code", nullable=true) */
    protected $SAGCountryCode;

    public function getSAGId(): ?string
    {
        return $this->SAGId;
    }

    public function setSAGId(?string $SAGId): void
    {
        $this->SAGId = $SAGId;
    }

    public function getSAGStatus(): ?string
    {
        $status = $this->getStatus();
        if (!$status) {
            return null;
        }

        return ProductReviewInterface::SYLIUS_TO_SAG_STATUS[$status] ?? null;
    }

    public function setSAGStatus(?string $SAGStatus): void
    {
        if (null === $SAGStatus) {
            $this->setStatus($SAGStatus);

            return;
        }

        $sagToSyliusStatus = array_flip(ProductReviewInterface::SYLIUS_TO_SAG_STATUS);

        // todo test en réel
        if (!array_key_exists($SAGStatus, $sagToSyliusStatus)) {
            throw new \LogicException(sprintf(
                'Status "%s" is not valid, please use [%s]',
                $SAGStatus,
                implode(', ', array_map(function ($status) {
                    return sprintf('"%s"', $status);
                }, ProductReviewInterface::SYLIUS_TO_SAG_STATUS))
            ));
        }

        $this->setStatus($sagToSyliusStatus[$SAGStatus]);
    }

    public function getSAGAnswerComment(): ?string
    {
        return $this->SAGAnswerComment;
    }

    public function setSAGAnswerComment(?string $SAGAnswerComment): void
    {
        $this->SAGAnswerComment = $SAGAnswerComment;
    }

    public function getSAGAnswerCreatedAt(): ?\DateTimeInterface
    {
        return $this->SAGAnswerCreatedAt;
    }

    public function setSAGAnswerCreatedAt(?\DateTimeInterface $SAGAnswerCreatedAt): void
    {
        $this->SAGAnswerCreatedAt = $SAGAnswerCreatedAt;
    }

    public function getSAGCountryCode(): ?string
    {
        return $this->SAGCountryCode;
    }

    public function setSAGCountryCode(?string $SAGCountryCode): void
    {
        $this->SAGCountryCode = $SAGCountryCode;
    }
}
