<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Context;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\OrderPaymentStates;
use Sylius\Component\Core\OrderShippingStates;

class ConfigurationContext implements ConfigurationContextInterface
{
    /** @var ApiKeyContextInterface */
    private $apiKeyContext;

    public function __construct(
        ApiKeyContextInterface $apiKeyContext
    ) {
        $this->apiKeyContext = $apiKeyContext;
    }

    public function getOrderStatesToExport(): array
    {
        $key = $this->apiKeyContext->getApiKey();
        if (null === $key) {
            return [];
        }

        return $key->getOrderStatesToExport();
    }

    public function getOrderPaymentStatesToExport(): array
    {
        $key = $this->apiKeyContext->getApiKey();
        if (null === $key) {
            return [];
        }

        return $key->getOrderPaymentStatesToExport();
    }

    public function getOrderShippingStatesToExport(): array
    {
        $key = $this->apiKeyContext->getApiKey();
        if (null === $key) {
            return [];
        }

        return $key->getOrderShippingStatesToExport();
    }

    public function getAvailableOrderStatesToExport(): array
    {
        return [
            OrderInterface::STATE_NEW,
            OrderInterface::STATE_CANCELLED,
            OrderInterface::STATE_FULFILLED,
        ];
    }

    public function getAvailableOrderPaymentStatesToExport(): array
    {
        return [
            OrderPaymentStates::STATE_AWAITING_PAYMENT,
            OrderPaymentStates::STATE_PARTIALLY_AUTHORIZED,
            OrderPaymentStates::STATE_AUTHORIZED,
            OrderPaymentStates::STATE_PARTIALLY_PAID,
            OrderPaymentStates::STATE_CANCELLED,
            OrderPaymentStates::STATE_PAID,
            OrderPaymentStates::STATE_PARTIALLY_REFUNDED,
            OrderPaymentStates::STATE_REFUNDED,
        ];
    }

    public function getAvailableOrderShippingStatesToExport(): array
    {
        return [
            OrderShippingStates::STATE_READY,
            OrderShippingStates::STATE_CANCELLED,
            OrderShippingStates::STATE_PARTIALLY_SHIPPED,
            OrderShippingStates::STATE_SHIPPED,
        ];
    }
}
