<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

class ConfigurationContext implements ConfigurationContextInterface
{
    public function getOrderStatesToExport(): array
    {
        return [];
    }

    public function getOrderCheckoutStatesToExport(): array
    {
        return [];
    }

    public function getOrderPaymentStatesToExport(): array
    {
        return [];
    }

    public function getOrderShippingStatesToExport(): array
    {
        return [];
    }
}
