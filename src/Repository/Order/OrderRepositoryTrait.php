<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Repository\Order;

use Sylius\Component\Core\Model\OrderInterface;

trait OrderRepositoryTrait
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
    ): array {

        $query = $this->createQueryBuilder('o')
            ->andWhere('o.checkoutCompletedAt BETWEEN :from AND :to')
            ->setParameter('from', $from)
            ->setParameter('to', $to)
        ;

        if ([] !== $states) {
            $query->andWhere('o.state in (:states)')
                ->setParameter('states', $states)
            ;
        }

        if ([] !== $paymentStates) {
            $query->andWhere('o.paymentState in (:paymentStates)')
                ->setParameter('paymentStates', $paymentStates)
            ;
        }

        if ([] !== $shippingStates) {
            $query->andWhere('o.shippingState in (:shippingStates)')
                ->setParameter('shippingStates', $shippingStates)
            ;
        }

        return $query
            ->getQuery()
            ->getResult()
        ;
    }
}
