<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Updater;

use Dedi\SyliusSAGPlugin\Calculator\RepartitionOfScoresCalculatorInterface;
use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Review\Model\ReviewableInterface;

final class RepartitionOfScoresUpdater implements RepartitionOfScoresUpdaterInterface
{
    /** @var RepartitionOfScoresCalculatorInterface */
    private $repartitionOfScoresCalculator;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        RepartitionOfScoresCalculatorInterface $repartitionOfScoresCalculator,
        EntityManagerInterface $em
    ) {
        $this->repartitionOfScoresCalculator = $repartitionOfScoresCalculator;
        $this->em = $em;
    }

    public function __invoke(
        array $reviews,
        string $countryCode
    ): void {
        /** @var ProductInterface[] $productsToUpdate */
        $productsToUpdate = array_map(function (ProductReviewInterface $review): ?ReviewableInterface {
            return $review->getReviewSubject();
        }, $reviews);

        $productsToUpdate = array_unique($productsToUpdate);

        foreach ($productsToUpdate as $product) {
            $repartitionOfScores = $this->repartitionOfScoresCalculator->__invoke($product, $countryCode);

            $this->em->persist($repartitionOfScores);
        }

        $this->em->flush();
    }
}
