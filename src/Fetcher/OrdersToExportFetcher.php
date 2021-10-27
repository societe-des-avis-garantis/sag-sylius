<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Fetcher;

use Dedi\SyliusSAGPlugin\Context\ConfigurationContextInterface;
use Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryInterface;

class OrdersToExportFetcher implements OrdersToExportFetcherInterface
{
    /** @var ConfigurationContextInterface */
    private $configurationContext;

    /** @var OrderRepositoryInterface */
    private $orderRepository;

    public function __construct(
        ConfigurationContextInterface $configurationContext,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->configurationContext = $configurationContext;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(
        \DateTimeImmutable $from,
        \DateTimeImmutable $to
    ): array {
        return $this->orderRepository->findBetweenDatesAndWithStatus(
            $from,
            $to,
            $this->configurationContext->getOrderStatesToExport(),
            $this->configurationContext->getOrderPaymentStatesToExport(),
            $this->configurationContext->getOrderShippingStatesToExport()
        );
    }
}
