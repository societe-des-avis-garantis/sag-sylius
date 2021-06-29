<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;
use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Review\Model\ReviewInterface;

trait ProductTrait
{
    /** @ORM\Column(type="string", name="sag_ean13", nullable=true) */
    protected $SAGEan13;

    /** @ORM\Column(type="string", name="sag_upc", nullable=true) */
    protected $SAGUpc;

    /**
     * @ORM\OneToMany(targetEntity="Dedi\SyliusSAGPlugin\Entity\RepartitionOfScores", mappedBy="product")
     */
    protected $repartionsOfScores;

    public function __construct() {
        $this->repartionsOfScores = new ArrayCollection();
    }

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

    public function getRepartitionOfScoresByCountryCode(
        ?string $countryCode
    ): ?RepartitionOfScoresInterface {
        $repartitionOfScores = $this->repartionsOfScores->filter(static function (RepartitionOfScoresInterface $repartitionOfScores) use($countryCode): bool {
            return $repartitionOfScores->getCountryCode() === $countryCode;
        })->first();

        if (false === $repartitionOfScores) {
            return null;
        }

        return $repartitionOfScores;
    }

    public function getAverageRatingByCountryCode(
        ?string $countryCode,
        int $outOf = 5
    ): float {
        $repartitionOfScores = $this->getRepartitionOfScoresByCountryCode($countryCode);
        if (null === $repartitionOfScores) {
            return 0;
        }

        return $repartitionOfScores->getAverageRating($outOf);
    }

    public function countReviewsForCountryCode(
        ?string $countryCode
    ): float {
        $repartitionOfScores = $this->getRepartitionOfScoresByCountryCode($countryCode);
        if (null === $repartitionOfScores) {
            return 0;
        }

        return $repartitionOfScores->countReviews();
    }

    public function getReviewRatingsRepartitionByCountryCode(
        ?string $countryCode
    ): array {
        $repartitionOfScores = $this->getRepartitionOfScoresByCountryCode($countryCode);
        if (null === $repartitionOfScores) {
            return array_fill(1, 5, 0);
        }

        return $repartitionOfScores->toArrayRepartition();
    }

    public function getAcceptedReviewsByCountryCode(
        ?string $countryCode
    ): Collection {
        return $this->reviews->filter(function (ProductReviewInterface $review) use($countryCode) : bool {
            return
                null !== $review->getSAGId() &&
                ReviewInterface::STATUS_ACCEPTED === $review->getStatus() &&
                $countryCode === $review->getSAGCountryCode()
                ;
        });
    }
}
