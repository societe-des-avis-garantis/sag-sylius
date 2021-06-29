<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Entity;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;

class RepartitionOfScores implements RepartitionOfScoresInterface
{
    /** @var mixed|null */
    protected $id;

    /** @var int */
    protected $oneStarCount = 0;

    /** @var int */
    protected $twoStarCount = 0;

    /** @var int */
    protected $threeStarCount = 0;

    /** @var int */
    protected $fourStarCount = 0;

    /** @var int */
    protected $fiveStarCount = 0;

    /**
     * @var ProductInterface
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $product;

    /**
     * @var string
     *
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected $countryCode;

    public function getId()
    {
        return $this->id;
    }

    public function incrementScore(?int $rating): RepartitionOfScoresInterface
    {
        if (null === $rating) {
            return $this;
        }

        switch ($rating) {
            case 1;
                $this->oneStarCount++;
                return $this;
            case 2;
                $this->twoStarCount++;
                return $this;
            case 3;
                $this->threeStarCount++;
                return $this;
            case 4;
                $this->fourStarCount++;
                return $this;
            case 5;
                $this->fiveStarCount++;
                return $this;
            default:
                throw new \LogicException(sprintf('Rating should be between 1 or 5, %s given', $rating));
        }
    }

    public function resetScores(): RepartitionOfScoresInterface
    {
        $this->oneStarCount = 0;
        $this->twoStarCount = 0;
        $this->threeStarCount = 0;
        $this->fourStarCount = 0;
        $this->fiveStarCount = 0;

        return $this;
    }

    public function countReviews(): int
    {
        return $this->oneStarCount + $this->twoStarCount + $this->threeStarCount + $this->fourStarCount + $this->fiveStarCount;
    }

    public function getAverageRating(int $outOf): float
    {
        $count = $this->countReviews();
        if (0 === $count) {
            return 0;
        }

        $sum = $this->oneStarCount;
        $sum += $this->twoStarCount * 2;
        $sum += $this->threeStarCount * 3;
        $sum += $this->fourStarCount * 4;
        $sum += $this->fiveStarCount * 5;

        return (($sum / $count) * $outOf) / 5;
    }

    public function toArrayRepartition(): array
    {
        return [
            1 => $this->oneStarCount,
            2 => $this->twoStarCount,
            3 => $this->threeStarCount,
            4 => $this->fourStarCount,
            5 => $this->fiveStarCount,
        ];
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setCountryCode(string $countryCode): RepartitionOfScoresInterface
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): RepartitionOfScoresInterface
    {
        $this->product = $product;

        return $this;
    }
}
