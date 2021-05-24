<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Factory\Order;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\OrderItemInterface;

class SingleOrderExportDataFactory implements SingleOrderExportDataFactoryInterface
{
    /** @var SingleProductExportDataFactoryInterface */
    private $singleProductExportDataFactory;

    public function __construct(
        SingleProductExportDataFactoryInterface $singleProductExportDataFactory
    ) {
        $this->singleProductExportDataFactory = $singleProductExportDataFactory;
    }

    public function __invoke(OrderInterface $order): array
    {
        return [
            'id_order' => $order->getId(),
            'reference' => $order->getNumber(),
            'order_date' => $this->getCreatedAt($order),
            'total_paid_tax_incl' => $this->getTotalPaidTaxIncluded($order),
            'firstname' => $this->getFirstName($order),
            'lastname' => $this->getLastName($order),
            'email' => $this->getEmail($order),
            'shipping_country' => $this->getShippingCountryCode($order),
            'products' => array_map(function (OrderItemInterface $item) use ($order): array {
                /** @var ProductInterface|null $product */
                $product =  $item->getProduct();

                return null !== $product ? $this->singleProductExportDataFactory->__invoke($product, $order) : [];
            }, $order->getItems()->toArray()),
        ];
    }

    private function getCreatedAt(OrderInterface $order): ?string
    {
        $createdAt = $order->getCreatedAt();
        if (null !== $createdAt) {
            return $createdAt->format('Y-m-d  G:i:s');
        }

        return null;
    }

    private function getTotalPaidTaxIncluded(OrderInterface $order): string
    {
        return number_format(
            $order->getTotal() / 100,
            2,
            '.',
            ''
        );
    }

    private function getFirstName(OrderInterface $order): ?string
    {
        $customer = $order->getCustomer();
        if (null !== $customer && null !== $customer->getFirstName()) {
            return $customer->getFirstName();
        }

        $shippingAddress = $order->getShippingAddress();
        if (null !== $shippingAddress) {
            return $shippingAddress->getFirstName();
        }

        return null;
    }

    private function getLastName(OrderInterface $order): ?string
    {
        $customer = $order->getCustomer();
        if (null !== $customer && null !== $customer->getLastName()) {
            return $customer->getLastName();
        }

        $shippingAddress = $order->getShippingAddress();
        if (null !== $shippingAddress) {
            return $shippingAddress->getLastName();
        }

        return null;
    }

    private function getEmail(OrderInterface $order): ?string
    {
        $customer = $order->getCustomer();
        if (null !== $customer) {
            return $customer->getEmail();
        }

        return null;
    }

    private function getShippingCountryCode(OrderInterface $order): ?string
    {
        $shippingAddress = $order->getShippingAddress();
        if (null !== $shippingAddress) {
            return $shippingAddress->getCountryCode();
        }

        return null;
    }
}
