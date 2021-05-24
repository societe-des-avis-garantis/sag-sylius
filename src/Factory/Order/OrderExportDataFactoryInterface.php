<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

use Sylius\Component\Core\Model\OrderInterface;

interface OrderExportDataFactoryInterface
{
    /**
     * @param OrderInterface[] $orders
     *
     * @return array
     */
    public function __invoke(array $orders): array;
}
