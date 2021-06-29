<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScores;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;

final class RepartitionOfScoresFactory implements RepartitionOfScoresFactoryInterface
{
    public function createNew(): RepartitionOfScoresInterface
    {
        return new RepartitionOfScores();
    }

    public function createNewForProductAndCountryCode(ProductInterface $product, string $countryCode): RepartitionOfScoresInterface
    {
        $repartitionOfScores = $this->createNew();

        $repartitionOfScores->setProduct($product);
        $repartitionOfScores->setCountryCode($countryCode);

        return $repartitionOfScores;
    }
}
