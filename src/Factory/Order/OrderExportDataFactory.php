<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

class OrderExportDataFactory implements OrderExportDataFactoryInterface
{
    /** @var SingleOrderExportDataFactoryInterface */
    private $singleOrderExportDataFactory;

    public function __construct(
        SingleOrderExportDataFactoryInterface $singleOrderExportDataFactory
    ) {
        $this->singleOrderExportDataFactory = $singleOrderExportDataFactory;
    }

    public function __invoke(array $orders): array
    {
        return array_map([$this->singleOrderExportDataFactory, '__invoke'], $orders);
    }
}
