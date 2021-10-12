<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Sylius\Component\Core\Model\OrderInterface;

interface SingleProductExportDataFactoryInterface
{
    public function __invoke(
        ProductInterface $product,
        OrderInterface $order
    ): array;
}
