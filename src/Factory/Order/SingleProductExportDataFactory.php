<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Sylius\Component\Core\Model\OrderInterface;

class SingleProductExportDataFactory implements SingleProductExportDataFactoryInterface
{
    public function __invoke(
        ProductInterface $product,
        OrderInterface $order
    ): array {
        return [
            'id' => $product->getId(),
            'ean13' => $product->getSAGEan13(),
            'upc' => $product->getSAGUpc(),
            'name' => $product->getTranslation($order->getLocaleCode())->getName(),
        ];
    }
}
