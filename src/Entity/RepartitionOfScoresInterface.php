<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface RepartitionOfScoresInterface extends ResourceInterface
{
    public function incrementScore(?int $rating): self;

    public function resetScores(): self;

    public function countReviews(): int;

    public function getAverageRating(int $outOf): float;

    public function toArrayRepartition(): array;

    public function getCountryCode(): string;

    public function setCountryCode(string $countryCode): self;

    public function getProduct(): ProductInterface;

    public function setProduct(ProductInterface $product): self;
}
