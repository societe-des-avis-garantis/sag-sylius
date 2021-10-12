<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Fetcher;

use Sylius\Component\Core\Model\OrderInterface;

interface OrdersToExportFetcherInterface
{
    /**
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     *
     * @return OrderInterface[]
     */
    public function __invoke(
        \DateTimeImmutable $from,
        \DateTimeImmutable $to
    ): array;
}
