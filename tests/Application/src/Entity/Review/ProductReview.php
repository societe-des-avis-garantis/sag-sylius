<?php

declare(strict_types=1);

namespace Tests\Dedi\SyliusSAGPlugin\Application\src\Entity\Review;

use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewInterface as DediSAGProductReviewInterface;
use Dedi\SyliusSAGPlugin\Entity\Review\ProductReviewTrait as DediSAGProductReviewTrait;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\ProductReview as BaseProductReview;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product_review")
 */
class ProductReview extends BaseProductReview implements DediSAGProductReviewInterface
{
    use DediSAGProductReviewTrait;
}
