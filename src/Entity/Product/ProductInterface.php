<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface as BaseProductInterface;
use Sylius\Component\Review\Model\ReviewInterface;

interface ProductInterface extends BaseProductInterface
{
    public function getSAGEan13(): ?string;

    public function setSAGEan13(?string $SAGEan13): self;

    public function getSAGUpc(): ?string;

    public function setSAGUpc(?string $SAGUpc): self;

    public function getRepartitionOfScoresByCountryCode(
        ?string $countryCode
    ): ?RepartitionOfScoresInterface;

    public function countReviewsForCountryCode(
        ?string $countryCode
    ): float;

    public function getAverageRatingByCountryCode(
        ?string $countryCode,
        int $outOf = 5
    ): float;

    public function getReviewRatingsRepartitionByCountryCode(
        ?string $countryCode
    ): array;

    /**
     * @return Collection|ReviewInterface[]
     *
     * @psalm-return Collection<array-key, ReviewInterface>
     */
    public function getAcceptedReviewsByCountryCode(
        ?string $countryCode
    ): Collection;
}
