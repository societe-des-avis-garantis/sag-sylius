<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Review;

use Sylius\Component\Review\Model\ReviewInterface;

interface ProductReviewInterface extends ReviewInterface
{
    public function setId(?int $id): void;

    public function getSAGId(): ?string;

    public function setSAGId(?string $SAGId): self;

    public function getSAGAnswerComment(): ?string;

    public function setSAGAnswerComment(?string $SAGAnswerComment): self;

    public function getSAGAnswerCreatedAt(): ?\DateTimeInterface;

    public function setSAGAnswerCreatedAt(?\DateTimeInterface $SAGAnswerCreatedAt): self;

    public function getSAGCountryCode(): ?string;

    public function setSAGCountryCode(?string $SAGCountryCode): self;
}
