<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Entity\Product;

use Dedi\SyliusSAGPlugin\Entity\Product\ProductInterface as DediSAGProductInterface;
use Dedi\SyliusSAGPlugin\Entity\Product\ProductTrait as DediSAGProductTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
class Product extends BaseProduct implements DediSAGProductInterface
{
    use DediSAGProductTrait;
}
