<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Review;

use Sylius\Component\Review\Model\ReviewInterface;

interface ProductReviewInterface extends ReviewInterface
{
    public const SAG_STATE_IN_REVIEW = '0';

    public const SAG_STATE_VALID = '1';

    public const SAG_STATE_DELETED = '2';

    public const SYLIUS_TO_SAG_STATUS = [
        ReviewInterface::STATUS_NEW => self::SAG_STATE_IN_REVIEW,
        ReviewInterface::STATUS_ACCEPTED => self::SAG_STATE_VALID,
        ReviewInterface::STATUS_REJECTED => self::SAG_STATE_DELETED,
    ];

    public function getSAGId(): ?string;

    public function setSAGId(?string $SAGId): void;

    public function getSAGStatus(): ?string;

    public function setSAGStatus(?string $SAGStatus): void;

    public function getSAGAnswerComment(): ?string;

    public function setSAGAnswerComment(?string $SAGAnswerComment): void;

    public function getSAGAnswerCreatedAt(): ?\DateTimeInterface;

    public function setSAGAnswerCreatedAt(?\DateTimeInterface $SAGAnswerCreatedAt): void;

    public function getSAGCountryCode(): ?string;

    public function setSAGCountryCode(?string $SAGCountryCode): void;
}
