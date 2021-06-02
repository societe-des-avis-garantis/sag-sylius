<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

interface ConfigurationContextInterface
{
    public function getOrderStatesToExport(): array;

    public function getOrderPaymentStatesToExport(): array;

    public function getOrderShippingStatesToExport(): array;

    public function getAvailableOrderStatesToExport(): array;

    public function getAvailableOrderPaymentStatesToExport(): array;

    public function getAvailableOrderShippingStatesToExport(): array;
}
