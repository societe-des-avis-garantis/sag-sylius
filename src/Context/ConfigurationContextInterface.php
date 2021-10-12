<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

interface ConfigurationContextInterface
{
    public function getOrderStatesToExport(): array;

    public function getOrderCheckoutStatesToExport(): array;

    public function getOrderPaymentStatesToExport(): array;

    public function getOrderShippingStatesToExport(): array;
}
