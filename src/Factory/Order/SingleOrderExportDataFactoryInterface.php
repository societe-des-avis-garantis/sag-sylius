<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

use Sylius\Component\Core\Model\OrderInterface;

interface SingleOrderExportDataFactoryInterface
{
    public function __invoke(OrderInterface $order): array;
}
