<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Calculator;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;

interface RepartitionOfScoresCalculatorInterface
{
    public function __invoke(
        ProductInterface $product,
        string $countryCode
    ): RepartitionOfScoresInterface;
}
