<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Dedi\SyliusSAGPlugin\Entity\RepartitionOfScoresInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface RepartitionOfScoresFactoryInterface extends FactoryInterface
{
    public function createNewForProductAndCountryCode(
        ProductInterface $product,
        string $countryCode
    ): RepartitionOfScoresInterface;
}
