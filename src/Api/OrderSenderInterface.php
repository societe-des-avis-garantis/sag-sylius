<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Api;

use Dedi\SyliusSAGPlugin\Model\Api\ApiTokenAwareRequestInterface;
use Sylius\Component\Core\Model\OrderInterface;

interface OrderSenderInterface
{
    /**
     * @param ApiTokenAwareRequestInterface $request
     * @param OrderInterface[] $orders
     *
     * @throws \Exception
     */
    public function __invoke(
        ApiTokenAwareRequestInterface $request,
        array $orders
    ): void;
}
