<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Repository\Order;

use Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryInterface as DediSAGOrderRepositoryInterface;
use Dedi\SyliusSAGPlugin\Repository\Order\OrderRepositoryTrait as DediSAGOrderRepositoryTrait;
use Sylius\Bundle\CoreBundle\Doctrine\ORM\OrderRepository as BaseOrderRepository;

class OrderRepository extends BaseOrderRepository implements DediSAGOrderRepositoryInterface
{
    use DediSAGOrderRepositoryTrait;
}
