<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Calculator;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;
use Dedi\SyliusSAGPlugin\Factory\RepartitionOfScoresFactoryInterface;

class RepartitionOfScoresCalculator implements RepartitionOfScoresCalculatorInterface
{
    /** @var RepartitionOfScoresFactoryInterface */
    private $repartitionOfScoresFactory;

    public function __construct(
        RepartitionOfScoresFactoryInterface $repartitionOfScoresFactory
    ) {
        $this->repartitionOfScoresFactory = $repartitionOfScoresFactory;
    }

    public function __invoke(
        ProductInterface $product,
        string $countryCode
    ): RepartitionOfScoresInterface {
        $repartitionOfScores = $this->getRepartitionOfScores($product, $countryCode);

        $repartitionOfScores->resetScores();
        $reviews = $product->getAcceptedReviewsByCountryCode($countryCode);
        foreach ($reviews as $review) {
            $repartitionOfScores->incrementScore($review->getRating());
        }

        return $repartitionOfScores;
    }

    private function getRepartitionOfScores(
        ProductInterface $product,
        string $countryCode
    ): RepartitionOfScoresInterface {
        $repartitionOfScores = $product->getRepartitionOfScoresByCountryCode($countryCode);
        if (null !== $repartitionOfScores) {
            return $repartitionOfScores;
        }

        return $this->repartitionOfScoresFactory->createNewForProductAndCountryCode(
            $product,
            $countryCode
        );
    }
}
