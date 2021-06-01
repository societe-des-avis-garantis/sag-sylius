<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Review\Model\ReviewInterface;

trait ProductTrait
{
    /** @ORM\Column(type="string", name="sag_ean13", nullable=true) */
    protected $SAGEan13;

    /** @ORM\Column(type="string", name="sag_upc", nullable=true) */
    protected $SAGUpc;

    public function getSAGEan13(): ?string
    {
        return $this->SAGEan13;
    }

    public function setSAGEan13(?string $SAGEan13): ProductInterface
    {
        $this->SAGEan13 = $SAGEan13;

        return $this;
    }

    public function getSAGUpc(): ?string
    {
        return $this->SAGUpc;
    }

    public function setSAGUpc(?string $SAGUpc): ProductInterface
    {
        $this->SAGUpc = $SAGUpc;

        return $this;
    }

    public function getAcceptedReviewsByCountryCode(
        string $countryCode
    ): Collection {
        return $this->reviews->filter(function (ProductReviewInterface $review) use($countryCode) : bool {
            return
                ReviewInterface::STATUS_ACCEPTED === $review->getStatus() &&
                $countryCode === $review->getSAGCountryCode()
            ;
        });
    }

    public function getAverageRatingByCountryCode(
        string $countryCode,
        int $outOf = 5
    ): float {
        $reviews = $this->getAcceptedReviewsByCountryCode($countryCode);
        if ($reviews->count() === 0) {
            return 0;
        }

        $sum = array_reduce($reviews->toArray(), static function (int $carry, ReviewInterface $review) {
            return $review->getRating() ? $carry + $review->getRating() : $carry;
        }, 0);

        return (($sum / $reviews->count()) * $outOf) / 5;
    }

    public function getReviewRatingsRepartitionByCountryCode(
        string $countryCode
    ): array {
        $reviewValuesCount = array_fill(1, 5, 0);

        $reviews = $this->getAcceptedReviewsByCountryCode($countryCode);

        /** @var ProductReviewInterface $review */
        foreach ($reviews->toArray() as $review) {
            $reviewValuesCount[$review->getRating()]++;
        }

        return $reviewValuesCount;
    }
}
