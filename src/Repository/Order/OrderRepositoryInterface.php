<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Order;

use Sylius\Component\Core\Model\OrderInterface;

interface OrderRepositoryInterface
{
    /**
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     * @param array $states
     * @param array $paymentStates
     * @param array $shippingStates
     *
     * @return OrderInterface[]
     */
    public function findBetweenDatesAndWithStatus(
        \DateTimeImmutable $from,
        \DateTimeImmutable $to,
        array $states,
        array $paymentStates,
        array $shippingStates
    ): array;
}
